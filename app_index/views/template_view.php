<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">

    <title><?php echo $title ?></title>

    <link rel="stylesheet" type="text/css" href="/catalog-site2.ru/css/style.css">
</head>
<body>
    <!-- Контейнер для основных форм, разделяющих логику. -->
    <div align="center">
        <!-- Кнопка для вывода списка категорий. -->
        <form action="/catalog-site2.ru/index/category/list" method="post" style="display: inline">
            <input type="submit" value="Список категорий">
        </form>
        <!-- ------------------------------------ -->

        <!-- Кнопка для вывода списка товаров. -->
        <form action="/catalog-site2.ru/index/goods/list" method="post" style="display: inline">
            <input type="submit" value="Список товаров">
        </form>
        <!-- ---------------------------------- -->

        <!-- Форма для вывода информации о товаре по id. -->
        <form action="/catalog-site2.ru/index/goodsID/goodsID" method="GET" style="display: inline">
            <label for="goods_id"> Введите id товара: </label>
            <input type="text" name="goods_id" required>
            <input type="submit" value="Получить описание товара">
        </form>
        <!-- -------------------------------------------- -->
    </div>
    </br>
    <!-- ------------ Конец контейнера --------------------------->

    <?php
      eval($content_view);
    ?>

</body>
</html>