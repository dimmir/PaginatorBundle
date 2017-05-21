<?php

namespace DMR\Bundle\PaginatorBundle\Pagination;

class RequestParameters
{
    /**
     * @var int
     */
    protected $currentPage;

    /**
     * @var int
     */
    protected $itemsPerPage;

    /**
     * RequestParameters constructor.
     * @param int $currentPage
     * @param int $itemsPerPage
     */
    public function __construct(int $currentPage, int $itemsPerPage)
    {
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     *
     * @return $this
     */
    public function setCurrentPage(int $currentPage)
    {
        $this->currentPage = $currentPage;

        return $this;
    }

    /**
     * @return int
     */
    public function getItemsPerPage(): int
    {
        return $this->itemsPerPage;
    }

    /**
     * @param int $itemsPerPage
     *
     * @return $this
     */
    public function setItemsPerPage(int $itemsPerPage)
    {
        $this->itemsPerPage = $itemsPerPage;

        return $this;
    }
}