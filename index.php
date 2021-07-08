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
$zero = [0];
$starting = array();
$endings = array();
$answers = array();


$wordArray = str_split($word);
$numberArray = array();

for($i = 0; $i< count($wordArray) * 2 ; $i++){
    if($i % 2 == 0){
        $numberArray[$i] = $wordArray[$i/2];
    }
    else {
        $numberArray[$i] = '';
    }
}

//$numberArray[0] = '.';
//$numberArray[count($numberArray)-1] = '.';

foreach ($data as $pattern){

    $pattern_without_number = str_replace($numbers,'',$pattern);
    $position = strpos( $wordWithDots, $pattern_without_number);

    if($position !== false){
        $patternArray[$position] = $pattern;

//        $pos = $position * 2 - 2;
//        for($i = 0;$i<= count($patternArray); $i++){
//            if(is_numeric($patternArray[$i])) $numberArray[$pos] = $patternArray[$i];
//        }
//        $numberArray[strlen($pattern)] = filter_var($pattern, FILTER_SANITIZE_NUMBER_INT);
//
//        else{
//            foreach ($patternArray as $key=>$value){
//                if(is_numeric($value)){
////                    echo $position * 2 - 1 . "\n";
//                }
//            }
//        }
//        echo $position * 2 + 1 . "\n";
//        print_r($patternArray);
//        foreach ($patternArray as $key => $value){
//            if(is_numeric($value)){
//
//            }
//        }
//        break;
    }
}


foreach ($patternArray as $key=>$value){
    $pattern = str_replace('.', '', $value );
    $xPattern = str_split($pattern);
    $chunk = array_chunk($numberArray,count($xPattern)*2,true);
        print_r($chunk);
    $x = $key * 2 - 2;
    if($x <= 0){
        $x = 0;
    }
//    print_r($xPattern);
//    echo $x ." $pattern \n";
}

//print_r($numberArray);



//foreach ($patternArray as $key=> $value){
//    foreach ($numberArray as $key2=>$value2){
//        if($key * 2 == $key2){
//            echo strlen($value);
//            for ($i = 0; $i<strlen($value);$i++){
//                $a = array_splice($numberArray, $key,strlen($value)+1, $value[$i]);
//                print_r($a);
//            }
////            $numberArray = array_replace($numberArray,$patternArray);
////            $numberArray[$key]
//            break;
//        }
//    }
//    break;
//}
//
//print_r($patternArray);
//print_r($numberArray);


//bandymas su masyvu
//foreach ($data as $item)
//{
//    $pattern_without_number = str_replace($numbers,'',$item);
//    $position = strpos( $word, $pattern_without_number);
//
//    if($position !== false){
////        echo $position + strlen($item);
//        $leng = strlen($item);
//        $itemArray = str_split($item);
//
////        echo "postition - " . $position . " leng $leng - $item \n";
//        foreach ($itemArray as $letter){
//            if(is_numeric($letter) ){
////                $answers[] =
//            }
//        }
////        for ($i=0;$i<=count($itemArray);$i++){
////            echo $itemArray[$i];
////        }
//    }
//}
//$finalWord = '';
//foreach ($data as $pattern){
//    $pattern_without_number = str_replace($numbers,'',$pattern);
//    $wordWithoutNumbers = str_replace($numbers, '', $word);
//    $position = strpos( $wordWithoutNumbers, $pattern_without_number);
//
//    if($position !== false){
//        $answers[$position] = $pattern;
//        $word = str$pattern;
//        echo $word;
//        break;
//    }
//}

//foreach ($endings as $item){
//
//    $numbersWithDot = [0,1,2,3,4,5,6,7,8,9,'.'];
//    $item2 = trim(str_replace($numbersWithDot,'',$item));
//
//    if(strpos(substr($word,strlen($word) - strlen($item2)), $item2) !== false) {
//        $answers[strpos($word,$item2)] = $item;
//    }
//}
//
//foreach ($starting as $item){
//
//    $numbersWithDot = [0,1,2,3,4,5,6,7,8,9,'.'];
//    $item2 = trim(str_replace($numbersWithDot,'',$item));
//
//    if(strpos(substr($word,0), $item2) !== false && strpos(substr($word,0,), $item2) === 0){
//        $answers[strpos($word,$item2)] = $item;
//    }
//}
//
//ksort($answers);
//$finalWord = implode('',$answers);
//print_r($answers);

//remakeWord();

/*
Nurodytam faile esančios reikšmės susideda iš kelių simbolių ir skaičių.

• Įvestame žodyje turi būti rasti atitikmenys iš faile esančių reikšmių.
• Reikšmė .mis1 žodyje mistranslate atitinka žodžio pradžią (taškas reiškia pradžią, o skaičius įterpiamas po raidės).
• Reikšmė a2n žodyje mistranslate atitinka bet kurią vietą žodyje.
• Radus visus atitikmenis žodis turi būti perdarytas įterpiant skaičius į atitinkamas vietas tarp raidžių.
  Jei skaičių vietos kartojasi turi būti įterpiamas didžiausias.
• Perdarius žodį naudojant reikšmes gausime naują reikšmę kur nelyginiai skaičiai atitinka skiemens galą.
• Mistranslate žodį perdarius į .m2is1t4ra2n2s3l2a4te.
                                 0123456789    ir pakeitus nelyginius skaičius brūkšniu, gausime - mis-trans-late

*/