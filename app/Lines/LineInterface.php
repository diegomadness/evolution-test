<?php

namespace App\Lines;

interface LineInterface
{
    public function getLineContent(array $grid): array;
}