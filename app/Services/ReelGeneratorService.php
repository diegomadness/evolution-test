<?php

namespace App\Services;

use App\Traits\Logger;

/**
 * Test task note:
 * If I understood correctly the point of 'reels' field in the config, then it means that it is the source for
 * reels data "generation". For that I had to persist cursor positions(to not show same 3 lines all over),
 * so I did just that in simplest possible way
 *
 * @property array $generator
 * @property array $positions
 * @property int $secretSymbol
 */
class ReelGeneratorService
{
    use Logger;

    private array $positions;
    private array $generator;
    private int $secretSymbol;

    public function __construct(array $config)
    {
        $this->secretSymbol = rand(1, 9);
        $this->generator = $config['reels'][0];
        $this->positions = $this->initPositions();
    }

    /**
     * @param int $linesCount
     * @return array
     */
    public function generate(int $linesCount = 1): array
    {
        $lines = [];
        $this->log('Following lines were generated: ');
        for ($i = 0; $i < $linesCount; $i++) {
            $line = $this->generateLine();
            $lines[] = $line;
            //every time new line is generated - it shall be logged for transparency and analysis
            $logMessage = '';
            foreach ($line as $symbol) {
                $logMessage .= $symbol.' ';
            }
            $this->log($logMessage);
        }
        $this->savePositions();
        return $lines;
    }

    /**
     * @return array
     */
    private function generateLine(): array
    {
        $line = [];
        foreach ($this->generator as $rowId => $row) {
            $line[] = $this->translateSecretSymbol($row[$this->positions[$rowId]]);
            isset($row[$this->positions[$rowId] + 1]) ? $this->positions[$rowId]++ : $this->positions[$rowId] = 0;
        }
        return $line;
    }

    /**
     * @param int $symbol
     * @return int
     */
    private function translateSecretSymbol(int $symbol): int
    {
        if ($symbol === 10) {
            return $this->secretSymbol;
        }
        return $symbol;
    }

    /**
     * @return array
     */
    private function initPositions(): array
    {
        if (file_exists('positions.json')) {
            $positions = json_decode(file_get_contents('positions.json'), true);
            if(!is_array($positions)) {
                //Proper error handling and logging would be here in production if we would ever use array of numbers in a file as generator
                //
                //So for now there is just a friendly message in case something is wrong with app user permissions in fs
                die("Can't load latest generator positions, please make sure the app can read files");
            }
        } else {
            $positions = [0, 0, 0, 0, 0];
        }
        return $positions;
    }

    /**
     * @return void
     */
    private function savePositions(): void
    {
        $file = fopen('positions.json', 'w');
        fwrite($file, json_encode($this->positions));
        fclose($file);
    }
}