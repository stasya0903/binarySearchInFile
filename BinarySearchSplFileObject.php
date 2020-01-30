<?php
/**
 * Функция нахождения размера файла размером больше 2 ГБ
 * Источник php.net/manual/ru/function.filesize.php
 * @param $file
 * @return false|int|mixed
 */
function find_filesize($file)
{
    if (substr(PHP_OS, 0, 3) == "WIN") {
        exec('for %I in ("' . $file . '") do @echo %~zI', $output);
        $return = $output[0];
    } else {
        $return = filesize($file);
    }
    return $return;
}

/**
 * @param $file
 * @param $key
 * @return mixed|string
 */

function binarySearch($file, $key)
{
    // создаем обьект файла используя библеотеку SPL
    $fileObj = new SplFileObject($file);
    // инициализируем счетчик итераций
    $n = 0;
    // ставим левую границу  поиска в начало файла
    $left = 0;
    //определяем размер файла
    $fileSize = find_filesize($file);
    // переносим указатель в конец файла
    $fileObj->seek($fileSize);
    // получаем значение коненой строки
    $right = $fileObj->key();
    // ищем по файлу пока правая граница поиска не выходит за левую
    while ($left <= $right) {
        // на каждом проходе прибавляем кол-во инициализаций
        $n++;
        // вычесляем среднее значение
        $middle = floor(($left + $right) / 2);
        echo "Проверяется элемент с индексом: $middle" . "</br>";
        // переводим индекс в среднее значение
        $fileObj->seek($middle);
        // создаем массив из текущего значения
        $currentElement = explode("\t", $fileObj->current());
        // сравниваем с помощью алгоритма "natural order"
        // если ключ совпадает выходим из цикла и возвращаем значение
        if (strnatcmp($currentElement[0], $key) == 0) {
            echo "КОЛИЧЕСТВО ИТЕРАЦИЙ: " . $n . "</br>";
            return $currentElement[1];
            // в случае если функция strnatcmp возвращает отриц значение ключ находиться выше текущего значения
        } elseif (strnatcmp($currentElement[0], $key) > 0) {
            //чтобы продолжить поиск в левой половине перемещаем правую границу в положение середины
            $right = $middle - 1;
            // в случае если функция strnatcmp возвращает полож  значение ключ находиться  ниже текущего значения
        } elseif (strnatcmp($currentElement[0], $key) < 0) {
            //чтобы продолжить поиск в правой половине перемещаем левую  границу в положение середины
            $left = $middle + 1;
        }

    }

    echo "КОЛИЧЕСТВО ИТЕРАЦИЙ: " . $n . "</br>";
    return "undef";

}

$start = microtime(true);
echo binarySearch("test.txt", "ключ1000000");
echo microtime(true) - $start;