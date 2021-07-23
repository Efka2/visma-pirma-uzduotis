<?php

namespace Syllabus\IO;

interface ReaderInterface
{
    public function readFromCli(): string;

    public function readSelection(string $message, array $options): string;
}
