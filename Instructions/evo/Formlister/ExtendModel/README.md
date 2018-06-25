# Расширение модели `assets/lib/MODxAPI/modUsers.php` для исполнения действий с добавлеными полями атрибутов пользователя (в `таблице web_user_attributes`)

* Создать новый файл
* Подключить и унаследовать стандартную модель `assets/lib/MODxAPI/modUsers.php`
* Добавить в масив новые поля и типы данных
* Добавить параметры `model` и `modelPath` в вызове Formlister с контроллерами `Register` и `Profile`

>**Example:**
```
<?php
require_once('modUsers.php');

/**
 * Class modUsersNew
 */
class modUsersNew extends modUsers
{
    public function __construct(DocumentParser $modx, $debug = false)
    {
        $this->default_field['attribute']['lastname'] = '';
        $this->default_field['attribute']['adress'] = '';
        $this->default_field['attribute']['company'] = '';
        parent::__construct($modx, $debug);
    }
}
```