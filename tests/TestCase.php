<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        if ($this->app->bound('url')) {
            $this->app->make('url')->forceRootUrl($this->app->make('config')->get('app.url'));
        }
    }
}
