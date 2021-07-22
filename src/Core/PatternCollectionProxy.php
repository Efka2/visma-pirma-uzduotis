<?php

namespace Syllabus\Core;

use Syllabus\Model\Pattern;

class PatternCollectionProxy implements CollectionInterface
{
    private ?PatternCollection $patternCollection = NULL;

    public function add($item): void
    {
        if ($this->patternCollection == NULL) {
            $this->makePatternCollection();
        }
        $this->patternCollection->add($item);
    }

    public function get($key): ?Pattern
    {
        if ($this->patternCollection == NULL) {
            $this->makePatternCollection();
        }
        return $this->patternCollection->get($key);
    }

    public function remove($key): void
    {
        if ($this->patternCollection == NULL) {
            $this->makePatternCollection();
        }
        $this->patternCollection->remove($key);
    }

    public function length(): int
    {
        if ($this->patternCollection == NULL) {
            $this->makePatternCollection();
        }
        return $this->patternCollection->length();
    }

    /**
     * @return Pattern[]
     */
    public function getAll(): array
    {
        if ($this->patternCollection == NULL) {
            $this->makePatternCollection();
        }
        return $this->patternCollection->getAll();
    }

    private function makePatternCollection()
    {
        $this->patternCollection = new PatternCollection();
    }
}