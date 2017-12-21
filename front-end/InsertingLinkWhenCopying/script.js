/** Добавление ссылки на источник при копировании текста в блоке '.tovar' * */
function addLink() {
    var selection = window.getSelection();
    /* для исключения */
    /* if($.trim(selection) == 'Article' || $.trim(selection) == 'Test') {
        return selection;
    } */
    var body_element = $('body')[0];
    var pagelink = "<br>In detail: <a href='"+document.location.href+"'>"+document.location.href+"</a>";
    var copytext = selection + pagelink;
    var newdiv = document.createElement('div');
    newdiv.style.position='absolute';
    newdiv.style.left='-99999px';
    body_element.appendChild(newdiv);
    newdiv.innerHTML = copytext;
    selection.selectAllChildren(newdiv);
    window.setTimeout(function() {
        body_element.removeChild(newdiv);
    },0);
}
document.querySelector(".tovar").oncopy = addLink;