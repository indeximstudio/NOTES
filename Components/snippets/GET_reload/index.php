<?php
//Сниппет для авто перезагрузки страницы если в GET параметре передан reload=1, setTimeout указываем время в миллисекундах.
if ($_GET['reload']==1) {
    echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
          <script type="text/javascript">
          $(document).ready(function(){
            setTimeout(function(){
            location.reload();
            }, 3000);      
          });
          </script>';
}