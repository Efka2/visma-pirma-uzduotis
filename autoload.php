<?php

spl_autoload_register(
    function ($class) {
        $rootDir = __DIR__;
        $sourceDir = '/src/';
        $file = str_replace('\\', '/', $class).'.php';
        echo $file."\n";
            require_once $file;
    }
);