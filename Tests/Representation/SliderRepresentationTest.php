<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Representation;

use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;
use DMR\Bundle\PaginatorBundle\Representation\SliderRepresentation;
use PHPUnit\Framework\TestCase;

class SliderRepresentationTest extends TestCase
{
    public function testGetters()
    {
        $currentPage = 2;
        $representation = new SliderRepresentation($this->getPaginator($currentPage));

        $this->assertInstanceOf('\ArrayIterator', $representation->getItems());
        $this->assertEquals($currentPage - 1, $representation->getPreviusPage());
        $this->assertEquals($currentPage + 1, $representation->getNextPage());
    }

    protected function getPaginator($currentPage = 2, $itemsPerPage = 25, $countItems = 60, $countPages = 3)
    {
        $paginator = $this->prophesize(PaginatorInterface::class);

        $paginator->getIterator()->will(function () {
            return new \ArrayIterator();
        });

        $paginator->getCurrentPage()->willReturn($currentPage);
        $paginator->getNumberItemsPerPage()->willReturn($itemsPerPage);
        $paginator->getCountItems()->willReturn($countItems);
        $paginator->getCountPages()->willReturn($countPages);

        return $paginator->reveal();
    }
}
