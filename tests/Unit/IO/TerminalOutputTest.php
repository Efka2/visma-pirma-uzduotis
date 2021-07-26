<?php


namespace Syllabus\Tests\Unit\IO;


use PHPUnit\Framework\TestCase;
use Syllabus\IO\TerminalOutput;
use Syllabus\Model\Result;

class TerminalOutputTest extends TestCase
{

    private $result;
    private $dateInterval;

    public function setUp(): void
    {
        $result = $this->createMock(Result::class);
        $dateInterval = $this->createMock(\DateInterval::class);

        $this->result = $result;
        $this->dateInterval = $dateInterval;

        $this->result->method('getWord')->willReturn('system');
        $this->result->method('getSyllabifiedWord')->willReturn('sys-tem');
        $this->dateInterval->f = '0.002153';
        $this->result->method('getTime')->willReturn($this->dateInterval);
    }

    public function testOutputDisplayedCorrectly()
    {
        $this->result->method('getFoundPatterns')->willReturn(
            [
                ".sy2",
                "s4y",
                "ys1t"
            ]
        );

        $terminalOutput = new TerminalOutput($this->result, TRUE);
        $terminalOutput->output();
        $this->expectOutputString(
            <<<EOD
\nWord - system

Found patterns:
.sy2
s4y
ys1t

Syllabified word: sys-tem

Time taken to syllabify: 0.002153 microseconds.\n
EOD
        );
    }

    public function testDontOutputPatternsIfArrayIsEmpty()
    {
        $this->result->method('getFoundPatterns')->willReturn([]);

        $terminalOutput = new TerminalOutput($this->result, TRUE);
        $terminalOutput->output();

        $this->expectOutputString(
            <<<EOD
\nWord - system

Syllabified word: sys-tem

Time taken to syllabify: 0.002153 microseconds.\n
EOD
        );
    }

    public function testDontOutputPatternsIfVariableIsFalse()
    {
        $this->result->method('getFoundPatterns')->willReturn(
            [
                ".sy2",
                "s4y",
                "ys1t"
            ]
        );

        $terminalOutput = new TerminalOutput($this->result, FALSE);
        $terminalOutput->output();

        $this->expectOutputString(
            <<<EOD
\nWord - system

Syllabified word: sys-tem

Time taken to syllabify: 0.002153 microseconds.\n
EOD
        );
    }
}