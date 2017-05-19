<?php

namespace DMR\Bundle\PaginatorBundle\Event;

use DMR\Bundle\PaginatorBundle\Pagination\RequestParameters;
use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;
use Symfony\Component\EventDispatcher\Event;

class PaginationEvent extends Event
{
    /**
     * @var mixed
     */
    protected $target;

    /**
     * @var RequestParameters
     */
    protected $requestParameters;

    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param mixed $target
     *
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return RequestParameters
     */
    public function getRequestParameters(): RequestParameters
    {
        return $this->requestParameters;
    }

    /**
     * @param RequestParameters $requestParameters
     *
     * @return $this
     */
    public function setRequestParameters(RequestParameters $requestParameters)
    {
        $this->requestParameters = $requestParameters;

        return $this;
    }

    /**
     * @return PaginatorInterface|null
     */
    public function getPaginator()
    {
        return $this->paginator;
    }

    /**
     * @param PaginatorInterface $paginator
     *
     * @return $this
     */
    public function setPaginator($paginator)
    {
        $this->paginator = $paginator;

        return $this;
    }
}