<?php
    echo $result_update;
    echo "<form action='/catalog-site2.ru/admin/categoryEdit/set' method='post' align='center'>";
        // --- Вывод таблицы с данными, полученными из контроллера. ---
        echo "<table align='center'>";
                // --- Названия полей. ---
                echo "<tr>";
                    echo "<th>Выбор</th>";
                    foreach ($fields as $field)
                    {
                        echo "<th>$field</th>";
                    }
                echo "</tr>";
                // ------------------------

            // --- Тело таблицы. ---
            foreach ($data_model as $row)
            {
                echo "<tr>";
                echo "<td> <input type='radio' name='radio_id' value=".$row['id']." required> </td>";
                foreach ($row as $cells)
                {
                    echo "<td>$cells</td>";
                }
                echo "</tr>";
            }
            // -----------------------
        echo "</table>";
        // --- Конец таблицы. ---------------------------------------------
        echo "<input type='submit' value='Выбрать'>";
    echo "</form>";
    $this->getPagination($page, $count_page);

?>