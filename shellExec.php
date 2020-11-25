<?php

$total = 1000;

Percentual(1000,500);

function Percentual($total,$y = 0){
    for($i=$y; $i<$total;$i++){
        usleep(1);
        
        $percent =  (100 * $i)/$total;
        echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
        printf("Gerando Arquivos "); 
        echo $percent+0.1.'%';
    }
}