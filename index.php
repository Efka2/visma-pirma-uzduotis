<?php

include_once ('read.php');
include_once ('print.php');
//include_once ('syllabify.php');

$filePath = "https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt";

$data = readFromFile($filePath);

if( $argc == 2 )
{
    $word = strtolower(trim($argv[1]));
    $wordWithDots =  '.'.$word .'.';
}
else {
    echo "Enter an argument!";
    exit();
}

$numbers = [0,1,2,3,4,5,6,7,8,9];
$wordArray = str_split($word);
$numberArray = array();

for($i = 0; $i< count($wordArray)  ; $i++){
        $numberArray[$i] = 0;
}

foreach ($data as $pattern){

    $pattern_without_number = str_replace($numbers,'',$pattern);
    $position = strpos( $wordWithDots, $pattern_without_number);

    if($position !== false){
        echo $pattern ."\n";
        $numberArray = populateNumbersArray($numberArray,$pattern,$position);
    }
}
function populateNumbersArray(array $numberArray, string $pattern, int $position): array
{
    $patternChars = str_split($pattern);
    foreach ($patternChars as $char){
        if(is_numeric($char) && $char >= $numberArray[$position]){
            $numberArray[$position] = $char;
        }
        else $position++;
    }
    return $numberArray;
}

print_r($numberArray);
function remakeWord($numberArray, $word): string{
    foreach ($numberArray as $key => $value){
        if($value % 2 !== 0){
            //todo fix this klaida cia kazkur
            echo "$key + $value \n";
            $wordx = substr_replace($word, '-', $key-1, 0);
//            print_r(str_split($wordx));
//            break;
        }
    }
    return $wordx;
}
$finalWord = remakeWord($numberArray,$word);
echo $finalWord ."\n";
//echo "$wordWithDots";