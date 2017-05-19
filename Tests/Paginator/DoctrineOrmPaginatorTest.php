<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Paginator;

use DMR\Bundle\PaginatorBundle\Paginator\DoctrineOrmPaginator;
use DMR\Bundle\PaginatorBundle\Tests\Fixtures\Query;
use Doctrine\ORM\Tools\Pagination\Paginator;
use PHPUnit\Framework\TestCase;

class DoctrineOrmPaginatorTest extends TestCase
{
    /**
     * @dataProvider paginationProvider
     */
    public function testPagination($firstResult, $maxResults, $itemsCount, $currentPage, $pagesCount)
    {
        $paginator = $this->getPaginator($firstResult, $maxResults, $itemsCount);

        $this->assertEquals($currentPage, $paginator->getCurrentPage());
        $this->assertEquals($pagesCount, $paginator->getCountPages());
        $this->assertEquals($itemsCount, $paginator->getCountItems());
        $this->assertEquals($maxResults, $paginator->getNumberItemsPerPage());
    }

    protected function getPaginator($firstResult, $maxResults, $countItems)
    {
        $query = $this->prophesize(Query::class);
        $query->getFirstResult()->willReturn($firstResult)->shouldBeCalled();
        $query->getMaxResults()->willReturn($maxResults)->shouldBeCalled();

        $doctrinePaginator = $this->prophesize(Paginator::class);

        $doctrinePaginator->getQuery()->willReturn($query->reveal())->shouldBeCalled();
        $doctrinePaginator->count()->willReturn($countItems)->shouldBeCalled();

        $doctrinePaginator->getIterator()->will(function () {
            return new \ArrayIterator();
        });

        return new DoctrineOrmPaginator($doctrinePaginator->reveal());
    }

    public function testIterator()
    {
        $doctrinePaginator = $this->prophesize(Paginator::class);
        $doctrinePaginator->getIterator()->will(function () {
            return new \ArrayIterator();
        });

        $paginator = new DoctrineOrmPaginator($doctrinePaginator->reveal());

        $this->assertInstanceOf("\ArrayIterator", $paginator->getIterator());
        $this->assertSame($paginator->getIterator(), $paginator->getIterator());
    }

    public function paginationProvider()
    {
        return [
            'First of three pages' => [0, 25, 55, 1, 3],
            'Second of two pages' => [20, 20, 40, 2, 2],
        ];
    }
}
