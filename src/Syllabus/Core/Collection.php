<?php


namespace Syllabus\Core;


class Collection implements CollectionInterface
{
    protected $items;

    public function add($item) : void
    {
        $this->items[] = $item;
    }

    public function remove($key):void
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

    public function getAll(): array
    {
        return $this->items;
    }

    public function lenght():int
    {
        return count($this->items);
    }
}