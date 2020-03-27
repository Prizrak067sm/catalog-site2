<?php
    echo "
        <form action='/catalog-site2.ru/admin/goodsAdd' class='tableForm' method='POST'>
        <table>
            <tr>
                <td> <label for='name_book'>Название книги: </label> </td>
                <td> <input type='text' name='name_book'> </td>
            </tr>
            
            <tr>
                <td> <label for='selectGenre'>жанр: </label> </td>
                <td id='td_selects'> 
                    <SELECT name='selectGenre_0'>";
                        foreach ($ids_and_genres_from_category as $row_id_and_genre)
                            echo "<OPTION value=".$row_id_and_genre['id'].">".$row_id_and_genre['genre']." </OPTION>";
            echo "  </SELECT> 
                    <input type='button' id='btnAddSelectGenre' onclick='addSelectGenre()'  value='Добавить жанр'>
                    <input type='button' id='btnDeleteSelectGenre' onclick='deleteSelectGenre()'  value='Удалить жанр'>
                </td>
            </tr>
            
            <tr>
                <td> <label for='brief_description'>Краткое описание книги: </label> </td>
                <td>  <textarea name='brief_description'> $brief_description </textarea> </td>
            </tr>
            
            <tr>
                <td> <label for='full_description'>Полное описание книги: </label> </td>
                <td>  <textarea name='full_description'> $full_description </textarea> </td>
            </tr>
            
            <tr>
                <td> <label for='availability'>В наличии: </label> </td>
                <td> <input type='number' name='availability' min='0' required> </td>
            </tr>
            
            <tr>
                <td> <label for='availability_order'>На заказ: </label> </td>
                <td> <input type='number' name='availability_order' min='0' required> </td>
            </tr>
            
            <tr>
                <td> <label for='activ'>Активность: </label> </td>
                <td> <input type='checkbox' name='activ'></td>
            </tr>
          
        </table>
              <input type='submit'>
        </form>
    ";

    echo "<h3 class='msgResult'>$msgResult</h3>"
?>