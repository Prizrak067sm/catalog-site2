<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <title>Каталог товаров</title>
    </head>

    <body>
        <!-- Контейнер для основных форм, разделяющих логику. -->
        <div align="center">
            <!-- Кнопка для вывода списка категорий. -->
            <form action="index.php" method="post" style="display: inline">
                <input type="submit" name="subm" value="Список категорий">
            </form>
            <!-- ------------------------------------ -->

            <!-- Кнопка для вывода списка товаров. -->
            <form action="index.php" method="post" style="display: inline">
                <input type="submit" name="subm" value="Список товаров">
            </form>
            <!-- ---------------------------------- -->

            <!-- Форма для вывода информации о товаре по id. -->
            <form action="index.php" method="post" style="display: inline">
                <label for="goods_id"> Введите id товара: </label>
                <input type="text" name="goods_id" required>
                <input type="submit" name="subm" value="Получить описание товара">
            </form>
            <!-- -------------------------------------------- -->
        </div>
        </br>
        <!-- ------------ Конец контейнера --------------------------->

        <?php
            require_once 'myFunction.php';

            $link = mysqli_connect('localhost', 'root','1234567','catalog-site');
            if (isset($_POST['subm']))  // Отслеживаем, какая нажата кнопка. В соответствии с ней вызываем нужную функцию.
            {
                switch ($_POST['subm'])
                {
                    case 'Список категорий':
                    {
                        display_category(1);
                        break;
                    }
                    case 'Список товаров':
                    {
                        $query = 'SELECT id, `Название книги`, `Наличие (кол-во)`, `Доступно для заказа` FROM goods WHERE Активность>0';
                        display_goods(1, $query, goods);
                        break;
                    }
                    case 'Получить описание товара':
                    {
                        display_id_tovar($_POST['goods_id']);
                        break;
                    }
                }
            }
            elseif(isset($_GET['point']))   // Если в раздел попадаешь не по кнопке, а при выборе страницы, то в соответствии с параметром get определяется раздел и вызывается соответствующая функция.
            {
                switch ($_GET['point'])
                {
                    case 'categ':
                    {
                        $str = $_GET['str'];   // Получаем номер нажатой страницы.
                        display_category($str);
                        break;
                    }
                    case 'goods':
                    {
                        $str = $_GET['str'];   // Получаем номер нажатой страницы.
                        $query = 'SELECT id, `Название книги`, `Наличие (кол-во)`, `Доступно для заказа` FROM goods WHERE Активность>0';
                        display_goods($str, $query, 'goods');
                        break;
                    }
                    case 'genres':
                    {
                        if (isset($_GET['category_id']))
                        {
                            $str = 1;
                            $category_id = $_GET['category_id'];
                            if (isset($_GET['str']))
                                $str = $_GET['str'];   // Получаем номер нажатой страницы.

                            $query = "SELECT goods.id, goods.`Название книги`, goods.`Наличие (кол-во)`, goods.`Доступно для заказа`, category.`Жанр` FROM goods LEFT JOIN categorygoods on goods.id = categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE category.id=$category_id";
                            display_goods($str, $query, 'genres', $category_id);
                        }
                    }
                }
            }
            mysqli_close($link);
        ?>
    </body>
</html>












