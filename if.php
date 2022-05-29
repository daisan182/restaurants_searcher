<?php
$even_num = [];
$odd_num = [];

function sort_number($num){
    
    global $even_num, $odd_num;
    
    if($num % 2 == 0){
        array_push($even_num, $num);
    }else{
        array_push($odd_num, $num);
    }
}

sort_number(1);
sort_number(4);
sort_number(5);
sort_number(8);

# 結果表示
var_dump($even_num);
var_dump($odd_num);
?>

