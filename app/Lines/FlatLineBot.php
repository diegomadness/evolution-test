<?php

namespace App\Lines;
/**
 * @property array $pattern
 */
class FlatLineBot extends DefaultLine
{
    public array $pattern;

    public function __construct()
    {
        $this->pattern = [
            0 => [0, 0, 0, 0, 0],
            1 => [0, 0, 0, 0, 0],
            2 => [1, 1, 1, 1, 1],
        ];
    }
}