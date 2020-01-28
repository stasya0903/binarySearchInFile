<?php

function generateFile($fileName,$count){
    $file=fopen($fileName,"w");
    for ($i = 0;$i < $count; $i++){
        fwrite($file,"ключ".$i."\t"."значение".$i."\x0A");
    }
}




function binarySearch ($file, $key){

    $fileObj = new SplFileObject($file);
    $n = 0;
    $left = 0;
    $fileObj->seek(PHP_INT_MAX);
    $right = $fileObj->key();
    while ($left <= $right) {
        $n++;
        $middle = floor(($left+$right)/2);

        echo "Проверяется элемент с индексом: $middle". PHP_EOL;

        $fileObj->seek($middle);
        $currentElement = explode("\t", $fileObj->current());

        if (strnatcmp($currentElement[0],$key) == 0) {
            echo "КОЛИЧЕСТВО ИТЕРАЦИЙ: ".$n . PHP_EOL;
            return $currentElement[1];
        }

        elseif (strnatcmp($currentElement[0],$key) > 0) {
            $right = $middle - 1;
        }

        elseif (strnatcmp($currentElement[0],$key) < 0) {
            $left = $middle + 1;
        }

    }

    echo "КОЛИЧЕСТВО ИТЕРАЦИЙ: ".$n.PHP_EOL;
    return "undef";

}
$start = microtime(true);
echo binarySearch("test.txt", "ключ1000000");
echo  microtime(true) - $start;