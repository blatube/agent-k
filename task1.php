<?php
/** Стороковой калькулятор.
 * Дана строка $expression, описывающая простое математическое выражение.
 * В строке могут встречаться только целые числа и знаки "+" и "-" (пробелы и другие знаки отсутствуют).
 * Необходимо написать функцию calculate ($expression), которая возвращает результат математического выражения.
 *
 * Важно именно написать алгоритм, использовать eval() не допускается.
 *
 * Пример:
 * $expression = '1+2'  = 3
 * $expression = '10-15' = -5

 * Описание алгоритма:
 *
 * Создадим два массива с отрицательными и положительными числами,
 * Для этого разобъем строку на массивы, где в качестве разделителя используем знак - и +
 * Получим сумму значений положительного и отрицательного массива, и отнимим 2ой от 1го.
 *
 * ЗАТРАЧЕНО: в конце работы, опишите сколько потребовалось времени.
 */

$expression1 = '100+5'; // 105
$expression2 = '5-5'; // 0
$expression3 = '10+6-12'; // 4

function calculate(string $expression):int {
    $negativeNumbers = [];
    $positiveNumbers = [];
    $isFirstNumberNegative = $expression[0] === '-';

    $dividedMinusArray = explode('-', $expression);
    $oneItemOneNumberArray = array_map(function ($item) {
        return explode('+', $item);
    }, $dividedMinusArray);

    foreach ($oneItemOneNumberArray as $key => $number) {

        if ($key !== 0 || $isFirstNumberNegative) {
            $negativeNumbers[] = $number[0];
            unset($oneItemOneNumberArray[$key][0]);
        }

        $positiveNumbers[] = array_sum($oneItemOneNumberArray[$key]);
    }

    return array_sum($positiveNumbers) - array_sum($negativeNumbers);
}

echo calculate($expression1);
echo calculate($expression2);
echo calculate($expression3);