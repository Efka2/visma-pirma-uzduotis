<?php

    require ('src/Syllabus/IO/Reader.php');
    require ('src/Syllabus/Service/Syllabus.php');
    require ('src/Syllabus/IO/FileReaderInterface.php');
    use Evaldas\Syllabus\IO\Reader;
    use Evaldas\Syllabus\Service\Syllabus;

    //bootstrap
$filePath = "https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt";
$fileReader = new SplFileObject($filePath);
$reader = new Reader($fileReader);
$patternArray = $reader->readFromFile();

//spl_autoload_register(function ($name){
//    include "$name".'.php';
//});


if( $argc == 2 )
{
    $word = strtolower(trim($argv[1]));
    $wordWithDots =  '.'.$word .'.';
}
else {
    echo "Enter an argument!";
    exit();
}

    $syllabus = new Syllabus($word);
    $x = $syllabus->findPatternsInWord($patternArray);
    $finalWord = $syllabus->syllabifyWord();
    print $finalWord . "\n";

