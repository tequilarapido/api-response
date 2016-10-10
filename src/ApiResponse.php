<?php

namespace Tequilarapido\ApiResponse;

use Illuminate\Support\MessageBag;

class ApiResponse
{
    /**
     * @var FractalAdapter
     */
    private $fractalAdapter;

    /**
     * Response class.
     *
     * @param FractalAdapter $fractal
     */
    public function __construct(FractalAdapter $fractal)
    {
        $this->fractalAdapter = $fractal;
    }

    /**
     * Returns one item.
     *
     * @param mixed $data
     * @param null  $transformer
     * @param null  $resourceKey
     * @param bool  $build
     *
     * @return array|\Illuminate\Http\Response|ResponseBuilder
     */
    public function item($data, $transformer = null, $resourceKey = null, $build = true)
    {
        return $this->toResponseBuilder(
            $this->fractalAdapter->item($data, $transformer, $resourceKey),
            $build
        );
    }

    /**
     * Returns collection.
     *
     * @param      $data
     * @param null $transformer
     * @param null $resourceKey
     * @param bool $build
     *
     * @return array|\Illuminate\Http\Response|ResponseBuilder
     */
    public function collection($data, $transformer = null, $resourceKey = null, $build = true)
    {
        return $this->toResponseBuilder(
            $this->fractalAdapter->collection($data, $transformer, $resourceKey),
            $build
        );
    }

    /**
     * Returns paginated collection.
     *
     * @param      $paginator
     * @param null $transformer
     * @param null $resourceKey
     * @param bool $build
     *
     * @return array|\Illuminate\Http\Response|ResponseBuilder
     */
    public function paginatedCollection($paginator, $transformer = null, $resourceKey = null, $build = true)
    {
        return $this->toResponseBuilder(
            $this->fractalAdapter->paginatedCollection($paginator, $transformer, $resourceKey),
            $build
        );
    }

    /**
     * Respond with a no content response.
     *
     * @param bool $build
     *
     * @return ResponseBuilder|\Illuminate\Http\Response
     */
    public function noContent($build = true)
    {
        $response = new ResponseBuilder(null);
        $response->setStatusCode(204);

        return $build ? $response->build() : $response;
    }

    /**
     * Return a 404 not found error.
     *
     * @param string|array $message
     * @param bool         $build
     *
     * @return \Illuminate\Http\Response
     */
    public function errorNotFound($message = 'Not Found', $build = true)
    {
        return $this->error($message, 404, null, $build);
    }

    /**
     * Return a 400 bad request error.
     *
     * @param string|array $message
     * @param bool         $build
     *
     * @return \Illuminate\Http\Response
     */
    public function errorBadRequest($message = 'Bad Request', $build = true)
    {
        return $this->error($message, 400, null, $build);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string|array $message
     * @param bool         $build
     *
     * @return \Illuminate\Http\Response
     */
    public function errorUnauthorized($message = 'Unauthorized', $build = true)
    {
        return $this->error($message, 401, null, $build);
    }

    /**
     * Return a 401 unauthorized error.
     *
     * @param string|array $message
     * @param bool         $build
     *
     * @return \Illuminate\Http\Response
     */
    public function errorForbidden($message = 'Forbidden', $build = true)
    {
        return $this->error($message, 403, null, $build);
    }

    /**
     * Return a 500 internal server error.
     *
     * @param string|array $message
     * @param bool         $build
     *
     * @return \Illuminate\Http\Response
     */
    public function errorInternal($message = 'Internal Error', $build = true)
    {
        return $this->error($message, 500, null, $build);
    }

    /**
     * Return an error response.
     *
     * @param                  $messages
     * @param int              $statusCode
     * @param mixed|MessageBag $errors
     * @param bool             $build
     *
     * @return \Illuminate\Http\Response
     */
    public function error($messages, $statusCode = 500, $errors = null, $build = true)
    {
        $error = [
            'error' => true,
            'code' => $statusCode,
            'message' => $messages,
        ];

        if (! is_null($errors)) {
            $error = array_merge($error, ['errors' => $errors]);
        }

        $response = (new ResponseBuilder($error))->setStatusCode($statusCode);

        return $build ? $response->build() : $response;
    }

    /**
     * Wrap into ResponseBuilder, and build if requested.
     * If not will return ResponseBuilder object, to be able to add headers for instance
     * before sending back response using `build()` method.
     *
     * @param $data
     * @param bool $build
     *
     * @return \Illuminate\Http\Response|ResponseBuilder
     */
    protected function toResponseBuilder($data, $build)
    {
        return $build
            ? (new ResponseBuilder($data))->build()
            : new ResponseBuilder($data);
    }
}
