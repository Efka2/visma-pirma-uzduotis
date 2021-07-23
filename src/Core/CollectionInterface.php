<?php

namespace Syllabus\Core;

interface CollectionInterface
{
    public function add($item): void;

    public function remove($key): void;

    public function get($key): ?object;

    public function getAll(): array;

    public function length(): int;
}
