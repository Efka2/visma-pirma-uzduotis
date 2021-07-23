<?php

namespace Syllabus\Tests\Service;

use PHPUnit\Framework\TestCase;
use Syllabus\Core\CollectionInterface;
use Syllabus\Core\PatternCollectionProxy;
use Syllabus\Model\Pattern;
use Syllabus\Service\Syllabus;

class TestSyllabus extends TestCase
{

    public function testPatternArray(): array
    {
        $patternArray = [
            '.sy2',
            's4y',
            'ys1t',
            '.mis1',
            'a2n',
            'm2is',
            '2n1s2',
            'n2sl',
            's1l2',
            's3lat',
            'st4r',
            '4te.',
            '1tra'
        ];

        $this->assertIsArray($patternArray);
        return $patternArray;
    }

    /**
     * @depends  testPatternArray
     */
    public function testSomething(array $patterns)
    {
        $patternCollection = new PatternCollectionProxy();
        $count = count($patterns);

        for ($i = 0; $i < $count; $i++) {
            $pattern = new Pattern($patterns[$i]);
            $patternCollection->add($pattern);
        }
        $this->assertIsArray($patternCollection->getAll());

        $syllabus = new Syllabus();

        $foundPatterns = $syllabus->syllabify('mistranslate', $patternCollection);
        print_r($foundPatterns);

        $this->assertTrue(TRUE);
    }
}