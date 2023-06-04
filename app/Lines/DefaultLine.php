<?php

namespace App\Lines;
/**
 * Most lines share its content fetching method, so this method holds it
 *
 * @property array $pattern
 */
abstract class DefaultLine implements LineInterface
{
    public array $pattern = [];

    public function getLineContent(array $grid): array
    {
        $content = [];
        foreach ($this->pattern as $rowId => $row) {
            foreach ($row as $columnId => $cellActive) {
                if ($cellActive) {
                    $content[] = $grid[$rowId][$columnId];
                }
            }
        }
        return $content;
    }
}