<?php

namespace Tequilarapido\ApiResponse\Test;

use Illuminate\Pagination\LengthAwarePaginator;
use Tequilarapido\ApiResponse\PaginatorAdapter;

class PaginatorAdpaterTest extends TestCase
{
    /** @test */
    public function it_returns_current_page()
    {
        $this->assertEquals($this->adapter()->getCurrentPage(), 3);
    }

    /** @test */
    public function it_returns_last_page()
    {
        $this->assertEquals($this->adapter()->getLastPage(), 7);
    }

    /** @test */
    public function it_returns_total()
    {
        $this->assertEquals($this->adapter()->getTotal(), 20);
    }

    /** @test */
    public function it_returns_count()
    {
        $this->assertEquals($this->adapter()->getCount(), 3);
    }

    /** @test */
    public function it_returns_per_page()
    {
        $this->assertEquals($this->adapter()->getPerPage(), 3);
    }

    /** @test */
    public function it_returns_url()
    {
        $this->assertEquals($this->adapter()->getUrl('page'), 'products?page=1');
    }

    /** @test */
    public function it_returns_paginator()
    {
        $this->assertInstanceOf(LengthAwarePaginator::class, $this->adapter()->getPaginator());
    }

    private function adapter()
    {
        return new PaginatorAdapter(
            new LengthAwarePaginator([1, 2, 3], 20, 3, 1, ['path' => 'products'])
        );
    }
}
