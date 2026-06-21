<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.marketplace_api.url');
    }

    protected function getHeaders(): array
    {
        return [
            'Authorization' => 'Bearer ' . session('token'),
            'Accept'        => 'application/json',
        ];
    }
}