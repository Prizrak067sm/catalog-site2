<?php
    class Controller_CategoryID extends Controller
    {
        private $id = '_';
        function __construct()
        {
            parent::__construct();
            session_start();

            if ($_GET['category_id'])
            {
                $this->id = $_GET['category_id'];
                $_SESSION['category_id'] = $_GET['category_id'];    // Сохраняем ид категории в сессию. Надо для пагинации. Так как при переходе по страницам параметр с ид категории не передается.
            }
            else
                $this->id = $_SESSION['category_id'];

                $this->model=new Model_CategoryID($this->id);
        }

        function action_CategoryID()
        {
            $enterGenre = $this->model->get_genre_for_id();
            $data_for_view['title'] = "Товары категории: ".$enterGenre;
            $data_for_view['genre'] =  $enterGenre;
            $data_for_view['page'] = 1;
            $data_for_view['category_id'] = $this->id;
            $data_for_view['count_page'] = $this->model->get_page_count();
            $data_for_view['fields_name'] = $this->model->get_fields_name_array_table();

            if ($_GET['page'])
            {
                $this->model->set_page($_GET['page']);
                $data_for_view['page'] = $_GET['page'];
            }

            $data_model=$this->model->get_data();

            $this->view->generate('categoryID_view.php', $this->template, $data_for_view, $data_model);
        }
    }
?>