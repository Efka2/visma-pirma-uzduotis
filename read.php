<?php

function readFromFile($filePath) : array{
    $file = new SplFileObject($filePath);
    $data = array();

    while(!$file->eof()){
        $data[] = trim($file->fgets());
    }
    $file = null;

    return $data;
}
