<?php

namespace DMR\Bundle\PaginatorBundle\Factory;

use DMR\Bundle\PaginatorBundle\Pagination\RequestParameters;
use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;

interface PaginatorFactoryInterface
{
    /**
     * @param $target
     * @param RequestParameters $config
     * @return PaginatorInterface
     */
    public function create($target, RequestParameters $requestParameters): PaginatorInterface;

    /**
     * return name of class for target
     *
     * @return string
     */
    public function getTargetClass(): string;
}