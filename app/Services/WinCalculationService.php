<?php

namespace App\Services;

use App\Traits\Logger;

/**
 * @property array $pays
 */
class WinCalculationService
{
    use Logger;

    const LINE_STAKE = 0.1;//line stake shall not be hardcoded in class, but for the purpose of test task it is
    private array $pays;

    public function __construct(array $config)
    {
        $this->pays = $config['pays'];
    }

    /**
     * @param array $linesResults
     * @return float
     */
    public function calculate(array $linesResults): float
    {
        $wins = 0;
        foreach ($linesResults as $lineClass => $linesResult) {
            foreach ($linesResult as $symbol => $combo) {
                if ($combo > 2) { // minimum streak is 3, so no point in checking lower combos
                    foreach ($this->pays as $payLine) {
                        //there is an opportunity to recombine "pays" config to make check like
                        // if(isset($pays[$symbol.'+'.$combo]))
                        //to eliminate this last foreach loop to
                        if ($payLine[0] === $symbol && $payLine[1] === $combo) {
                            $lineWin = self::LINE_STAKE * $payLine[2];
                            $this->log(
                                'Line '.$lineClass.' won. According to pays table record [' .
                                $payLine[0].','.$payLine[1].','.$payLine[2].'], '.$lineWin.'$ '.
                                'has been won by a combo of '.$combo.' symbols "'.$symbol.'"'
                            );
                            $wins += $lineWin;
                        }
                    }
                }
            }
        }
        $this->log('Total wins are: '.$wins.'$');
        return $wins;
    }
}