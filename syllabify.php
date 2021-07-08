<?php

function syllabify(array $array,string $word){
    foreach ($array as $item){
        if(strncmp('mis',$word,4)){
            echo "hi";
            break;
        }
    }
}


//starting
//foreach ($starting as $item){
//
//    $numbersWithDot = [0,1,2,3,4,5,6,7,8,9,'.'];
//    $item2 = trim(str_replace($numbersWithDot,'',$item));
//
//    if(strpos(substr($word,0), $item2) !== false && strpos(substr($word,0,), $item2) === 0){
//        echo $item . "\n";
//    }
//}
//
////ending
//foreach ($endings as $item){
//
//    $numbersWithDot = [0,1,2,3,4,5,6,7,8,9,'.'];
//    $item2 = trim(str_replace($numbersWithDot,'',$item));
//
//    if(strpos(substr($word,strlen($word) - strlen($item2)), $item2) !== false) {
//        echo $item . "\n";
//    }
//}
//
////works
////body
//foreach ($data as $item)
//{
//    $item2 = trim(str_replace($numbers,'',$item));
//    if(strpos($word, $item2) !== false){
//        echo $item . "\n";
//    }
//}
