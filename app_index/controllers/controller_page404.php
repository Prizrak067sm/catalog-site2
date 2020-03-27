<?php
    class Controller_page404 extends Controller
    {
        function action_default()
        {

            header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
            $this->view->generate('page404_view.php');
        }
    }
?>