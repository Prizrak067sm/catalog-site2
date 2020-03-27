<?php
    extract($data_model);
    echo "<h2 align='center'>Вы выбрали жанр << ".$data_model['genre']." >></h2>";
    echo "
        <p><b>id: </b>$id</p>
        <p><b>Жанр: </b>$genre</p>
        <p><b>Краткое описание: </b>$brief_description</p>
        <p><b>Полное описание: </b>$full_description</p>
        <p><b>Активность: </b>$activ</p>         
    ";

    if ($activ>0)
        $checked ='checked';
    else
        $checked = '';

    echo "
        <form action='/catalog-site2.ru/admin/categoryEdit/update' class='tableForm' method='POST'>
        <p><b>Внесите необходимые изменения:</b></p>
            <table>
                <tr>
                    <td>
                        <label for='genre'>Жанр: </label>
                        <label for='brief_description'>Краткое описание жанра: </label>
                        <label for='full_description'>Полное описание жанра: </label>
                        <label for='activ'>Активность: </label>
                    </td>
    
                    <td>
                        <input type='text' name='id' value='$id' hidden>
                        <input type='text' name='genre' value='$genre' required>
                        <input type='text' name='brief_description' value='$brief_description' required>
                        <input type='text' name='full_description' value='$full_description' required>
                        <input type='checkbox' name='activ' $checked value='$activ'>
                    </td>
                </tr>
            </table>
            
            <input type='submit'>
        </form>
    ";
?>