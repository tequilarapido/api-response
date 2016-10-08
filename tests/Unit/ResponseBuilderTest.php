<?php

namespace Tequilarapido\ApiResponse\Test;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Tequilarapido\ApiResponse\ResponseBuilder;

class ResponseBuilderTest extends TestCase
{
    /** @test */
    public function it_sets_cookie()
    {
        $builder = $this->responseBuilder()->cookie($cookie = new Cookie('super_cookie', 'super_value'));
        $this->assertEquals(count($builder->getCookies()), 1);
        $this->assertEquals($builder->getCookies()[0], $cookie);
    }

    /** @test */
    public function it_sets_cookies_using_with_cookie_method()
    {
        $builder = $this->responseBuilder()->withCookie($cookie = new Cookie('super_cookie', 'super_value'));
        $this->assertEquals(count($builder->getCookies()), 1);
        $this->assertEquals($builder->getCookies()[0], $cookie);
    }

    /** @test */
    public function it_sets_multiple_cookies()
    {
        $builder = $this->responseBuilder()
            ->withCookie($cookie_1 = new Cookie('super_cookie_1', 'super_value_1'))
            ->withCookie($cookie_2 = new Cookie('super_cookie_2', 'super_value_2'));

        $this->assertEquals(count($builder->getCookies()), 2);
        $this->assertEquals($builder->getCookies()[0], $cookie_1);
        $this->assertEquals($builder->getCookies()[1], $cookie_2);
    }

    /** @test */
    public function it_sets_headers()
    {
        $builder = $this->responseBuilder()
            ->header('header_1', 'value_1');

        $this->assertEquals(count($builder->getHeaders()), 1);
        $this->assertEquals($builder->getHeaders()['header_1'], 'value_1');
    }

    /** @test */
    public function it_sets_headers_using_with_headers_method()
    {
        $builder = $this->responseBuilder()
            ->withHeader('header_1', 'value_1')
            ->withHeader('header_2', 'value_2');

        $this->assertEquals(count($builder->getHeaders()), 2);
        $this->assertEquals($builder->getHeaders()['header_1'], 'value_1');
        $this->assertEquals($builder->getHeaders()['header_2'], 'value_2');
    }

    /** @test */
    public function is_set_satus_code()
    {
        $builder = $this->responseBuilder()->setStatusCode(1000);
        $this->assertEquals($builder->getStatusCode(), 1000);

        $builder = $this->responseBuilder()->statusCode(2000);
        $this->assertEquals($builder->getStatusCode(), 2000);
    }

    /** @test */
    public function it_builds_respone()
    {
        $response = $this->responseBuilder()
            ->setStatusCode(200)
            ->cookie($cookie = new Cookie('cookie_name', 'cookie_value'))
            ->header('X-HEADER-NAME', 'header_value')
            ->build();

        $this->assertInstanceOf(Response::class, $response);

        $resultCookie = $response->headers->getCookies()[0];
        $this->assertEquals($resultCookie->getName(), 'cookie_name');
        $this->assertEquals($resultCookie->getValue(), 'cookie_value');

        $allHeaders = $response->headers->all();
        $this->assertEquals($allHeaders['x-header-name'][0], 'header_value');
    }

    private function responseBuilder()
    {
        return new ResponseBuilder(new Response());
    }
}
