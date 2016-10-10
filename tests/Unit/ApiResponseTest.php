<?php

namespace Tequilarapido\ApiResponse\Test;

use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ApiResponseTest extends TestCase
{
    /** @test */
    public function it_returns_no_content_response()
    {
        $response = api_response()->noContent();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NO_CONTENT);
        $this->assertEmpty($response->getContent());
    }

    /** @test */
    public function it_returns_error_response()
    {
        $response = api_response()->error('Error message');
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_INTERNAL_SERVER_ERROR);
        $this->assertEquals($response->getContent(), '{"error":true,"code":500,"message":"Error message"}');

        // Custom code
        $response = api_response()->error('Error message', 400);
        $this->assertEquals($response->getStatusCode(), 400);

        // Multiple Messages
        $response = api_response()->error(['one', 'two', 'three']);
        $this->assertEquals($response->getContent(), '{"error":true,"code":500,"message":["one","two","three"]}');
        $this->assertEmpty(array_diff($response->getOriginalContent()['message'], ['one', 'two', 'three']));

        // Additional errors
        $response = api_response()->error(['one', 'two', 'three'], 500, ['four', 'five']);
        $this->assertEquals($response->getContent(), '{"error":true,"code":500,"message":["one","two","three"],"errors":["four","five"]}');
    }

    /** @test */
    public function it_returns_not_found_error_response()
    {
        $response = api_response()->errorNotFound();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_NOT_FOUND);
        $this->assertEquals($response->getContent(), '{"error":true,"code":404,"message":"Not Found"}');
    }

    /** @test */
    public function it_returns_forbidden_error_response()
    {
        $response = api_response()->errorForbidden();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_FORBIDDEN);
        $this->assertEquals($response->getContent(), '{"error":true,"code":403,"message":"Forbidden"}');
    }

    /** @test */
    public function it_returns_unauthorized_error_response()
    {
        $response = api_response()->errorUnauthorized();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_UNAUTHORIZED);
        $this->assertEquals($response->getContent(), '{"error":true,"code":401,"message":"Unauthorized"}');
    }

    /** @test */
    public function it_returns_internal_error_response()
    {
        $response = api_response()->errorInternal();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_INTERNAL_SERVER_ERROR);
        $this->assertEquals($response->getContent(), '{"error":true,"code":500,"message":"Internal Error"}');
    }

    /** @test */
    public function it_returns_bad_request_response()
    {
        $response = api_response()->errorBadRequest();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_BAD_REQUEST);
        $this->assertEquals($response->getContent(), '{"error":true,"code":400,"message":"Bad Request"}');
    }

    /** @test */
    public function it_returns_collection()
    {
        $response = api_response()->collection([1, 2, 3]);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertEquals($response->getContent(), '{"data":[[1],[2],[3]]}');

        $response = api_response()->collection(new Collection(['one' => 1, 'two' => 2]));
        $this->assertEquals($response->getContent(), '{"data":[[1],[2]]}');
    }

    /** @test */
    public function it_return_item()
    {
        $response = api_response()->item([1, 2, 3]);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertEquals($response->getContent(), '{"data":[1,2,3]}');

        $response = api_response()->item(['one' => 1, 'two' => 2]);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertEquals($response->getContent(), '{"data":{"one":1,"two":2}}');

        $response = api_response()->item((object) ['one' => 1, 'two' => 2]);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertEquals($response->getContent(), '{"data":{"one":1,"two":2}}');
    }

    /** @test */
    public function it_returns_paginated_collection()
    {
        $items = [1, 2, 3];
        $paginator = new LengthAwarePaginator($items, 20, 3);

        $response = api_response()->paginatedCollection($paginator);
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals($response->getStatusCode(), Response::HTTP_OK);
        $this->assertEquals($response->getContent(), '{"data":[[1],[2],[3]],"meta":{"pagination":{"total":20,"count":3,"per_page":3,"current_page":1,"total_pages":7,"links":{"next":"\/?page=2"}}}}');
    }
}
