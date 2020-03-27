<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title>Админка</title>
    </head>

    <body class="bodyAdminka">
        <!-- Список для выбора основных действий. -->
        <div align="center">
            <form action="admin.php" method="post" >
                <select name="act">
                    <option value="opt1"> Получить список доступных в таблице category категорий </option>
                    <option value="opt2"> Получить список доступных в таблице goods товаров  </option>
                    <option value="opt3"> Добавить новую категорию </option>
                    <option value="opt4"> Редактировать существующую категорию </option>
                    <option value="opt5"> Добавить новый товар </option>
                    <option value="opt6"> Редактировать существующий товар </option>
                </select>
                <input type="submit" value="Далее">
            </form>
        </div>
        <!-- ---------------------------------------- -->

        <?php
            require "myFunction.php";   // Подключаем свой файл с функциями.
            $link = mysqli_connect('localhost', 'root','1234567','catalog-site');

            if (isset($_POST['act']))   // Если выбрано основное действие из списка.
            {
                switch ($_POST['act'])  // Определяем какое выбрано основное действие из списка.
                {
                    case 'opt1':   // Получить список доступных в таблице category категорий.
                    {
                        display_category(1);
                        break;
                    }
                    case 'opt2':   // Получить список доступных в таблице goods товаров.
                    {
                        $query = 'SELECT id, `Название книги`, `Наличие (кол-во)`, `Доступно для заказа` FROM goods WHERE Активность>0';
                        display_goods(1, $query, 'goods');
                        break;
                    }
                    case 'opt3':   // Добавить новую категорию.
                    {
                        echo "
                            <form action='admin.php' method='POST'>
                                <label for='Жанр'>Жанр: </label>
                                <input type='text' name='Жанр'>
                                </br>
                                <label for='Краткое описание жанра'>Краткое описание жанра: </label>
                                <input type='text' name='Краткое описание жанра'>
                                </br>
                                <label for='Полное описание жанра'>Полное описание жанра: </label>
                                <input type='text' name='Полное описание жанра'>
                                </br>
                                <label for='Активность'>Активность: </label>
                                <input type='checkbox' name='Активность'>
                                </br>
                                <input type='submit' name='addCategory'>
                            </form>
                        ";
                        break;
                    }
                    case 'opt4':   // Редактировать существующую категорию.
                    {
                        $query = "SELECT * FROM category";
                        echo "<form action='admin.php' method='POST' align='center'>";
                                  displayAllTableForSQL(1, $query,'category');
                                  echo "<br> <input type='submit' name='updCategory' value='Выбрать'>
                              </form>";
                        break;
                    }
                    case 'opt5':   // Добавить новый товар.
                    {
                        // Выборка жанров и соответствующих идентификаторов из таблицы category(нужно для формы).
                        $query = "SELECT id, Жанр FROM category";
                        $result_query = mysqli_query($link, $query);
                        $rows_count = mysqli_num_rows($result_query);
                        // -------

                        echo "
                            <form action='admin.php' method='POST'>
                                <label for='Название книги'>Название книги: </label>
                                <input type='text' name='Название книги'>
                                </br>
                                <label for='genre'>Жанр: </label>
                                <SELECT name='genre'>";
                                    for($i=0; $i<$rows_count; $i++)
                                    {
                                        $row = mysqli_fetch_row($result_query);
                                        echo "<OPTION value=$row[0]> $row[1] </OPTION>";
                                    }
                        echo "  </SELECT>
                                </br>
                                <label for='Краткое описание книги'>Краткое описание книги: </label>
                                <input type='text' name='Краткое описание книги'>
                                </br>
                                <label for='Полное описание книги'>Полное описание книги: </label>
                                <input type='text' name='Полное описание книги'>
                                </br>                               
                                <label for='Наличие (кол-во)'>Наличие (кол-во): </label>
                                <input type='text' name='Наличие (кол-во)'>
                                </br>
                                <label for='Доступно для заказа'>Доступно для заказа: </label>
                                <input type='text' name='Доступно для заказа'>
                                </br>
                                <label for='Активность'>Активность: </label>
                                <input type='checkbox' name='Активность'>
                                </br>
                                <input type='submit' name='addTovar'>
                            </form>
                        ";
                        break;
                    }
                    case 'opt6':   // Редактировать существующий товар.
                    {
                        $query = "SELECT goods.Id, goods.`Название книги`, goods.`Краткое описание книги`, goods.`Полное описание книги`, GROUP_CONCAT(category.`Жанр`) AS 'Жанр', goods.`Активность`, goods.`Наличие (кол-во)`, goods.`Доступно для заказа`  FROM goods LEFT JOIN categorygoods ON goods.Id=categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id GROUP BY goods.id";
                        echo "<form action='admin.php' method='POST' align='center'>";
                        displayAllTableForSQL(1, $query, 'goods');
                        echo "<input type='submit' name='updGoods' value='Выбрать'>
                        </form>
                        ";

                        break;
                    }
                }
            }
            elseif(isset($_GET['point']))   // Если при переходе по страницам.
            {
                switch ($_GET['point'])     // Проверяем где произошел переход по страницам.
                {
                    case 'categ':
                    {
                        $str = $_GET['str'];
                        display_category($str);
                        break;
                    }
                    case 'goods':
                    {
                        $str = $_GET['str'];
                        $query = 'SELECT id, `Название книги`, `Наличие (кол-во)`, `Доступно для заказа` FROM goods WHERE Активность>0';
                        display_goods($str, $query, 'goods');
                        break;
                    }
                    case 'ShowAllTableRadio':
                    {
                        $str = $_GET['str'];
                        switch ($_GET['nameTable'])
                        {
                            case 'category':
                            {
                                $query = "SELECT * FROM category";
                                echo "<form action='admin.php' method='POST' align='center'>";
                                displayAllTableForSQL($str, $query, 'category');
                                echo "<input type='submit' name='updCategory' value='Выбрать'>
                                      </form>";
                                break;
                            }
                            case 'goods':
                            {
                                $query = $query = "SELECT goods.Id, goods.`Название книги`, goods.`Краткое описание книги`, goods.`Полное описание книги`, GROUP_CONCAT(category.`Жанр`) AS 'Жанр', goods.`Активность`, goods.`Наличие (кол-во)`, goods.`Доступно для заказа`  FROM goods LEFT JOIN categorygoods ON goods.Id=categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id GROUP BY goods.id";
                                echo "<form action='admin.php' method='POST' align='center'>";
                                displayAllTableForSQL($str, $query, 'goods');
                                echo "<input type='submit' name='updGoods' value='Выбрать'>
                                      </form>";
                                break;
                            }
                        }
                        break;
                    }
                }
            }

            // ------- ФОРМЫ -------
            if (isset($_POST['addCategory']))   // Добавление категории.
            {
                // ------- Получаем данные с формы. -------
                $genre = $_POST['Жанр'];
                $kratkoeOpisanie = $_POST['Краткое_описание_жанра'];
                $polnoeOpisanie = $_POST['Полное_описание_жанра'];
                $activ = $_POST['Активность'];
                if ($activ)
                    $activ=1;
                else
                    $activ=0;
                // ---- Конец получения данных с формы. ----
                $query = "INSERT INTO category (id, Жанр, `Краткое описание жанра`, `Полное описание жанра`, Активность) VALUE (NULL, '$genre', '$kratkoeOpisanie', '$polnoeOpisanie', $activ)";

                $result_query = mysqli_query($link, $query);
                if ($result_query)
                {
                    echo "Данные успешно добавлены";
                }
            }
            elseif (isset($_POST['updCategory']))   // Изменение категории.
            {
                $updID = $_POST['check'];  // id категории, которую следует редактировать.
                // --- Запрашиваем запись, соответствующую выбранной категории. ---
                $query = "SELECT * FROM category WHERE id='$updID'";
                $result_query = mysqli_query($link, $query);
                $category = mysqli_fetch_row($result_query);
                // ----------------------------------------------------------------

                // --- Заголовки полей. ---
                foreach (mysqli_fetch_fields($result_query) as $obj)
                {
                    $propertyCategory[] = $obj->name;
                }
                // --------------------------
                $category = array_combine($propertyCategory, $category);   // Ассоциативный массив Характеристика(столбец)=>Значение(ячейка)

                echo "<h3>Вы выбрали следующую категорию для редактирования: </h3>";
                foreach($category as $key=>$val)
                {
                    echo "<p><b>$key:</b> $val</p>";
                }

                echo "<h3>Введите значения полей, которые следует изменить: </h3>";
                echo "<form action='admin.php' method='POST'>";
                foreach($category as $key=>$val)
                {
                    echo "<p> 
                            <label for=$key><b>$key</b></label>
                            <input type='text' name='$key' value='$val'>
                            </br>
                          </p>";
                }
                echo "<input type='reset'>";
                echo "<input type='submit' name='updCategoryFIN' value='Изменить'>";

                echo "</form>";
            }
            elseif (isset($_POST['updCategoryFIN']))    // Обновление категории. Обработка данных.
            {
                // ------- Получаем данные с формы. -------
                $id = $_POST['id'];
                $genre = $_POST['Жанр'];
                $kratkoeOpisanie = $_POST['Краткое_описание_жанра'];
                $polnoeOpisanie = $_POST['Полное_описание_жанра'];
                $activ = $_POST['Активность'];
                // ---- Конец получения данных с формы. ----

                $query="UPDATE category SET `Жанр` = '$genre', `Краткое описание жанра`='$kratkoeOpisanie', `Полное описание жанра`='$polnoeOpisanie', `Активность`=$activ  WHERE id=$id";
                $result_query = mysqli_query($link, $query);
                if ($result_query)
                {
                    echo "Данные успешно обновлены";
                }
                else
                {
                    echo "Данные не обновлены";
                }
            }
            elseif(isset($_POST['addTovar']))   // Добавление товара. Ввод данных.
            {
                // ------- Получаем данные с формы. -------
                $name = $_POST['Название_книги'];
                $genre = $_POST['genre'];
                $kratkoeOpisanie = $_POST['Краткое_описание_книги'];
                $polnoeOpisanie = $_POST['Полное_описание_книги'];
                $nalichie = $_POST['Наличие_(кол-во)'];
                $zakaz = $_POST['Доступно_для_заказа'];
                $activ = $_POST['Активность'];
                if ($activ)
                    $activ=1;
                else
                    $activ=0;
                // ---- Конец получения данных с формы. ----

                // --- Создаём и выполняем запрос для добавления информации в таблицу товаров. ---
                $query1 = "INSERT INTO goods (id, `Название книги`, `Краткое описание книги`, `Полное описание книги`, Активность, `Наличие (кол-во)`, `Доступно для заказа`) VALUE (NULL, '$name', '$kratkoeOpisanie', '$polnoeOpisanie', $activ, '$nalichie', '$zakaz')";
                $result_query1 = mysqli_query($link, $query1);
                // ---------- Конец выполнения запроса для таблицы товаров (goods). --------------

                // Если товар добавлен..
                if ($result_query1)
                {
                    // --- Запрашиваем id добавленного товара. ---
                    $query2= "SELECT id FROM goods ORDER BY id DESC LIMIT 1";
                    $result_query2 = mysqli_query($link, $query2);
                    $row = mysqli_fetch_row($result_query2);
                    $idTovar = $row[0];
                    // --- id товара получен. ---

                    // --- Добавляем связь товара и категории в дочернюю таблицу categorygoods. ---
                    $query3 = "INSERT INTO categorygoods (category_id, goods_id) VALUES ($genre,$idTovar)";
                    $result_query3 = mysqli_query($link, $query3);
                    // --- Конец добавления. ---
                }
                if ($result_query1&&$result_query2&&$result_query3)
                {
                    echo "Данные успешно добавлены";
                }
            }
            elseif(isset($_POST['updGoods']))   // Обновление товара. Ввод данных.
            {
                $updID = $_POST['check'];  // id товара, который следует редактировать.
                // --- Получаем все жанры из таблицы category. ---
                $query = "SELECT id, `Жанр` FROM category";
                $result_query = mysqli_query($link, $query);
                $rows_count = mysqli_num_rows($result_query);
                for ($i=0; $i<$rows_count; $i++)
                {
                    $row = mysqli_fetch_row($result_query);
                    $allGenres[$row[1]]=$row[0];
                }
                // -----------------------------------------------

                // --- Запрашиваем запись, соответствующую выбранному товару. ---
                $query = "SELECT goods.Id, goods.`Название книги`, goods.`Краткое описание книги`, goods.`Полное описание книги`, GROUP_CONCAT(category.`Жанр`) AS 'Жанр', goods.`Активность`, goods.`Наличие (кол-во)`, goods.`Доступно для заказа`  FROM goods LEFT JOIN categorygoods ON goods.Id=categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE goods.id=$updID";
                $result_query = mysqli_query($link, $query);
                $tovar = mysqli_fetch_row($result_query);
                // --------------------------------------------------------------

                // --- Получаем массив полей таблицы. Характеристики товара. ---
                foreach (mysqli_fetch_fields($result_query) as $obj)
                {
                    $propertyCategory[] = $obj->name;
                }
                // --------------------------------------------------------------

                $tovar = array_combine($propertyCategory, $tovar);   // Ассоциативный массив Характеристика(столбец)=>Значение(ячейка)

                // --- Выводим на страницу всю информацию о выбранном товаре. ---
                echo "<h3>Вы выбрали следующий товар для редактирования: </h3>";
                foreach($tovar as $key=>$val)
                {
                    echo "<p><b>$key:</b> $val</p>";
                }
                // ---------------------------------------------------------------

                // --- Получаем массив категорий(жанров), которые относятся к выбранному товару. ---
                $genres = $tovar['Жанр'];
                $genres = explode(',', $genres);
                // ---------------------------------------------------------------------------------

                echo "<h3>Введите значения полей, которые следует изменить: </h3>";
                echo "<form action='admin.php' method='POST'>";
                echo "<input type='text' name='Id' value=$updID hidden>";
                unset($tovar['Id']);
                foreach($tovar as $key=>$val)
                {
                    if ($key!='Жанр')
                        echo "<p> 
                                <label for='$key'><b>$key: </b></label>
                                <input type='text' name='$key' value='$val'>
                                </br>
                              </p>";
                    else
                    {
                        echo "<p> 
                                <label for=$key><b>$key: </b></label>";

                        $i = 0;
                        foreach ($genres as $genre)
                        {
                            $selectedIdGenre = $allGenres[$genre];   // Ид выбранной категории.
                            $i+=1;
                            $selectName = 'SelectGenre'.$i;
                            echo "<SELECT name=$selectName>";
                            foreach ($allGenres as $key=>$val)  // key = имя жанра, val = ид жанра.
                            {
                                $selected='';   // Значение атрибудта selected.
                                if ($genre==$key)
                                    $selected = 'selected';

                                $valueOption = $selectedIdGenre.'.'.$val;
                                echo    "<OPTION $selected value='$valueOption'>$key</OPTION>";
                            }

                            echo "</SELECT>";
                        }

                        echo "   
                                </br>
                              </p>";
                    }
                }
                echo "<input type='reset'>";
                echo "<input type='submit' name='updGoodsFIN' value='Изменить'>";

                echo "</form>";
            }
            elseif(isset($_POST['updGoodsFIN']))   // Обновление товара. Обработка данных.
            {
                // ------- Получаем данные с формы. -------
                $id = $_POST['Id'];
                $name = $_POST['Название_книги'];
                $kratkoeOpisanie = $_POST['Краткое_описание_книги'];
                $polnoeOpisanie = $_POST['Полное_описание_книги'];
                $activ = $_POST['Активность'];
                $nalicihie = $_POST['Наличие_(кол-во)'];
                $zakaz = $_POST['Доступно_для_заказа'];

                // --- У товара могут быть несколько категорий. Выбор каждой реализован списком <SELECT>.
                // Имена списков имеют вид: SelectGenrei, где i-номер очередного списка.
                // Формируем поочередно от единицы имена (SelectGenre1, SelectGenre2 и т.д.),
                // значения каждого имеющегося в POST добавляем в массив. Значения всех ид категорий имеют вид
                // 'старый ид'.'новый ид', поэтому разделяем строку по точке на массив из двух элементов. ---
                $i=0;
                do
                {
                    $i++;
                    $keyGenre = 'SelectGenre'.$i;
                    if (isset($_POST[$keyGenre]))
                    {
                        $valueids = $_POST[$keyGenre];
                        $arrayIdGenres[$keyGenre]=explode('.', $valueids);
                    }
                    else
                        break;
                }
                while(true);
                // -----Селекты получены. --------------------------------------------------
                // ---- Конец получения данных с формы. ----

                $query1 = "UPDATE goods SET  id=$id, `Название книги`='$name', `Краткое описание книги`='$kratkoeOpisanie', `Полное описание книги`='$polnoeOpisanie', `Активность`=$activ, `Наличие (кол-во)`=$nalicihie, `Доступно для заказа`=$zakaz WHERE id=$id";
                $result_query1 = mysqli_query($link, $query1);

                if ($result_query1)
                {
                    foreach ($arrayIdGenres as $idGenres)
                    {
                        $query2 = "UPDATE categorygoods SET category_id=$idGenres[1], goods_id=$id WHERE category_id=$idGenres[0] AND goods_id=$id";
                        $result_query2 = mysqli_query($link, $query2);

                    }

                }

                if ($result_query1&&$result_query2)
                {
                    echo "Данные успешно обновлены";
                }
                else
                {
                    echo "Данные не обновлены";
                }
            }

            mysqli_close($link);
        ?>
    </body>
</html>