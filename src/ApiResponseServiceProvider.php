<?php

namespace Tequilarapido\ApiResponse;

use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->bindFractalSerializer();
    }

    /**
     * Always get result with data property (even if it's one item).
     */
    private function bindFractalSerializer()
    {
        $this->app->bind(
            'League\Fractal\Serializer\SerializerAbstract',
            'League\Fractal\Serializer\DataArraySerializer'
        );
    }
}
