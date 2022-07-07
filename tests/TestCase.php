<?php

namespace Tests;

use Closure;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Testing\TestResponse;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication;

    /**
     * [Description for get]
     *
     * @param Closure|string $uri
     * @param array $headers
     * 
     * @return TestResponse
     * 
     */
    public function get($uri,array $headers = []){
        return parent::get(
            uri: value(value: $uri),
            headers: $headers
        );
    }

    /**
     * [Description for post]
     *
     * @param Closure|string $uri
     * @param array $data
     * @param array $headers
     * 
     * @return TestResponse
     * 
     */
    public function post($uri,array $data = [], array $headers = []){
        return parent::post(
            uri: value(value: $uri),
            data: $data, 
            headers: $headers
        );
    }

    
    /**
     * [Description for patch]
     *
     * @param Closure|string $uri
     * @param array $data=[]
     * @param array $headers
     * 
     * @return TestResponse
     * 
     */
    // public function patch($uri,array $data=[],array $headers = []){
    //     return parent::patch(
    //         uri: value(value: $uri),
    //         data: $data,
    //         headers: $headers
    //     );
    // }
    
}
