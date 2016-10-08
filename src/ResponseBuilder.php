<?php

namespace Tequilarapido\ApiResponse;

use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Cookie;

/**
 * Inspired from dingo/api.
 *
 * Class ResponseBuilder
 */
class ResponseBuilder
{
    /**
     * Response content.
     *
     * @var mixed
     */
    protected $response;

    /**
     * The HTTP response headers.
     *
     * @var array
     */
    protected $headers = [];

    /**
     * The HTTP response cookies.
     *
     * @var array
     */
    protected $cookies = [];

    /**
     * The HTTP response status code.
     *
     * @var int
     */
    protected $statusCode = 200;

    /**
     * Create a new response builder instance.
     *
     * @param mixed $response
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Add a cookie to the response.
     *
     * @param \Symfony\Component\HttpFoundation\Cookie $cookie
     *
     * @return ResponseBuilder
     */
    public function withCookie(Cookie $cookie)
    {
        $this->cookies[] = $cookie;

        return $this;
    }

    /**
     * Add a cookie to the response.
     *
     * @param \Symfony\Component\HttpFoundation\Cookie $cookie
     *
     * @return ResponseBuilder
     */
    public function cookie(Cookie $cookie)
    {
        return $this->withCookie($cookie);
    }

    /**
     * Add a header to the response.
     *
     * @param string $name
     * @param string $value
     *
     * @return ResponseBuilder
     */
    public function withHeader($name, $value)
    {
        $this->headers[$name] = $value;

        return $this;
    }

    /**
     * Add a header to the response.
     *
     * @param string $name
     * @param string $value
     *
     * @return ResponseBuilder
     */
    public function header($name, $value)
    {
        return $this->withHeader($name, $value);
    }

    /**
     * Set the responses status code.
     *
     * @param int $statusCode
     *
     * @return ResponseBuilder
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * Set the response status code.
     *
     * @param int $statusCode
     *
     * @return ResponseBuilder
     */
    public function statusCode($statusCode)
    {
        return $this->setStatusCode($statusCode);
    }

    /**
     * Build the response.
     *
     * @return \Illuminate\Http\Response
     */
    public function build()
    {
        $response = new HttpResponse($this->response, $this->statusCode, $this->headers);

        foreach ($this->cookies as $cookie) {
            if ($cookie instanceof Cookie) {
                $response->withCookie($cookie);
            }
        }

        return $response;
    }
}
