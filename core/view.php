<?php
   # define("catalog_views", "app_index/views/");   // Путь к каталогу с вьюшками.

    class View
    {
        private $catalog_views;
        function __construct($_dir_app)
        {
            $this->catalog_views=$_dir_app."/views/";
        }

        function generate($content_view, $template_view=null, $data_for_view=null, $data_model=null)
        {
            static $testvar = 5;
            if ($data_for_view)   // Если с контроллера переданы данные, распаковываем их из массива в переменные.
                extract($data_for_view);

            // --- В шаблоне $template_view будет включаться страница с контентом - $content_view. Если контроллер передает имя
            //     страницы, то добавляем префикс с каталогом вьюшек и инструкцию включения - include. В шаблоне $template_view
            //     будет выполнена строка переменной $content_view. Таким образом, если нужен только шаблон без контента,
            //     будет передано значение null - файла не существует. Переменной $content_view присваиваем null. ---
            if ($content_view && file_exists($this->catalog_views.$content_view))
                $content_view = "include " . "'" . $this->catalog_views . $content_view . "';";
            else
                $content_view = null;
            // ------------------------------------------------------------------------------------------------------

            if ($template_view)
                include $this->catalog_views.$template_view;   // Включаем шаблон.
            else
                eval($content_view);
        }

        // --- Метод выводит ссылки на страницы, их количество задано
        //     параметром $count_page, и текущая страница - параметр $page. ---
        function getPagination($page, $count_page)
        {
            echo "
              <div align='center'> 
                  Вы на странице № $page <br>
                  Перейти на страницу: ";
                // Вывод ссылок страниц. В параметрах - страница.
                for ($i=1; $i<=$count_page; $i++)
                {
                    echo "<a href='?page=$i'>$i   </a>";
                }
                // ------- Конец цикла. -------
            echo "</div>";
        }
        // ------ Конец getPagination. -----------------------------------------
    }
?>