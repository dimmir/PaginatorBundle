<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Factory;

use DMR\Bundle\PaginatorBundle\Exception\RuntimeException;
use DMR\Bundle\PaginatorBundle\Factory\DoctrineOrmPaginatorFactory;
use DMR\Bundle\PaginatorBundle\Pagination\RequestParameters;
use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;
use DMR\Bundle\PaginatorBundle\Tests\Fixtures\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;

class DoctrineOrmPaginatorFactoryTest extends TestCase
{
    /**
     * @dataProvider parametersProvider
     */
    public function testCreate($currentPage, $itemsPerPage)
    {
        $queryBuilder = $this->prophesize(QueryBuilder::class);
        $query = $this->prophesize(Query::class);

        $queryBuilder->setFirstResult(Argument::type('int'))->will(function ($args) use ($query) {
            $query->getFirstResult()->willReturn($args[0]);
            return $this;
        });

        $queryBuilder->setMaxResults(Argument::type('int'))->will(function ($args) use ($query) {
            $query->getMaxResults()->willReturn($args[0]);
        });

        $queryBuilder->getQuery()->will(function () use ($query) {
            return $query->reveal();
        });

        $requestParameters = new RequestParameters($currentPage, $itemsPerPage);

        $paginatorFactory = new DoctrineOrmPaginatorFactory();
        $paginator = $paginatorFactory->create($queryBuilder->reveal(), $requestParameters);

        $this->assertInstanceOf(PaginatorInterface::class, $paginator);
        $this->assertEquals($currentPage, $paginator->getCurrentPage());
        $this->assertEquals($itemsPerPage, $paginator->getNumberItemsPerPage());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testException()
    {
        $queryBuilder = $this->prophesize(QueryBuilder::class);
        $requestParameters = new RequestParameters(0, 0);

        $paginatorFactory = new DoctrineOrmPaginatorFactory();
        $paginatorFactory->create($queryBuilder->reveal(), $requestParameters);
    }

    public function parametersProvider()
    {
        return [
            [1, 20],
            [2, 20]
        ];
    }
}
