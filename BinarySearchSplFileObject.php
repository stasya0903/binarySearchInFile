<?php
function find_filesize($file)
{
    if(substr(PHP_OS, 0, 3) == "WIN")
    {
        exec('for %I in ("'.$file.'") do @echo %~zI', $output);
        $return = $output[0];
    }
    else
    {
        $return = filesize($file);
    }
    return $return;
}

function binarySearch ($file, $key){

    $fileObj = new SplFileObject($file);
    $n = 0;
    $left = 0;
    $fileSize = find_filesize($file);
    $fileObj->seek($fileSize);
    $right = $fileObj->key();
    while ($left <= $right) {
        $n++;
       $middle = floor(($left+$right)/2);


        echo "Проверяется элемент с индексом: $middle".  "</br>";

        $fileObj->seek($middle);
        $currentElement = explode("\t", $fileObj->current());

        if (strnatcmp($currentElement[0],$key) == 0) {
            echo "КОЛИЧЕСТВО ИТЕРАЦИЙ: ". $n .  "</br>";
            return $currentElement[1];
        }

        elseif (strnatcmp($currentElement[0],$key) > 0) {
            $right = $middle - 1;
        }

        elseif (strnatcmp($currentElement[0],$key) < 0) {
            $left = $middle + 1;
        }

    }

    echo "КОЛИЧЕСТВО ИТЕРАЦИЙ: ".$n. "</br>";
    return "undef";

}
$start = microtime(true);
echo binarySearch("test.txt", "ключ1000000");
echo   microtime(true) - $start;