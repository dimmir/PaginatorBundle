<?php

namespace DMR\Bundle\PaginatorBundle\Pagination;

use DMR\Bundle\PaginatorBundle\Event\Events;
use DMR\Bundle\PaginatorBundle\Event\PaginationEvent;
use DMR\Bundle\PaginatorBundle\Exception\RuntimeException;
use DMR\Bundle\PaginatorBundle\Factory\PaginatorFactoryInterface;
use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationService
{
    /**
     * array with structure: target class => Paginator factory for this class (key => value)
     *
     * @var PaginatorFactoryInterface[]
     */
    protected $paginatorFactories = [];

    /**
     * @var RequestResolver
     */
    protected $requestResolver;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * PaginationService constructor.
     * @param PaginatorFactoryInterface[] $paginatorFactories
     * @param RequestResolver $requestResolver
     * @param RequestStack $requestStack
     * @param EventDispatcherInterface $eventDispatcher
     * @param array $options
     */
    public function __construct(array $paginatorFactories, RequestResolver $requestResolver, RequestStack $requestStack, EventDispatcherInterface $eventDispatcher, array $options = [])
    {
        $this->paginatorFactories = $paginatorFactories;
        $this->requestResolver = $requestResolver;
        $this->requestStack = $requestStack;
        $this->eventDispatcher = $eventDispatcher;
        $this->options = $options;
    }


    /**
     * @param $target
     * @param null $requestParameters
     * @param array $options
     * @return PaginatorInterface
     */
    public function pagination($target, $requestParameters = null, array $options = [])
    {
        $requestParameters = $requestParameters ?: $this->createRequestParameters();

        $paginationEvent = new PaginationEvent();
        $paginationEvent->setTarget($target)
            ->setRequestParameters($requestParameters)
            ->setOptions(array_merge($this->options, $options));

        $this->eventDispatcher->dispatch(Events::PAGINATOR_BEFORE_PAGINATION, $paginationEvent);

        return $paginationEvent->getPaginator() instanceof PaginatorInterface
            ? $paginationEvent->getPaginator()
            : $this->createPaginator(
                $paginationEvent->getTarget(),
                $paginationEvent->getRequestParameters(),
                $paginationEvent->getOptions()
            );
    }

    /**
     * @return RequestParameters
     */
    private function createRequestParameters()
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            throw new RuntimeException('Current Request not found');
        }

        return $this->requestResolver->resolve($request);
    }

    /**
     * @param $target
     * @param RequestParameters $requestParameters
     * @param array $options
     * @return PaginatorInterface
     */
    private function createPaginator($target, RequestParameters $requestParameters, array $options = [])
    {
        foreach ($this->paginatorFactories as $className => $factory) {
            if ($target instanceof $className) {
                $currentFactory = $factory;
                break;
            }
        }

        if (empty($currentFactory) || !($currentFactory instanceof PaginatorFactoryInterface)) {
            throw new RuntimeException(sprintf('For the object of %s class there is no Paginator', get_class($target)));
        }

        return $currentFactory->create($target, $requestParameters, $options);
    }
}