<?php


namespace Syllabus\Core;


use Syllabus\Model\Pattern;

class PatternCollection
{
    /**
     * @var Pattern[]
     */
    protected $items = array();

    public function add(Pattern $item) : void
    {
        $this->items[] = $item;
    }

    public function remove($key) : void
    {
        if (isset($this->items[$key])){
            unset($this->items[$key]);
        }
        else{
            //todo throw exception?
            echo "Key $key does'/\t exist in array.\n";
        }
    }

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

    public function getAll() : array
    {
        return $this->items;
    }
}