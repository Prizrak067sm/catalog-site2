<?php
    extract($data_model);

// Получаем массив категорий(жанров) из списка категорий, к которым относится товар.
// Это нужно для отображения на вьюшке соответствующего количества выпадающих списков, а также для
// отправки в контроллер(а там в БД) иды категорий к которым относится товар.
$enteredGenres = explode(',', $genre);
$enteredGenres = array_map("trim", $enteredGenres);   // Удаляем все пробелы с каждо
// ------------------------------------------

$count_enteredGenres = count($enteredGenres);   // Количество категорий(жанров), относящихся к выбранному товару.

    echo "<h2 align='center'>Вы выбрали книгу << $name_book >></h2>";
    echo "
        <p><b>id: </b>$id</p>
        <p><b>Название книги: </b>$name_book</p>
        <p><b>Жанр: </b>$genre</p>
        <p><b>Краткое описание: </b>$brief_description</p>
        <p><b>Полное описание: </b>$full_description</p>
        <p><b>В наличии: </b>$availability</p> 
        <p><b>В наличии под заказ: </b>$availability_order</p> 
        <p><b>Активность: </b>$activ</p>         
    ";

    if ($activ>0)
        $checked ='checked';
    else
        $checked = '';

    echo "
        <form action='/catalog-site2.ru/admin/goodsEdit/update' class='tableForm' method='POST'>
        <p><b>Внесите необходимые изменения:</b></p>
            <table>
                <tr>
                    <td>  <label for='name_book'>Название книги: </label>  </td>
                    <td>  <input type='text' name='name_book' value='$name_book'>  </td>
                </tr>
                 
                <tr>
                    <td>  <label>Жанр(ы): </label>  </td>
                    <td id='td_selects'>";
                        // --- Формируем выпадающий список(или списки) категорий.
                        //     Сколько категорий соответствует выбранному товару, столько <SELECT>
                        //     будет создано для изменения жанра. Имя селекта  selectGenre_0, selectGenre_1 и т.д.
                        //     $allGenres - это строки (массив строк) таблицы с category, переданные с контроллера. Строка состоит из id и genre. ---
                        for ($i=0; $i<$count_enteredGenres; $i++)
                        {
                            echo "
                                  <SELECT name='selectGenre_$i'>";
                            foreach ($allGenres as $rowGenre)
                            {
                                $id_genre = $rowGenre['id'];
                                $genre = $rowGenre['genre'];

                                $selected = '';
                                if ($genre==$enteredGenres[$i])   // Если очередная категория соответствует очередной категории, соответствующей выбранному товару - добавляем значение для переменной, которая является атрибутом выбранного элемента списка.
                                    $selected = 'selected';
                                echo "<option $selected value=$id_genre> $genre </option>";
                            }
                            echo "</SELECT>";
                        }
                        // ------Списки сформированы. ------------------------------------------------------------------------------------------------
                echo "<input type='button' id='btnAddSelectGenre' onclick='addSelectGenre()'  value='Добавить жанр'>
                      <input type='button' id='btnDeleteSelectGenre' onclick='deleteSelectGenre()'  value='Удалить жанр'>
                      </td>
                </tr>
                
                <tr>
                    <td>  <label for='brief_description'>Краткое описание: </label>  </td>
                    <td>  <textarea name='brief_description'> $brief_description </textarea> </td>
                </tr>
                
                <tr>
                    <td>  <label for='full_description'>Полное описание: </label>  </td>
                    <td>  <textarea name='full_description'> $full_description </textarea> </td>
                </tr>
                
                <tr>
                    <td>  <label for='availability'>В наличии: </label>  </td>
                    <td>  <input type='text' name='availability' value='$availability'>  </td>
                </tr>
                
                <tr>
                    <td>  <label for='availability_order'>В наличии под заказ: </label>  </td>
                    <td>  <input type='text' name='availability_order' value='$availability_order'>  </td>
                </tr>
                
                <tr>
                    <td>  <label for='activ'>Активность: </label>  </td>
                    <td>  <input type='checkbox' name='activ' $checked value='$activ'>  </td>
                </tr>                
            </table>
            <input type='text' name='id' value='$id' hidden>
            <input type='submit'>
        </form>
    ";
?>















