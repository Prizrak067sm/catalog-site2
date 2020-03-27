<?php
    class Controller_Main extends Controller
    {
        function __construct()
        {
            parent::__construct();

        }

        function action_default()
        {
            $data['title'] = 'Привет, админ!';
            $this->view->generate(null, "template_view.php", $data);
        }
    }
?>