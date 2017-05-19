<?php

namespace DMR\Bundle\PaginatorBundle\Representation;

use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;

class SliderRepresentation
{
    /**
     * @var PaginatorInterface
     */
    protected $paginator;

    /**
     * CollectinRepresentation constructor.
     * @param PaginatorInterface $paginator
     */
    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    public function getItems()
    {
        return $this->paginator->getIterator();
    }

    public function getPreviusPage()
    {
        return $this->paginator->getCurrentPage() > 1 ? $this->paginator->getCurrentPage() - 1 : null;
    }

    public function getNextPage()
    {
        return $this->paginator->getCountPages() > 1 && $this->paginator->getCurrentPage() < $this->paginator->getCountPages()
            ? $this->paginator->getCurrentPage() + 1
            : null;
    }
}