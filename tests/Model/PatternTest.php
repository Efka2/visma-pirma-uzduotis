<?php

namespace  Syllabus\Tests\Model;

use PHPUnit\Framework\TestCase;
use Syllabus\Model\Pattern;

class PatternTest extends TestCase
{
    public function testCanSuccessfullyCreateNewPattern()
    {
        $pattern = new Pattern("examplePattern");
        $this->assertInstanceOf(Pattern::class, $pattern);
    }

    public function testCanReturnPatternWithoutNumbers()
    {
        $pattern = new Pattern('12pat1tern2');
        $this->assertEquals('pattern', $pattern->getPatternWithoutNumbers());
    }
}
