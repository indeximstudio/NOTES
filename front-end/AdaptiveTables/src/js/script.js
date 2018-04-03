$(document).ready(function(){
// дать таблице класс "table_adaptive"
    var th = $('table.table_adaptive tr th');
    th.each(function () {
        var th_index = th.index(this);
        var th_text = $(this).text();
        var tr = $('table.table_adaptive tr');
        tr.each(function () {
            $(this).children('td').eq(th_index).attr('data-head', th_text);
        });
    });
// \ адаптивные таблицы
});