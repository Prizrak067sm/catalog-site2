<?php
    //   ------- функция для вывода списка категорий. -------
    function display_category($str)
    {
        global $link;

        $query = 'SELECT id, Жанр FROM category WHERE Активность>0';   // Строка запроса на выборку записей всех жанров с значением поля активность больше нуля.
        $result_query = mysqli_query($link, $query);
        $rows_count = mysqli_num_rows($result_query);   // Количество записей в таблице.
        $cols_count = mysqli_num_fields($result_query); // Количество полей в таблице.

        $element_count = 5;   // Количество элементов на странице.
        $str_count = ceil($rows_count/$element_count);  // Количество страниц.

        $first_offset = $str*$element_count-$element_count;   // Смещение для первой строки на странице.

        mysqli_data_seek($result_query, $first_offset);     // Установка указателя на запись в таблице. В соответствии со страницей в аргументе.
        // --- Перебираем установленное количество записаей, формируем строку из записи по полям и выводим. ---
        for ($i=0; $i<$element_count; $i++)
        {
            $row = mysqli_fetch_row($result_query);
            if ($row)
            {
                $genre = '';   // Запись таблицы по запрошенным полям.
                for ($j=0; $j<$cols_count; $j++)
                {
                    $genre .= $row[$j] . ': ';
                }
                $genre = rtrim($genre, ": ");
                echo "$genre<hr>";
            }
            else
                break;
        }
        // ------- Конец цикла. -------

        // Вывод ссылок страниц. В параметрах - откуда переход; страница.
        for ($i=1; $i<=$str_count; $i++)
        {
            echo "<a href='?point=categ&str=$i'>$i   </a>";
        }
        // ------- Конец цикла. -------

        echo "<br>Вы на странице № $str";
    }
    // ------- Конец функции вывода списка категорий. -------

    // ------- функция для вывода товаров. -------
    function display_goods($str, $_query, $point, $category_id='')
    {
        global $link;

        $query = $_query;   // Строка sql запроса.
        $result_query = mysqli_query($link, $query);
        $rows_count = mysqli_num_rows($result_query);   // Количество записей в таблице.
        $cols_count = mysqli_num_fields($result_query); // Количество полей в таблице.

        $element_count = 7;   // Количество элементов на странице.
        $str_count = ceil($rows_count/$element_count);  // Количество страниц.

        $first_offset = $str*$element_count-$element_count;   // Смещение для первой строки на странице.

        mysqli_data_seek($result_query, $first_offset);     // Установка указателя на запись в таблице. В соответствии со страницей в аргументе.
        echo "<div align='center'>
                <table>
                    <tr>";
        // Вывод заголовков полей в таблицу.
        foreach (mysqli_fetch_fields($result_query) as $obj)
        {
            echo "<th>$obj->name</th>";
        }
        // -----------------------------------
        echo '</tr>';

        // --- Вывод записей в таблицу. ---
        for ($i=0; $i<$element_count; $i++)
        {
            $row = mysqli_fetch_row($result_query);
            if ($row)   // Строк на последней странице может быть меньше заданного максимума, поэтому, когда строки кончились, завершаем цикл.
            {
                echo '<tr>';
                for ($j=0; $j<$cols_count; $j++)
                {
                    echo "<td> $row[$j] </td>";
                }
                echo '</tr>';

            }
            else
                break;
        }
        // --- Конец цикла по выводу записей. ---
        echo "</table>";

        // --- Вывод ссылок на страницы. В параметрах: откуда переход; номер страницы; если передан
        //     в текущую функцию аргумент с ид категории, то предполагается вывод товаров по этой
        //     категории. Этот аргумент необходим для sql запроса, а также для однозначности выполнения. ---
        for ($i=1; $i<=$str_count; $i++)
        {
            if ($category_id=='')
            {
                $href = "?point=$point&str=$i";
            }
            else
            {
                $href = "?point=$point&str=$i&category_id=$category_id";
            }
            echo "<a href=$href>$i   </a>";
        }
        // --- Конец вывода ссылок. ---
        echo "<br>Вы на странице № $str
        </div>";
    }

    function display_id_tovar($id)
    {
        global $link;

        $query = "SELECT goods.id AS id_товара, GROUP_CONCAT(category.id) AS id_жанров, goods.`Название книги`, group_concat(category.`Жанр`) AS жанры, goods.`Краткое описание книги`, goods.`Полное описание книги`, goods.`Наличие (кол-во)`, goods.`Доступно для заказа` FROM goods LEFT JOIN categorygoods on goods.id = categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE goods.Id='$id'";
        $result_query = mysqli_query($link, $query);
        $row = mysqli_fetch_row($result_query);

        if ($row[0])    // Если по запросу возвращена запись, то...
        {
            $genres = explode(",", $row[3]);    // Категории(жанры) в ячейке перечислены через запятую. Создаем массив, элементы которого - категории(жанры).
            $id_genres = explode(",", $row[1]); // ИД категорий(жанров) в ячейке перечислены через запятую. Создаем массив, элементы которого - ИДы категорий(жанров).
            $genres_and_id = array_combine($genres, $id_genres); // Из массивов жанров и ИДов создаем ассоциативный массив жанр=>ид

            echo "<p><b>Название: </b> $row[2] </p>";
            echo "<p><b>Жанр(ы):  </b>";
            // --- Формируем строку ссылок на категории(жанры). ---
            $genresRefer ='';
            foreach ($genres_and_id as $key=>$value)
            {
                $genresRefer.= "<a href='?point=genres&category_id=$value'>$key</a>, ";
            }
            $genresRefer = rtrim($genresRefer,', ');
            // -----------------------------------------------------

            echo $genresRefer;
            echo "</p>";
            echo "<p><b>Краткое описание книги: </b> $row[4] </p>";
            echo "<p><b>Полное описание книги: </b> $row[5] </p>";
            echo "<p><b>В наличии: </b> $row[6] </p>";
            echo "<p><b>Возможно под заказ: </b> $row[7] </p>";
        }
        else  // если запрос не вернул запись, то переходим на страницу с ошибкой.
        {
         //   echo '<script language="javascript"> document.location.href = "" </script>';
        }
    }

    // --- Функция для полного вывода таблиц с добавлением поля с <radio>, для выбора записи. ---
    function displayAllTableForSQL($str, $_query, $_nameTable)
    {
        global $link;

        $nameTable = $_nameTable;   // Имя таблицы, которая будет выведена. Нужно для GET-запроса. Для реализации страниц.
        $query = $_query;
        $result_query = mysqli_query($link, $query);
        $rows_count = mysqli_num_rows($result_query);   // Количество записей в таблице.
        $cols_count = mysqli_num_fields($result_query); // Количество полей в таблице.

        $element_count = 4;   // Количество элементов на странице.
        $str_count = ceil($rows_count/$element_count);  // Количество страниц.

        $first_offset = $str*$element_count-$element_count;   // Смещение для первой строки на странице.

        mysqli_data_seek($result_query, $first_offset);     // Установка указателя на запись в таблице. В соответствии со страницей в аргументе.
        echo "<div align='center'>
                  <table>
                      <tr>
                          <th> Выбор </th>";
        // Вывод заголовков полей в таблицу.
        foreach (mysqli_fetch_fields($result_query) as $obj)
        {
            echo "<th>$obj->name</th>";
        }
        // ---------------------------------
        echo '</tr>';

        // --- Вывод записей в таблицу. ---
        for ($i=0; $i<$element_count; $i++)
        {
            $row = mysqli_fetch_row($result_query);   // Получаем запись.
            if ($row)   // Строк на последней странице может быть меньше заданного максимума, поэтому, когда строки кончились, завершаем цикл.
            {
                echo '<tr>';
                echo "<td> <input type='radio' name='check' value=$row[0] required> </td>";   // Ячейка(будет первый столбец) с элементом выбора. Значением - ид товара.
                for ($j=0; $j<$cols_count; $j++)
                {
                    echo "<td> $row[$j] </td>";
                }
                echo '</tr>';
            }
            else
                break;

        }
        echo '</table>';

        // --- Ссылки страниц. ---
        for ($i=1; $i<=$str_count; $i++)
        {

            echo "<a href='?point=ShowAllTableRadio&nameTable=$nameTable&str=$i'>$i   </a>";
        }
        // ------------------------

        echo "<br>Вы на странице № $str
              </div>";
    }
?>