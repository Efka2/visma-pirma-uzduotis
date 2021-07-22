<?php

namespace Syllabus\Core;

class Collection implements CollectionInterface
{
    protected $items;

    public function add($item): void
    {
        $this->items[] = $item;
    }

    public function remove($key): void
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            //todo throw exception?
            echo "Key $key does'/\t exist in array.\n";
        }
    }

    public function get($key): ?object
    {
        if (!isset($this->items[$key])) {
            return NULL;
        }

        return $this->items[$key];
    }

    public function getAll(): array
    {
        return $this->items;
    }

    public function length(): int
    {
        return count($this->items);
    }
}