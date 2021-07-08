<?php


function remakeWord(){
    $numbers = [0,1,2,3,4,5,6,7,8,9];
    $oddNumbers = [1,3,5,7];

    $a = 'm2is1t4ra2n2s3l2a4te';

    $a = str_replace($oddNumbers, '-',$a);
    $a = str_replace($numbers, '',$a);

    echo $a . "\n";
}
