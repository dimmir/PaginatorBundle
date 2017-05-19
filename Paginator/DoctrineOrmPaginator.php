<?php

namespace DMR\Bundle\PaginatorBundle\Paginator;


use Doctrine\ORM\Tools\Pagination\Paginator;

class DoctrineOrmPaginator implements PaginatorInterface
{
    /**
     * @var Paginator
     */
    protected $paginator;

    /**
     * @var \Traversable
     */
    protected $iterator;

    /**
     * DoctrineOrmPaginator constructor.
     * @param Paginator $paginator
     */
    public function __construct(Paginator $paginator)
    {
        $this->paginator = $paginator;
    }

    public function count()
    {
        return count($this->getIterator());
    }

    public function getIterator()
    {
        if (null === $this->iterator) {
            $this->iterator = $this->paginator->getIterator();
        }

        return $this->iterator;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        $query = $this->paginator->getQuery();

        return floor($query->getFirstResult() / $query->getMaxResults()) + 1;
    }

    public function getCountPages(): int
    {
        return ceil($this->getCountItems() / $this->getNumberItemsPerPage());
    }

    public function getCountItems(): int
    {
        return count($this->paginator);
    }

    public function getNumberItemsPerPage(): int
    {
        return $this->paginator->getQuery()->getMaxResults();
    }
}