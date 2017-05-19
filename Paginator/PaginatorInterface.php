<?php

namespace DMR\Bundle\PaginatorBundle\Paginator;

interface PaginatorInterface extends \IteratorAggregate, \Countable
{
    const DEFAULT_NUMBER_ITEMS_PER_PAGE = 20;

    /**
     * Gets the current page number.
     *
     * @return int
     */
    public function getCurrentPage(): int;

    /**
     * Gets the number of items by page.
     *
     * @return int
     */
    public function getNumberItemsPerPage(): int;

    /**
     * Gets the number of items.
     *
     * @return int
     */
    public function getCountItems(): int;

    /**
     * Gets the number of items.
     *
     * @return int
     */
    public function getCountPages(): int;
}