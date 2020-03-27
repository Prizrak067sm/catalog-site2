function addSelectGenre()
{
    var td_selects = document.getElementById("td_selects");   // Ячейка, где все селекты.
    var selects = td_selects.getElementsByTagName("select");   // Получаем массив селектов.
    var num_new_select = selects.length;   // Порядковый номер нового селекта = количество имеющихся в ячейке селектов(Так как нумерация с 0).
    var new_select = selects[0].cloneNode(true);   // Создаем новый селект, копируя имеющийся(первый).
    new_select.name = "selectGenre_"+num_new_select;   // Изменяем имя нового селекта. Добавляя порядковый номер к имени selectGenre_
    var btnAddSelectGenre = td_selects.getElementsByTagName("input")[0];   // Получаем кнопку, расположенную после селектов, штатно это кнопка, добавляющую списки (селекты), чтобы новые селекты добавлять перед ней.
    td_selects.insertBefore(new_select, btnAddSelectGenre);   // Добавляем созданный селект перед полученной кнопкой.
}

function deleteSelectGenre()
{
    var td_selects = document.getElementById("td_selects");   // Ячейка, где все селекты.
    var selects = td_selects.getElementsByTagName("select");   // Получаем массив селектов.
    var last_select = selects.length-1;   // Индекс последнего селекта.
    if (last_select != 0)
    {
        td_selects.removeChild(selects[last_select]);
    }
    else
        alert("Один жанр необходимо оставить!")
}
