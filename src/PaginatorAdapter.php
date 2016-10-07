<?php

namespace Tequilarapido\ApiResponse;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use League\Fractal\Pagination\PaginatorInterface;

class PaginatorAdapter implements PaginatorInterface
{

    /**
     * @var LengthAwarePaginator
     */
    private $paginator;

    /**
     * PaginatorAdapter constructor.
     *
     * @param LengthAwarePaginator $paginator
     */
    public function __construct(LengthAwarePaginator $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @return integer
     */
    public function getCurrentPage()
    {
        return $this->paginator->currentPage();
    }

    /**
     * @return integer
     */
    public function getLastPage()
    {
        return $this->paginator->lastPage();
    }

    /**
     * @return integer
     */
    public function getTotal()
    {
        return $this->paginator->total();
    }

    /**
     * @return integer
     */
    public function getCount()
    {
        return $this->paginator->count();
    }

    /**
     * @return integer
     */
    public function getPerPage()
    {
        return $this->paginator->perPage();
    }

    /**
     * @param integer $page
     *
     * @return string
     */
    public function getUrl($page)
    {
        return $this->paginator->url($page);
    }

    /**
     * @return Paginator
     */
    public function getPaginator()
    {
        return $this->paginator;
    }
}
