<?php
    echo "<h2>Вы запросили информацию о товаре id № ".$data_model['id']."</h2>";

    echo "<p><b>Название: </b>".$data_model['name']."</p>";
    echo "<p><b>Жанр(ы):  </b>";
    // --- Формируем строку ссылок на категории(жанры). ---
    $genresRefer ='';
    foreach ($data_model['genres_and_id'] as $key=>$value)
    {
        $genresRefer.= "<a href='/catalog-site2.ru/categoryID/categoryID/?category_id=$value'>$key</a>, ";
    }
    $genresRefer = rtrim($genresRefer,', ');
    // -----------------------------------------------------
    echo "$genresRefer</p>";

    echo "<p><b>Краткое описание книги: </b>".$data_model['brief_description']."</p>";
    echo "<p><b>Полное описание книги: </b>".$data_model['full_description']."</p>";
    echo "<p><b>В наличии: </b>".$data_model['availability']."</p>";
    echo "<p><b>Возможно под заказ: </b>".$data_model['availability_order']."</p>";
?>