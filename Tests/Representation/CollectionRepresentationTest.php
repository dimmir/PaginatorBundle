<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Representation;

use DMR\Bundle\PaginatorBundle\Paginator\PaginatorInterface;
use DMR\Bundle\PaginatorBundle\Representation\CollectionRepresentation;
use JMS\Serializer\SerializerBuilder;
use PHPUnit\Framework\TestCase;

class CollectionRepresentationTest extends TestCase
{
    public function testGetters()
    {
        $representation = new CollectionRepresentation($this->getPaginator());

        $this->assertInstanceOf('\ArrayIterator', $representation->getItems());
        $this->assertInstanceOf(PaginatorInterface::class, $representation->getPagination());
    }

    protected function getPaginator($currentPage = 1, $itemsPerPage = 25, $countItems = 40, $countPages = 2)
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
