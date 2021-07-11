<?php


namespace Syllabus\Core;


class Collection implements \Iterator
{
    private array $items = array();

    public function add(object $item, $key = null) : void
    {
        if($key === null) $this->items[] = $item;

        else{
            $this->items[$key] = $item;
        }
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

    public function get($key) :? object
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

    public function current()
    {
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function key()
    {
        // TODO: Implement key() method.
    }

    public function valid()
    {
        // TODO: Implement valid() method.
    }

    public function rewind()
    {
        // TODO: Implement rewind() method.
    }
}