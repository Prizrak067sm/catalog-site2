<?php
    class Controller_Goods404 extends Controller
    {
        function action_default()
        {
            $data_for_view['title'] = '404';
            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            $this->view->generate('goods404_view.php', $this->template, $data_for_view);
        }
    }
?>