<?php

namespace Tequilarapido\ApiResponse\Test;

use Illuminate\Http\Response;

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
}
