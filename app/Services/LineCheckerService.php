<?php

namespace App\Services;

/**
 * @property array $lines
 */
class LineCheckerService
{
    private array $lines = [
        'App\Lines\FlatLineTop',
        'App\Lines\FlatLineMid',
        'App\Lines\FlatLineBot',
        'App\Lines\ZLineLeft',
        'App\Lines\ZLineRight',
        'App\Lines\VLine',
        'App\Lines\WLine',
        'App\Lines\VLineReversed',
        'App\Lines\TopArcLine',
        'App\Lines\BotArcLine',
    ];

    /**
     * @param array $grid
     * @return array
     */
    public function checkAll(array $grid) : array {
        $results = [];
        foreach ($this->lines as $lineClass) {
            $line = new $lineClass();
            $results[$lineClass] = $this->groupSymbols($line->getLineContent($grid));
        }
        return $results;
    }

    /**
     * @param array $content
     * @return array
     */
    public function groupSymbols(array $content) : array {
        $groups = [];
        foreach ($content as $symbol) {
            if(isset($groups[$symbol])) {
                $groups[$symbol]++;
            } else {
                $groups[$symbol] = 1;
            }
        }
        return $groups;
    }
}