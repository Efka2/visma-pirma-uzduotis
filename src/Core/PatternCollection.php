<?php

namespace Syllabus\Core;

use Syllabus\Model\Pattern;

class PatternCollection extends Collection implements CollectionInterface
{
    /**
     * @Var Pattern[]
     */
    protected array $items = [];

    public function get($key): ?Pattern
    {
        if (!isset($this->items[$key])) {
            return null;
        }

        return $this->items[$key];
    }

    public function length(): int
    {
        return count($this->items);
    }

    /**
     * @return Pattern[]
     */
    public function getAll(): array
    {
        return $this->items;
    }
}
