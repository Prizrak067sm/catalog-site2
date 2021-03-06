<?php
    class Route
    {
        static $URI;
        static $dir_app;
        static $file_entry_point;
        static function start()
        {
            // --- ИНИЦИАЛИЗАЦИЯ. ---
            $controller_name = "Main";   // Имя класса контроллера по умолчанию.
            $action_name = "default";      // Имя действия (экшена) по умолчанию.
            Route::$URI = $_SERVER['REQUEST_URI'];   // Получаем URI.
            // ----------------------

            // --- Если в запросе URI есть GET-запрос, то исключим его из URI,
            //     чтобы далее разобрать его на контроллер и метод контроллера.
            //     Расшифровка регулярки - любое количество любых символов от начала строки
            //     до символа ? или любая строка(если нет гет запроса и соответсна символа ?). ---
            preg_match("/(^.*(?=\?))|(^.*$)/", Route::$URI, $matches);
            Route::$URI = $matches[0];   // Присваиваем переменной найденный ури без гет-запроса.
            // ------------------------------------------------------------------------------------

            $routes = explode('/', Route::$URI);   // Массив. Элементы которого части URI, полученные разбиением по слэшу. Нужны для определения контроллера и экшена.

            Route::$file_entry_point = $routes[2];
            Route::$dir_app = 'app_'.Route::$file_entry_point;

            // Получаем имя контроллера из запроса.
            if (!empty($routes[3]))
            {
                $controller_name = $routes[3];   // Имя контроллера из запроса.
            }
            // ------------------------------------

            // Получаем имя действия (экшена) из запроса.
            if (!empty($routes[4]))
            {
                $action_name = $routes[4];   // Имя действия (экшена) из запроса.
            }
            // --------------------------------------

            // --- Создаём переменные с именами для контроллера, модели и экшена, добавляя
            //     соответствующие префиксы к полученным из запроса контроллеру и экшену. ---
            $model_name = 'Model_'.$controller_name;    // Имя класса потенциальной модели.
            $controller_name = 'Controller_'.$controller_name;  // Имя класса потенциального контроллера.
            $action_name = 'action_'.$action_name;   // Имя метода (экшена) контроллера.
            // ------------------------------------------------------------------------------

            // ~~~~~~~ Подключаем файлы. ~~~~~~~
            // --- Формируем имя и путь файла с классом модели. Которая относится к запросу. ---
            $model_file = strtolower($model_name).'.php';
            $model_path = Route::$dir_app.'/models/'.$model_file;
            // ---------------------------------------------------------------------------------

            // --- Формируем имя и путь файла с классом контроллера. Который относится к запросу. ---
            $controller_file = strtolower($controller_name).'.php';
            $controller_path = Route::$dir_app.'/controllers/'.$controller_file;
            // ---------------------------------------------------------------------------------------

            // --- Если файл модели, путь к которому сформировали выше, существует, то подключаем его. ---
            if (file_exists($model_path))
            {
                include $model_path;   // Подключаем файл с классом модели.
            }
            // -------------------------------------------------------------------------------------------

            // --- Если файл контроллера, путь к которому сформировали выше, существует, то подключаем его. ---
            if (file_exists($controller_path))
            {
                include $controller_path;   // Подключаем файл с классом контроллера.
            }
            else
            {
                Route::error_page404();   // Если контроллер из запроса не существует, вызываем функцию с реализацией 404 страницы.
            }
            // -------------------------------------------------------------------------------------------------
            // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

            // Файл с запрошенным классом контроллера существует и подключен - создаем его(класса контроллера) экземпляр.
            $controller = new $controller_name;
            // -------

            // Проверяем наличие метода(экшена) в контроллере и вызываем его.
            if (method_exists($controller, $action_name))
            {
                $controller->$action_name();
            }
            else // Если метода нет, то вызываем 404 страницу.
            {
                Route::error_page404();
            }
        }

        static function error_page404()
        {
            $host = explode('/', Route::$URI);
            $host = $host[1];
            header("Location: /$host/".Route::$file_entry_point."/page404");

            exit;
        }

        static function error_goods404()
        {
            $host = explode('/', Route::$URI);
            $host = $host[1];
            header("Location: /$host/".Route::$file_entry_point."/goods404");

            exit;
        }
    }
?>