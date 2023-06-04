<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;

final class LineTest extends TestCase
{
    public function testLinesPatterns(): void
    {
        $line = new \App\Lines\FlatLineTop();
        $expected = [1,1,1,1,1];
        $result = $line->getLineContent($line->pattern);
        //when line gets its pattern as grid, it shall always have content of only ones without zeros
        //otherwise it is not checking its own pattern correctly
        $this->assertSame($expected, $result);
    }
}