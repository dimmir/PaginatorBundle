<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Pagination;

use DMR\Bundle\PaginatorBundle\Exception\RuntimeException;
use DMR\Bundle\PaginatorBundle\Factory\DoctrineOrmPaginatorFactory;
use DMR\Bundle\PaginatorBundle\Pagination\PaginationService;
use DMR\Bundle\PaginatorBundle\Pagination\RequestResolver;
use DMR\Bundle\PaginatorBundle\Paginator\DoctrineOrmPaginator;
use DMR\Bundle\PaginatorBundle\Tests\Fixtures\Query;
use Doctrine\ORM\QueryBuilder;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class PaginationServiceTest extends TestCase
{
    /**
     * @dataProvider dataProvider
     */
    public function testPaginationService($defaultItemsPerPage, $maxItemsPerPage, $currentPage)
    {
        $service = $this->getPaginationService($defaultItemsPerPage, $maxItemsPerPage, false, $currentPage);

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

        $paginator = $service->pagination($queryBuilder->reveal());

        $this->assertInstanceOf(DoctrineOrmPaginator::class, $paginator);
        $this->assertEquals($currentPage, $paginator->getCurrentPage());
        $this->assertEquals($defaultItemsPerPage, $paginator->getNumberItemsPerPage());
    }

    /**
     * @expectedException RuntimeException
     */
    public function testEmptyCurrentRequest()
    {
        $factory = new DoctrineOrmPaginatorFactory();
        $requestResolver =  $this->prophesize(RequestResolver::class);
        $requestStack = $this->prophesize(RequestStack::class);
        $eventDispatcher = $this->prophesize(EventDispatcher::class);
        $queryBuilder = $this->prophesize(QueryBuilder::class);

        $paginator = new PaginationService(
            [$factory->getTargetClass() => $factory],
            $requestResolver->reveal(),
            $requestStack->reveal(),
            $eventDispatcher->reveal()
        );

        $paginator->pagination($queryBuilder->reveal());
    }

    protected function getPaginationService($defaultItemsPerPage, $maxItemsPerPage, $clientItemsPerPageEnabled, $currentPage)
    {
        $factory = new DoctrineOrmPaginatorFactory();
        $requestResolver = new RequestResolver($defaultItemsPerPage, $maxItemsPerPage, $clientItemsPerPageEnabled, 'page', 'items_per_page');

        $requestStack = $this->prophesize(RequestStack::class);

        $request = new Request([
            'page' => $currentPage
        ]);

        $requestStack->getCurrentRequest()->will(function () use ($request) {
            return $request;
        });

        $eventDispatcher = new EventDispatcher();

        return new PaginationService(
            [$factory->getTargetClass() => $factory],
            $requestResolver,
            $requestStack->reveal(),
            $eventDispatcher
        );
    }

    public function dataProvider()
    {
        return [
            [25, 50, 1],
            [20, 20, 2],
        ];
    }
}
