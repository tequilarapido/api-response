<?php

namespace Tequilarapido\ApiResponse\Test;

use Tequilarapido\ApiResponse\ApiResponseServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /** @var TestHelper */
    protected $helper;

    protected function getPackageProviders($app)
    {
        return [ApiResponseServiceProvider::class];
    }

    public function setUp() : void
    {
        parent::setUp();

        $this->helper = new TestHelper($this->app);
    }

    public function tearDown() : void
    {
        parent::tearDown();

        $this->helper = null;
    }
}
