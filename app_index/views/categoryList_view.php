<?php
    foreach ($data_model as $row)
    {
        $display_row = '';
        foreach ($row as $cells)
        {
            $display_row .= $cells.': ';
        }
         $display_row = rtrim($display_row,': ');
         echo $display_row.'<hr>';
    }

    $this->getPagination($page, $count_page);
?>
