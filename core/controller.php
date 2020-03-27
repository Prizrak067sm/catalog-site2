<?php
    class Controller
    {
        public $model;
        public $view;

        public $template = 'template_view.php';   // Имя фюшки шаблона.

        function __construct()
        {
            $this->view = new View(Route::$dir_app);  // Экземпляр класса из файла core/view.php.
        }

        // Стандартный экшен. Если он не будет переопределен в наследниках, то будет вывод 404 страницы.
        // Типа нет реализации метода. Может возникнуть, если в строке запроса только имя контроллера.
        // Эта ситуация должна быть обработана в методе action_default() наследника.
        function action_default()
        {
            Route::error_page404();
        }
        // ------------------------------------
    }
?>