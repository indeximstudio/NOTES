# bytehand - отправка смс


### Вызовы

##### Вызов на странице

например на странице "Спасибо за покупку"
````
[!bytehand? &phone=`123456789123` &text=`Заказ на сайте` &k=`1` !]
````

Вариант с получением данные из POST
````
[!bytehand? &phone=`79557231253` &text=`Hello world!` &postname=`formid` &postvalue=`ContactForm`!]
````

##### Вызов в коде
позволяет дописывать дополнительные данные, например дату
````
$modx->runSnippet('bytehand', array('phone'=>'123456789123', 'text'=>'Заказ на сайте ' . $date_t, 'k'=>'1'));
````

Пример использование в плагине на событие сохранения заказа
````
if ($type == 'OnSHKsaveOrder') {
    // если сохранение происходит клиентом, а не менеджером в админке
    if ($modx->getLoginUserType() != 'manager') {
        $date_t = date("Y-m-d H:i:s");
        $modx->runSnippet('bytehand', array('phone'=>'123456789123', 'text'=>'Заказ на сайте ' . $date_t, 'k'=>'1'));
    }
}
````

### Настройки
1) регистрация на сервисе
https://www.bytehand.com/ru

2) необходимо в коде сниппета заполнить данные из сервиса
````
$BYTEHAND['ID'] = "YOUR_ID";
$BYTEHAND['KEY'] = "YOUR_KEY";
$BYTEHAND['FROM'] = "YOUR_FROM";
````


### Дополнительная документация
http://modx.im/blog/addons/1665.html
https://www.bytehand.com/ru/solutions


