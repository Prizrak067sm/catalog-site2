<?php
    echo "<h2 align='center'>Товары категории << $genre >></h2>";
    // --- Вывод таблицы с данными, полученными из контроллера. ---
    echo "<table align='center'>";
    // --- Названия полей. ---
    echo "<tr>";
    foreach ($fields_name as $field)
    {
        echo "<th>$field</th>";
    }
    echo   "</tr>";
    // ------------------------

    // --- Тело таблицы. ---
    foreach ($data_model as $row)
    {
        echo "<tr>";
        foreach ($row as $cells)
        {
            echo "<td>$cells</td>";
        }
        echo "</tr>";
    }
    // -----------------------
    echo "</table>";
    // --- Конец таблицы. ---------------------------------------------

    $this->getPagination($page, $count_page);
?>