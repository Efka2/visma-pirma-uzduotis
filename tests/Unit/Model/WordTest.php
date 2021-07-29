<?php

namespace Syllabus\Tests\Unit\Model;

use PHPUnit\Framework\TestCase;
use Syllabus\Model\Word;

class WordTest extends TestCase
{
    private Word $word;

    public function setUp(): void
    {
        $this->word = new Word('system');
    }

    public function testCanCreateWordObject()
    {
        $this->assertInstanceOf(Word::class, $this->word);
    }

    public function testGetWordString()
    {
        $this->assertEquals('system', $this->word->getWordString());
    }

    public function testGetSyllabifiedWord()
    {
        $this->word->setSyllabifiedWord('sys-tem');
        $this->assertEquals('sys-tem', $this->word->getSyllabifiedWord());
    }

    public function testSetWordString()
    {
        $this->word->setWordString('newWord');
        $this->assertEquals('newWord', $this->word);
    }

    public function testSetSyllabifiedWord()
    {
        $this->word->setSyllabifiedWord('sys-tem');
        $this->assertEquals('sys-tem', $this->word->getSyllabifiedWord());
    }

    public function testReturnEmptyStringFromDefaultSyllabifiedWord()
    {
        $this->assertEquals('', $this->word->getSyllabifiedWord());
    }

    public function testReturnToStringMethodWhenCallingAnObject()
    {
        $this->assertEquals('system', $this->word);
    }
}
