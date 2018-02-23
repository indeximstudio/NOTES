<?php

/**
 * Сравнивает в строке количество открывающих и закрывающих скобок
 * и запускает соответственную функцию
 *
 * @param string $sString
 * @return null|string
 */
function checkBrackets($sString = null)
{
    // проверка на то, что данные были переданы, и строка не пустая
    if (is_null($sString) || $sString == '') {
        return '';
    }
    // количество скобок ОДИНАКОВОЕ - возвращаем исходную строку
    if (substr_count($sString, ')') == substr_count($sString, '(')) {
        return $sString;
    }
    // количество скобок РАЗНОЕ
    // количество открывающих больше
    if (substr_count($sString, '(') > substr_count($sString, ')')) {
        $sString = searchFirstSymbol($sString, '(', ')');
    }
    // количество закрывающих больше
    if (substr_count($sString, '(') < substr_count($sString, ')')) {
        $sString = searchLastSymbol($sString, ')', '(');
    }

    return $sString;
}