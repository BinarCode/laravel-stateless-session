<?php

namespace Binarcode\LaravelStatelessSession\Tests;

use Orchestra\Testbench\TestCase;
use Binarcode\LaravelStatelessSession\LaravelStatelessSessionServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelStatelessSessionServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
