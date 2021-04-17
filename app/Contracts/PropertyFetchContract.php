<?php

namespace App\Contracts;

interface PropertyFetchContract
{
    public function fetch(int $page, ?int $perPage = 100): array;
}
