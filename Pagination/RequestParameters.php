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
     * @var array
     */
    protected $options = [];

    /**
     * RequestParameters constructor.
     * @param int $currentPage
     * @param int $itemsPerPage
     * @param array $options
     */
    public function __construct(int $currentPage, int $itemsPerPage, array $options = [])
    {
        $this->currentPage = $currentPage;
        $this->itemsPerPage = $itemsPerPage;
        $this->options = $options;
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

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     * @throws \LogicException
     */
    public function addOption($key, $value)
    {
        if (isset($this->options[$key])) {
            new \LogicException('Option already exist');
        }

        $this->options[$key] = $value;

        return $this;
    }

    public function getOption($key)
    {
        return $this->options[$key] ?? null;
    }
}