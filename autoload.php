<?php

//spl_autoload_register(function($className){
//    require_once str_replace("\\",'/',$className) . ".php";
//});

//full path classes
spl_autoload_register(
    function ($class) {
        $rootDir = __DIR__;
        $sourceDir = '/src/';
        
        $file = $rootDir.$sourceDir.str_replace('\\', '/', $class).'.php';
        if (file_exists($file)) {
            require_once $file;
        }
    }
);