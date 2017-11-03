<?php
global $modx;

//Нужно импортировать две таблицы одну для папок, вторую для файлов. Либо создать в базе самому.
//Для папок: evo_papti структура: id_papki(int), name(varchar 255), direktory(varchar 255), ready(int), files(int).
//Для файлов: evo_img_file структура: id_img_file(int), name(varchar 255), direktory(varchar 255), ready(int).

//Заносим в таблицу evo_papki первую запись с нужной нам папкой, имя паки и путь к ней, ready и file выставляем 0.


$request = $modx->db->query('SELECT * FROM `evo_papki` WHERE `ready` = 0 ORDER BY `id_papki` ASC LIMIT 1');
$row = $modx->db->getRow($request, assoc); //Фомируем массив данных с базы
$directory = "$row[directory]$row[name]/"; //Формируем путь

print_r($row);
echo '<br>';

if ($directory == '/') { //если получаем пустой запрос выдаем готовность
    echo 'Готово!';
} else {
    $dir = opendir($directory); //открываем папку
    while ($file = readdir($dir)) { //перебераем все елементы
        if (is_dir($directory . $file) && $file != '.' && $file != '..' && ([] !== (array_diff(scandir($directory . $file), array('.', '..'))))) { //проверяем являеться ли элемент папкой и есть ли в ней элементы
            echo 'Папка добавлена в базу: ' . $directory . $file . '<br>';
            $modx->db->query("INSERT INTO `evo_papki` VALUE ('', '$file', '$directory', '0', '0')"); //добавляем елемент в базу
        }
        if (is_dir($directory . $file) && $file != '.' && $file != '..' && ([] === (array_diff(scandir($directory . $file), array('.', '..'))))) { //проверяем наличие пустых папок
            echo 'Пустая папка удалена: ' . $directory . $file . '<br>';
            rmdir($directory . $file); //удаляем папку
        }
        if (is_file($directory . $file)) { //проверяем наличие файлов в папке
            echo 'Файл добавлен в базу: ' . $directory . $file . '<br>';
            $modx->db->query("UPDATE `evo_papki` SET `files` = 1 WHERE `id_papki` = $row[id_papki]");//наличие файлов в папке
            $modx->db->query("INSERT INTO `evo_img_file` VALUE ('', '$file', '$directory', '0')"); //добавляем файл в базу
        }
    }
    $modx->db->query("UPDATE `evo_papki` SET `ready` = 1 WHERE `id_papki` = $row[id_papki]"); //меняем value текущей директории на готовноть
}
