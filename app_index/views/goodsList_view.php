<?php
    // --- Вывод таблицы с данными, полученными из контроллера. ---
    echo "<table align='center'>";
    // --- Поля таблицы. ---
    echo "<tr>";
                foreach ($fields_name as $field_name)
                {
                    echo "<th>$field_name</th>";
                }
    echo   "</tr> ";

    // ----Конец название полей. --------------------

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
