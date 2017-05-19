<?php

namespace DMR\Bundle\PaginatorBundle\Representation;

use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;

class CollectionRepresentation
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

    public function getPagination()
    {
        return $this->paginator;
    }
}