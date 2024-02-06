<?php

namespace App\Services\Interfaces;

use App\Models\City;
use http\Client\Response;

interface HTTPServiceInterface
{
    public function get(string $url, array $params): array;
}
