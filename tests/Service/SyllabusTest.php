<?php

namespace Syllabus\Tests\Service;

use PHPUnit\Framework\TestCase;
use Syllabus\Core\PatternCollectionProxy;
use Syllabus\Model\Pattern;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class SyllabusTest extends TestCase
{
    private PatternCollectionProxy $patternCollection;

    public function setUp(): void
    {
        $patterns = [
            '.mis1',
            'm2is',
            '2n1s2',
            'n2sl',
            's1l2',
            's3lat',
            'st4r',
            '4te.',
            '1tra',
            '1go',
            'gor5ou',
            '2ig',
            'i2go',
            'ig3or',
            'ou2',
            '2us',
            '.ch4',
            'a2n',
            '2ang',
            '2ged',
            'han4g',
            '.pi2t',
            '2ch',
            '4ch.',
            '4tc',
            't4ch',
            'b2l2',
            'b4le.',
            '1co',
            'opy5',
            '1ta',
            '2tab',
            '.sy2',
            's4y',
            'ys1t',
            'as1tr',
            'dis1',
            'isas5',
            'sa2',
            'fri2',
            'ht1en',
            'n1in',
            'nin4g',
            'ag1i',
            'ncour5a',
            'u1ra',
            'u4rag'
        ];
        $patternCollection = new PatternCollectionProxy();

        foreach ($patterns as $patternString) {
            $pattern = new Pattern($patternString);
            $patternCollection->add($pattern);
        }

        $this->patternCollection = $patternCollection;
    }

    public function testCanCreateSyllabusObject()
    {
        $syllabus = new Syllabus();
        $this->assertInstanceOf(Syllabus::class, $syllabus);
    }

    /**
     * @dataProvider \Syllabus\Tests\Service\SyllabusDataProvider::wordDataProvider()
     */
    public function testWordIsSyllabifiedCorrectly(string $word, string $expected)
    {
        $syllabus = new Syllabus();

        $wordModel = new Word($word);
        $syllabifiedWord = $syllabus->syllabify($wordModel, $this->patternCollection);
        $this->assertEquals($expected, $syllabifiedWord);
    }

    /**
     * @dataProvider \Syllabus\Tests\Service\SyllabusDataProvider::expectedPatternsProvider()
     */
    public function testSyllabusFindsPatternsCorrectly(string $word, array $expectedPatterns)
    {
        $syllabus = new Syllabus();
        $word = new Word($word);

        $foundPatterns = $syllabus->findPatternsInWord($word, $this->patternCollection);
        $this->assertEquals($expectedPatterns, $foundPatterns->getAll());
    }
}
