<?php

namespace Tequilarapido\ApiResponse\Test;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Mockery;
use Tequilarapido\ApiResponse\ApiResponse;
use Tequilarapido\ApiResponse\FractalAdapter;

class FractalAdapterTest extends TestCase
{
    /** @test */
    public function it_adapts_item_call()
    {
        $adapter = Mockery::mock(FractalAdapter::class);
        $adapter->shouldReceive('item')->once()->with('something', null, null);
        (new ApiResponse($adapter))->item('something');

        $adapter = Mockery::mock(FractalAdapter::class);
        $adapter->shouldReceive('item')->once()->with('something', 'a_transformer', 'a_resource_key');
        (new ApiResponse($adapter))->item('something', 'a_transformer', 'a_resource_key');
    }

    /** @test */
    public function it_adapts_collection_call()
    {
        $adapter = Mockery::mock(FractalAdapter::class);
        $adapter->shouldReceive('collection')->once()->with([1, 2], null, null);
        (new ApiResponse($adapter))->collection([1, 2]);

        $adapter = Mockery::mock(FractalAdapter::class);
        $adapter->shouldReceive('collection')->once()->with([1, 2], 'a_transformer', 'a_resource_key');
        (new ApiResponse($adapter))->collection([1, 2], 'a_transformer', 'a_resource_key');
    }

    /** @test */
    public function it_adapts_paginated_collection_call()
    {
        $paginator = Mockery::mock(LengthAwarePaginator::class);
        $adapter = Mockery::mock(FractalAdapter::class);
        $adapter->shouldReceive('paginatedCollection')->once()->with($paginator, null, null);
        (new ApiResponse($adapter))->paginatedCollection($paginator);
    }
}
