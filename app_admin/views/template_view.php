<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">

    <title><?php echo $title ?></title>

    <link rel="stylesheet" type="text/css" href="/catalog-site2.ru/css/style.css">
    <script src="/catalog-site2.ru/js/handlers.js"></script>
</head>
<body class="bodyAdminka">
    <!-- Контейнер для выбора страниц, разделяющих логику. -->
    <div align="center">
        <!-- Список для выбора основных действий. -->
        <div align="center">
            <form action="/catalog-site2.ru/admin/" method="get" >
                <select name="control">
                    <option value="categoryList"> Получить список доступных в таблице category категорий </option>
                    <option value="goodsList"> Получить список доступных в таблице goods товаров  </option>
                    <option value="categoryAdd"> Добавить новую категорию </option>
                    <option value="categoryEdit/choice"> Редактировать существующую категорию </option>
                    <option value="goodsAdd"> Добавить новый товар </option>
                    <option value="goodsEdit/choice"> Редактировать существующий товар </option>
                </select>
                <input type="submit" value="Далее">
            </form>
        </div>
        <!-- ---------------------------------------- -->
    </div>
    </br>
    <!-- ------------ Конец контейнера --------------------------->

    <?php
        eval($content_view);
    ?>
</body>
</html>