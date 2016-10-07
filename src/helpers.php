<?php

use Tequilarapido\ApiResponse\ApiResponse;

if (!function_exists('api_response')) {
    /**
     *  Return api response instance.
     *
     * @return ApiResponse
     */
    function api_response()
    {
        return app(ApiResponse::class);
    }
}
