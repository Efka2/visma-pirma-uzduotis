<?php

namespace Syllabus\Tests\Service;

use PHPUnit\Framework\TestCase;
use Syllabus\Core\PatternCollectionProxy;
use Syllabus\Model\Pattern;
use Syllabus\Model\Word;
use Syllabus\Service\Syllabus;

class TestSyllabus extends TestCase
{
    private PatternCollectionProxy $patternCollection;

    protected function setUp(): void
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

    public function wordProvider(): array
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

    public function expectedWordPatternsProvider(): array
    {
        return [
            [
                'vigorous',
                [
                    '1go',
                    'gor5ou',
                    '2ig',
                    'i2go',
                    'ig3or',
                    'ou2',
                    '2us'
                ]
            ],
            [
                'changed',
                [
                    '.ch4',
                    'a2n',
                    '2ang',
                    '2ged',
                    'han4g',
                    '2ch'
                ]
            ],
            [
                'pitch',
                [
                    '.pi2t',
                    '2ch',
                    '4ch.',
                    '4tc',
                    't4ch'
                ]
            ],
            [
                'uncopyrightable',
                [
                    '2ig',
                    'b2l2',
                    'b4le.',
                    '1co',
                    'opy5',
                    '1ta',
                    '2tab'
                ]
            ],
            [
                'system',
                [
                    '.sy2',
                    's4y',
                    'ys1t'
                ]
            ],
            [
                'disastrous',
                [
                    'st4r',
                    'ou2',
                    '2us',
                    'as1tr',
                    'dis1',
                    'isas5',
                    'sa2'
                ]
            ],
            [
                'frightening',
                [
                    '2ig',
                    'fri2',
                    'ht1en',
                    'n1in',
                    'nin4g'
                ]
            ],
            [
                'encouraging',
                [
                    'ou2',
                    '1co',
                    'ag1i',
                    'ncour5a',
                    'u1ra',
                    'u4rag'
                ]
            ]
        ];
    }

    /**
     * @dataProvider wordProvider
     */
    public function testWordIsSyllabifiedCorrectly(string $word, string $expected)
    {
        $syllabus = new Syllabus();
        $wordModel = new Word($word);
        $syllabifiedWord = $syllabus->syllabify($wordModel, $this->patternCollection);
        $this->assertEquals($expected, $syllabifiedWord);
    }

    /**
     * @dataProvider expectedWordPatternsProvider
     */
    public function testSyllabusFindsPatternsCorrectly(string $word, array $expectedPatterns)
    {
        $syllabus = new Syllabus();
        $word = new Word($word);

        $foundPatterns = $syllabus->findPatternsInWord($word, $this->patternCollection);
        $this->assertEquals($expectedPatterns, $foundPatterns->getAll());
    }
}