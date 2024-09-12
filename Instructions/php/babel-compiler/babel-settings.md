# Установка и настройка Babel

1. Переходим в папку куда можно установить node_modules
2. Устанавлеваем Babel через npm: 
npm install --save-dev babel-cli 
3.  Phpstorm заходим:
##### Preferences - Tools - File watchers
жмем на плюсик, выбераем Babel
4. В поле Program указываем путь к файлу node_modules/.bin/babel
5. Устанавливаем присет для компиляции файлов
npm install babel-preset-env --save-dev
6. В настройках babel в поле Arguments прописуем параметры: 
$FileRelativeDir$ --out-dir $FileRelativeDir$ --source-maps --presets env
7. В поле Output paths прописываем: 
$FileNameWithoutExtension$-babel.js:$FileNameWithoutExtension$-babel.js.map

### Компиляция готова
