<?php
    echo "
        <form action='/catalog-site2.ru/admin/categoryAdd' class='tableForm' method='POST'>
        <table>
            <tr>
                <td><label for='genre'>Жанр: </label></td>
                <td><input type='text' name='genre' required></td>
            </tr>
            
            <tr>
                <td> <label for='brief_description'>Краткое описание жанра: </label> </td>
                <td> <input type='text' name='brief_description' required> </td>
            </tr>
            
            <tr>
                <td> <label for='full_description'>Полное описание жанра: </label> </td>
                <td> <input type='text' name='full_description' required> </td>
            </tr>
            
            <tr>
                <td> <label for='activ'>Активность: </label></td>
                <td> <input type='checkbox' name='activ'> </td>
            </tr>
            
        </table>
              <input type='submit'>
        </form>
    ";

    echo "<h3 class='msgResult'>$msgResult</h3>"
?>