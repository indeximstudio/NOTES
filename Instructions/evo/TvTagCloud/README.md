# Инструкции для тегов TvTagCloud
1. Создаем TV-пареметр tags со значением Text и указываем все шаблоны, для которых он будет применяться. Теперь на тех страницах, где должны быть теги, заполняем параметр tags, указывая теги через запятую.

2. Создаем новый документ в дереве ресурсов. В настройках страницы убираем галочки с «Использовать HTML-редактор», «Доступен для поиска» и «Кэшируемый», также убираем галочку с «Показывать в меню». Сохраняем ресурс, потом опять заходим в него и в содержимом ресурса помещаем такой вызов FormLister:
```html
[[DocLister?
    &parseDocumentSource=`1`
    &parents=`22`
    &display=`10`
    &summary=`notags,len`
    &dateSource=`pub_date`
    &id=`list`
    &tpl=`tags_content_tpl`
    &dateFormat=`%d.%m.%Y в %H:%M`
    &dateSource=`pub_date`
    &depth=`10`
    &tagsTV=`6`
    &tagsData=`get:tags`
    &controller=`site_content_tags`
    &PrevNextAlwaysShow=`1`
    &paginate=`pages`
    &TplPage=`@CODE: <li class="paginate_button page-item"><a class="page-link" href="[(_root)][+link+]">[+num+]</a></li>`
                    &TplCurrentPage=`@CODE: <li class="paginate_button page-item active"><a href="[(_root)][+link+]" class="page-link">[+num+]</a></li>`
                    &TplWrapPaginate=`@CODE: <ul class="pagination justify-content-center">[+wrap+]</ul>`
                    &TplFirstP=`@CODE: <li><a href="[(_root)][+link+]"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span></a></li>`
                    &TplLastP=`@CODE: <li><a href="[(_root)][+link+]"><span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></a></li>`
                    &TplNextP=`@CODE: <li class="paginate_button page-item next"><a class="page-link" href="[(_root)][+link+]"><i class="fa fa-lg fa-angle-right"></i></a></li>`
                    &TplPrevP=`@CODE: <li class="paginate_button page-item previous"><a class="page-link" href="[(_root)][+link+]"><i class="fa fa-lg fa-angle-left"></i></a></li>`
                    &TplNextI=`@CODE: <li class="paginate_button page-item next disabled"><a class="page-link" href="[(_root)][+link+]"><i class="fa fa-lg fa-angle-right"></i></a></li>`
                    &TplPrevI=`@CODE: <li class="paginate_button page-item previous disabled"><a class="page-link" href="[(_root)][+link+]"><i class="fa fa-lg fa-angle-left"></i></a></li>`
                    ]]
                    [+list.pages+]
```
3. В месте, где должно быть облако, помещаем вызов TvTagCloud:
```html
[[TvTagCloud?
    &parent=`[*id*]`
    &landing=`44`
    &tvTags=`tags`
    &showCount=`0`
    &sort=`random`
    &limit=`50`
    &displayType=`list`
    &caseSensitive=`1`
    &displayType=`custom`
    &customDisplayChunk=`customTagsChunk`
    ]]
```
4. Устанавливаем плагин TagSaver. Задаем параметры ID TV-параметра который мы создали, и Разделитель тегов, через который они будут записаны.
5. Смотрим ли создались таблице в базе
