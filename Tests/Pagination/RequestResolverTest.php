<?php

namespace DMR\Bundle\PaginatorBundle\Tests\Pagination;

use DMR\Bundle\PaginatorBundle\Pagination\RequestParameters;
use DMR\Bundle\PaginatorBundle\Pagination\RequestResolver;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

class RequestResolverTest extends TestCase
{
    /**
     * @dataProvider parametersProvider
     */
    public function testResolve($defaultItemsPerPage, $maxItemsPerPage, $clientItemsPerPageEnabled, $itemsPerPage, $currentPage, $requestItemsPerPage)
    {
        $request = new Request([
            'page' => $currentPage,
            'items_per_page' => $requestItemsPerPage
        ]);

        $resolver = new RequestResolver($defaultItemsPerPage, $maxItemsPerPage, $clientItemsPerPageEnabled, 'page', 'items_per_page');

        $requestParameters = $resolver->resolve($request);

        $this->assertInstanceOf(RequestParameters::class, $requestParameters);
        $this->assertEquals($currentPage, $requestParameters->getCurrentPage());
        $this->assertEquals($itemsPerPage, $requestParameters->getItemsPerPage());
    }

    public function parametersProvider()
    {
        return [
            'Client items per page disabled' => [25, 50, false, 25, 1, 20],
            'Client items per page enabled' => [25, 50, true, 20, 1, 20],
            'Over max items per page' => [55, 50, false, 50, 1, 20],
            'Over max items per page, client enabled' => [25, 50, true, 50, 1, 56],
            'Unlimited items per page' => [25, null, true, 555, 1, 555],
        ];
    }

    protected function getRequest()
    {

    }
}
