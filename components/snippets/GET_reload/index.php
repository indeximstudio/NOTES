<?php
//Сниппет для авто перезагрузки страницы если в GET параметре передан reload=1.
//При добавлении в GET одного из параметров time мы указываем через какой промежуток времени страница будет перезагружаться.
//ВАЖНО можно добавлять лишь один параметр времени секунды, минуты или часы!

$a=5000;

if(isset($_GET['timesec'])){
    $a=$_GET['timesec']*1000;
}
if(isset($_GET['timemin'])){
    $a=$_GET['timemin']*60000;
}
if(isset($_GET['timehour'])){
    $a=$_GET['timehour']*3600000;
}

if ($_GET['reload'] == 1) {
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script type="text/javascript">
          $(document).ready(function(){
            setTimeout(function(){
            location.reload();
            },' . $a . ');
          });
          </script>';
}