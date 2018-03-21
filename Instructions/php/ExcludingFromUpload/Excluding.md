# Исключение файлов из выгрузки по названию

Для исключения файлов, которые не желательно чтобы находились на сервере (.gitignore, минимизированых файлов *.min.min. *, и других).

1. Перейти с главного меню, или же другим способом, в настройки развертывания (Deployment)  
`Tools -> Deployment -> Options`  

![install_less_cmd](excluding.jpg)  

2. Дописать маску файлов через разделитель - `;` (IDE сама подсказывает как).  
На пример:   

    стандартная строка `.svn;.cvs;.idea;.DS_Store;.git;.hg;*.hprof;*.pyc`

    необходимые маски файлов `*.min.min.*` и `*.gitignore`

    результат `.svn;.cvs;.idea;.DS_Store;.git;.hg;*.hprof;*.pyc;*.min.min.*;*.gitignore`

![install_less_cmd](excluding1.jpg)

>**Полезно**  
>* *Подробная инструкция по настройке от jetbrains*
https://www.jetbrains.com/help/phpstorm/excluding-files-and-folders-from-upload-download.html