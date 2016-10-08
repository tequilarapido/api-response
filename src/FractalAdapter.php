<?php

namespace Tequilarapido\ApiResponse;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;

class FractalAdapter
{
    /** @var \League\Fractal\Manager */
    protected $manager;

    /** @var Request */
    private $request;

    /**
     * FractalAdapter constructor.
     *
     * @param SerializerAbstract $serializer
     * @param Request $request
     */
    public function __construct(SerializerAbstract $serializer, Request $request)
    {
        $this->manager = new Manager();
        $this->manager->setSerializer($serializer);

        $this->request = $request;
    }

    /**
     * Return an item.
     *
     * @param $data
     * @param null $transformer
     * @param null $resourceKey
     * @return array
     */
    public function item($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Item($data, $transformer, $resourceKey);

        return $this->manager->createData($resource)->toArray();
    }

    /**
     * Return a collection of items.
     *
     * @param $data
     * @param null $transformer
     * @param null $resourceKey
     * @return array
     */
    public function collection($data, $transformer = null, $resourceKey = null)
    {
        $resource = new Collection($data, $transformer, $resourceKey);

        return $this->manager->createData($resource)->toArray();
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param null $transformer
     * @param null $resourceKey
     * @return array
     */
    public function paginatedCollection(LengthAwarePaginator $paginator, $transformer = null, $resourceKey = null)
    {
        $paginator->appends($this->request->query());

        $resource = new Collection($paginator->items(), $transformer, $resourceKey);

        $resource->setPaginator(new PaginatorAdapter($paginator));

        return $this->manager->createData($resource)->toArray();
    }
}
