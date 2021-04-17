<?php

namespace App\Services;

class PropertyHashService
{
    public static function hash(array $data): string
    {
        return md5(json_encode($data));
    }
}
