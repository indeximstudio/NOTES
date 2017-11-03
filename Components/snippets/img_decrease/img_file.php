<?php
ini_set('memory_limit', '512M');//лимит для памяти

global $modx;
include_once('classSimpleImage.php');//клас для сжатия

$dir_name = 'cat';//указаваем имя нашей папки

$request = $modx->db->query( "SELECT * FROM ".$modx->getFullTableName('img_file')." WHERE ready = 0 ORDER BY id_img_file ASC LIMIT 1");
$row =$modx->db->getRow($request); //Фомируем массив данных с базы
$directory = "$row[directory]"; //Формируем путь
$newdirectory = str_replace($dir_name, $dir_name . '_new', $directory);//Новый путь
$filedirectory = "$directory$row[name]";//формируем путь с файлом
$newfiledirectory = "$newdirectory$row[name]";//Новый путь с файлом




if ($directory == '') { //если запрос пустой выдаем готовность
    echo 'Готово!';
} else {
    if (!file_exists($newdirectory)) { //Если нет папки создаем ее
        mkdir($newdirectory, 0777, true);
        echo 'Создана директория: ' . $newdirectory . '<br>';
    }

    $image = new SimpleImage();//Создаем объект
    $image->load($filedirectory);//Загружаем файл
    $modx->db->query("UPDATE ".$modx->getFullTableName('img_file')." SET `ready` = 1 WHERE `id_img_file` = $row[id_img_file]");//Заносим в базу начало работы
    if ($image->getWidth()>1000) { //если ширена файла больше нужной
        $image->resizeToWidth(1000);//уменьшаем картинку
        $image->save($newfiledirectory);//сохраняем картинку
        $modx->db->query("UPDATE ".$modx->getFullTableName('img_file')." SET `ready` = 2 WHERE `id_img_file` = $row[id_img_file]");//Заносим в базу готовность
        echo 'Файл уменьшен и сохранен: ' . $newfiledirectory . '<br>';
    } else {
        $image->save($newfiledirectory);//сохраняем файл
        $modx->db->query("UPDATE ".$modx->getFullTableName('img_file')." SET `ready` = 2 WHERE `id_img_file` = $row[id_img_file]");//Заносим в базу готовность
        echo 'Файл меньше нужного размера, сохранен: ' . $newfiledirectory . '<br>';
    }

}
