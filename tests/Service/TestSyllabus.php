<?php

namespace Syllabus\Tests\Service;

use PHPUnit\Framework\TestCase;
use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollectionProxy;
use Syllabus\IO\FileReaderInterface;
use Syllabus\IO\Reader;
use Syllabus\Model\Pattern;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class TestSyllabus extends TestCase
{

    public function testDependPatternArray(): array
    {
        $reader = new Reader();
        $patternCollection = $reader->readFromFileToCollection(FileReaderInterface::DEFAULT_PATTERN_LINK);
        $this->assertInstanceOf(PatternCollectionProxy::class, $patternCollection);
        return $patternCollection->getAll();
    }

    public function provideWords(): array
    {
        return [
            [
                'vigorous',
                'vig-or-ous'
            ],
            [
                'changed',
                'changed'
            ],
            [
                'pitch',
                'pitch'
            ],
            [
                'uncopyrightable',
                'un-copy-rightable'
            ],
            [
                'system',
                'sys-tem'
            ],
            [
                'disastrous',
                'dis-as-trous'
            ],
            [
                'frightening',
                'fright-en-ing'
            ],
            [
                'encouraging',
                'en-cour-ag-ing'
            ]
        ];
    }

    /**
     * @depends  testDependPatternArray
     * @dataProvider provideWords
     */
    public function testWordIsSyllabifiedCorrectly(string $word, string $expected, array $patterns)
    {
        $patternCollection = new PatternCollectionProxy();
        $count = count($patterns);

        for ($i = 0; $i < $count; $i++) {
            $pattern = new Pattern($patterns[$i]);
            $patternCollection->add($pattern);
        }
        $this->assertIsArray($patternCollection->getAll());

        $syllabus = new Syllabus();
        $wordModel = new Word($word);
        $syllabifiedWord = $syllabus->syllabify($wordModel, $patternCollection);
        $this->assertEquals($expected,$syllabifiedWord);
    }

}