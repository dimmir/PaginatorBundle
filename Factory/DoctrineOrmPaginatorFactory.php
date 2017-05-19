<?php

namespace DMR\Bundle\PaginatorBundle\Factory;

use DMR\Bundle\PaginatorBundle\Exception\RuntimeException;
use DMR\Bundle\PaginatorBundle\Pagination\RequestParameters;
use DMR\Bundle\PaginatorBundle\Paginator\DoctrineOrmPaginator;
use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DoctrineOrmPaginatorFactory implements PaginatorFactoryInterface
{
    /**
     * @param QueryBuilder $target
     * @param RequestParameters $requestParameters
     * @return PaginatorInterface
     */
    public function create($target, RequestParameters $requestParameters): PaginatorInterface
    {
        if (empty($requestParameters->getCurrentPage()) || empty($requestParameters->getItemsPerPage())) {
            throw new RuntimeException('CurrentPage or ItemsPerPage parameters are empty for RequestParameters instance');
        }

        $target
            ->setFirstResult(($requestParameters->getCurrentPage() - 1) * $requestParameters->getItemsPerPage())
            ->setMaxResults($requestParameters->getItemsPerPage());

        $doctrinePaginator = new Paginator($target, $requestParameters->getOption('fetch_join_collection') ?: true);

        return new DoctrineOrmPaginator($doctrinePaginator);
    }

    public function getTargetClass(): string
    {
        return QueryBuilder::Class;
    }
}