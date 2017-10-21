parsUrl.class.php
========
Класс с набором методов для получения содержимого страниц



``include_once MODX_BASE_PATH.'assets/libs/parsUrl.php';``

### request
``parsUrl::request``

+ получение страницы с записью в cookie.txt 

### read
``parsUrl::read``

+ получение страницы с получением предварительно данных из cookie.txt 


### read_ajax
``parsUrl::read_ajax``

+ получение страницы с получением предварительно данных из cookie.txt 
+ пример заголовка для ajax



### request_header
``parsUrl::read``

+ получение страницы с записью в cookie.txt 
+ передача заголовка

``// TODO собрать фанкции с заголовком и без в одну, с возможностью выбирать в параметрах использовать ajax или нет``