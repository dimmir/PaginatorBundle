<?php

namespace DMR\Bundle\PaginatorBundle\Pagination;

use Symfony\Component\HttpFoundation\Request;

class RequestResolver
{
    /**
     * @var int
     */
    protected $defaultItemsPerPage;

    /**
     * @var int
     */
    protected $maxItemsPerPage;

    /**
     * @var bool
     */
    protected $clientItemsPerPageEnabled;

    /**
     * @var string
     */
    protected $pageRequestParameterName;

    /**
     * @var string
     */
    protected $itemsPerPageRequestParameterName;

    /**
     * @var array
     */
    protected $options;

    /**
     * RequestResolver constructor.
     * @param int $defaultItemsPerPage
     * @param int $maxItemsPerPage
     * @param bool $clientItemsPerPageEnabled
     * @param string $pageRequestParameterName
     * @param string $itemsPerPageRequestParameterName
     * @param array $options
     */
    public function __construct($defaultItemsPerPage, $maxItemsPerPage, $clientItemsPerPageEnabled, $pageRequestParameterName, $itemsPerPageRequestParameterName, $options = [])
    {
        $this->defaultItemsPerPage = $defaultItemsPerPage;
        $this->maxItemsPerPage = $maxItemsPerPage;
        $this->clientItemsPerPageEnabled = $clientItemsPerPageEnabled;
        $this->pageRequestParameterName = $pageRequestParameterName;
        $this->itemsPerPageRequestParameterName = $itemsPerPageRequestParameterName;
        $this->options = $options;
    }


    /**
     * @param Request $request
     * @return RequestParameters
     */
    public function resolve(Request $request): RequestParameters
    {
        $itemsPerPage = $this->isClientItemsPerPageEnabled()
            ? $request->query->getInt($this->getItemsPerPageRequestParameterName(), $this->getDefaultItemsPerPage())
            : $this->getDefaultItemsPerPage();

        $itemsPerPage = null !== $this->getMaxItemsPerPage() && $itemsPerPage > $this->getMaxItemsPerPage()
            ? $this->getMaxItemsPerPage()
            : $itemsPerPage;

        return new RequestParameters(
            $request->query->getInt($this->getPageRequestParameterName(), 1),
            $itemsPerPage,
            $this->getOptions()
        );
    }

    /**
     * @return bool
     */
    public function isClientItemsPerPageEnabled(): bool
    {
        return $this->clientItemsPerPageEnabled;
    }

    /**
     * @return string
     */
    public function getItemsPerPageRequestParameterName(): string
    {
        return $this->itemsPerPageRequestParameterName;
    }

    /**
     * @return int
     */
    public function getDefaultItemsPerPage(): int
    {
        return $this->defaultItemsPerPage;
    }

    /**
     * @return int|null
     */
    public function getMaxItemsPerPage()
    {
        return $this->maxItemsPerPage;
    }

    /**
     * @return string
     */
    public function getPageRequestParameterName(): string
    {
        return $this->pageRequestParameterName;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}