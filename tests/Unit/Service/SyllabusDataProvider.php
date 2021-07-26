<?php

namespace Syllabus\Tests\Unit\Service;

class SyllabusDataProvider
{

    public static function wordDataProvider(): array
    {
        return [
            'vigorous hyphenated to vig-or-ous' => [
                'vigorous',
                'vig-or-ous'
            ],
            'changed hyphenated to changed' => [
                'changed',
                'changed'
            ],
            'pitch hyphenated to pitch' => [
                'pitch',
                'pitch'
            ],
            'uncopyrightable hyphenated to un-copy-rightable' => [
                'uncopyrightable',
                'un-copy-rightable'
            ],
            'system hyphenated to sys-tem' => [
                'system',
                'sys-tem'
            ],
            'disastrous hyphenated to dis-as-trous' => [
                'disastrous',
                'dis-as-trous'
            ],
            'frightening hyphenated to fright-en-ing' => [
                'frightening',
                'fright-en-ing'
            ],
            'encouraging hyphenated to en-cour-ag-ing' => [
                'encouraging',
                'en-cour-ag-ing'
            ]
        ];
    }

    public static function expectedPatternsProvider(): array
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
}
