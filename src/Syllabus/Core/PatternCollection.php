<?php


namespace Syllabus\Core;


use Syllabus\Model\Pattern;

class PatternCollection extends Collection
{
    /**
     * @var Pattern[]
     */
    protected $items = array();

    public function get($key) :? Pattern
    {
        if(!isset($this->items[$key])){
            echo "No such item in collection with key $key. NULL is returned.\n";
            return null;
        }
        return $this->items[$key];
    }

    public function length() : int
    {
        return count($this->items);
    }

    /**
     * @return Pattern[]
     */
    public function getAll() : array
    {
        return $this->items;
    }
}