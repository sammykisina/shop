<?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(TestCase::class,RefreshDatabase::class)
->in('Domains');

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

