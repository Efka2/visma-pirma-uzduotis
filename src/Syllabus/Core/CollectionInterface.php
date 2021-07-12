<?php


namespace Syllabus\Core;


interface CollectionInterface
{
    public function add($item):void;

    public function remove($key):void;

    public function get($key);

    public function getAll();

    public function lenght():int;
}