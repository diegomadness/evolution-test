<?php

namespace App\Controllers;

use App\Services\LineCheckerService;
use App\Services\ReelGeneratorService;
use App\Services\WinCalculationService;
use App\Traits\Logger;

/**
 * @property array $config
 */
class IndexController
{
    use Logger;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function spin(): void
    {
        $this->log('***Start Spin***');
        $generatorService = new ReelGeneratorService($this->config);
        $grid = $generatorService->generate(3);

        $lineCheckerService = new LineCheckerService();
        $linesResults = $lineCheckerService->checkAll($grid);

        $winCalcService = new WinCalculationService($this->config);
        $wins = $winCalcService->calculate($linesResults);

        //I am not sure what is the communication format between BE and FE in the game,
        //so I made simplest console FE for better visibility of results
        $this->simpleFrontendView([
            'grid' => $grid,
            'wins' => $wins
        ]);
        $this->log('***End Spin***');
    }

    private function simpleFrontendView(array $data): void
    {
        echo("\r\n");
        foreach ($data['grid'] as $line) {
            foreach ($line as $symbol) {
                echo($symbol.' ');
            }
            echo("\r\n");
        }
        echo("You have won: ".$data['wins']."$");
    }
}
