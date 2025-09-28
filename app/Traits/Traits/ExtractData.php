<?php

namespace App\Traits\Traits;

trait ExtractData
{
    public function replaceArrayKeysFragment(array $array, string $fragment, string $replace = ''): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newKey = str_replace($fragment, $replace, $key);
            $newArray[$newKey] = $value;
        }
        return $newArray;
    }
}
