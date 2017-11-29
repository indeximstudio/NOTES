<?php
/**
 * Производит поиск подстроки $subStrToDel в строке $string сначала строки. Удаляет лишние и возвращает строку.
 * Функция корректно работает если в строке один уровень вложенности подстрок.
 * Например, скобки: текст (текст) текст (текст
 *
 * @param string $string строка в которой проиводится поиск
 * @param string $subStrToDel удаляемая подстрока
 * @param string $subStrToCheck подстрока с которой производится сравнение
 * @return string
 */
function searchFirstSymbol($string, $subStrToDel, $subStrToCheck)
{
    if (isset($string) && $string != '' && isset($subStrToDel) && $subStrToDel != '' && isset($subStrToCheck) && $subStrToCheck != '') {
        // Формируем массив с кодами, на которые будут заменяться подстроки для работы функции
        $arrSpecCode = array(
            'specSymbolDel' => '::DEL::',
            'specSymbolTempO' => '::OPEN::',
            'specSymbolTempC' => '::TEMPC::',
            'specSymbolC' => '::CLOSE::'
        );

        // Получаем количество удаляемых символов и запускаем цыкл
        for ($i = substr_count($string, $subStrToDel); $i; $i--) {

            // Ищем символ который удаляем
            $posSubStrToDel = mb_stripos($string, $subStrToDel);
            if ($posSubStrToDel !== FALSE) {
                // Помечаем символ кодом "ДЛЯ УДАЛЕНИЯ", чтоб она не мешала поиску следующей скобки
                $string = substr_replace($string, $arrSpecCode['specSymbolDel'], $posSubStrToDel, mb_strlen($subStrToDel));

                // Ищем проверочный символ
                $posSubStrToCheck = mb_stripos($string, $subStrToCheck);
                if ($posSubStrToCheck !== FALSE) {
                    // Если нашли проверочный символ, меняем его на "ВРЕМЕННЫЙ" код
                    $string = substr_replace($string, $arrSpecCode['specSymbolTempC'], $posSubStrToCheck, mb_strlen($subStrToCheck));

                    // Ищем второй символ для удаления который возможно ближе к проверочному
                    $posTwoSubStrToDel = mb_stripos($string, $subStrToDel);
                    if ($posTwoSubStrToDel !== FALSE) {
                        // Если символ найден, сравниваем его с первым на отдаленность от проверочного
                        // ((позиция первого + позиция проверочного) < (позиция второго + позиция проверочного) и первый и второй должны стоять перед проверочным)
                        if (($posSubStrToDel + $posSubStrToCheck) < ($posTwoSubStrToDel + $posSubStrToCheck) && $posSubStrToDel < $posSubStrToCheck && $posTwoSubStrToDel < $posSubStrToCheck) {
                            // Если второй символ ближе к проверочному - первый удаляем
                            $string = str_replace($arrSpecCode['specSymbolDel'], '', $string);
                            // Возвращаем первоначальный вид проверочного символа (удаляем метку)
                            $posSubStrToCheck = mb_stripos($string, $arrSpecCode['specSymbolTempC']);
                            $string = substr_replace($string, $subStrToCheck, $posSubStrToCheck, mb_strlen($arrSpecCode['specSymbolTempC']));
                        } else {
                            // Если второй символ дальше от проверочного
                            // Обновляем позицию метки первого символа и меняем ее на "ПОСТОЯННУЮ"
                            $posSubStrToDel = mb_stripos($string, $arrSpecCode['specSymbolDel']);
                            $string = substr_replace($string, $arrSpecCode['specSymbolTempO'], $posSubStrToDel, mb_strlen($arrSpecCode['specSymbolDel']));
                            // Обновляем позицию метки проверочного символа и меняем ее на "ПОСТОЯННУЮ"
                            $posSubStrToCheck = mb_stripos($string, $arrSpecCode['specSymbolTempC']);
                            $string = substr_replace($string, $arrSpecCode['specSymbolC'], $posSubStrToCheck, mb_strlen($arrSpecCode['specSymbolTempC']));
                        }
                    } else {
                        // Если второго символа для удаления не найдено
                        // Меняем метку удаляемого символа на "ПОСТОЯННУЮ"
                        $posSubStrToDel = mb_stripos($string, $arrSpecCode['specSymbolDel']);
                        $string = substr_replace($string, $arrSpecCode['specSymbolTempO'], $posSubStrToDel, mb_strlen($arrSpecCode['specSymbolDel']));
                        // Меняем "ВРЕМЕННУЮ" метку проверочного символа на "ПОСТОЯННУЮ"
                        $posSubStrToCheck = mb_stripos($string, $arrSpecCode['specSymbolTempC']);
                        $string = substr_replace($string, $arrSpecCode['specSymbolC'], $posSubStrToCheck, mb_strlen($arrSpecCode['specSymbolTempC']));
                    }

                } else {
                    // Не нашли проверочный символ, удаляем найденный для удаления символ
                    $string = str_replace($arrSpecCode['specSymbolDel'], '', $string);
                }
            }
            // При последней итерации заменяем "ПОСТОЯННЫЕ" метки символов на сами символы
            if ($i == 1) {
                $string = str_replace($arrSpecCode['specSymbolTempO'], $subStrToDel, $string);
                $string = str_replace($arrSpecCode['specSymbolC'], $subStrToCheck, $string);
            }
        }

        return $string;
    }
    return '';
}
