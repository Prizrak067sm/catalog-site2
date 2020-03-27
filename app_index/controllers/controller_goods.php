<?php
    class Controller_Goods extends Controller
    {
        function __construct()
        {
            parent::__construct();
            $this->model=new Model_Goods();
        }

        function action_list()
        {
            $data_for_view['title'] = 'Список товаров';
            $data_for_view['page'] = 1;
            $data_for_view['count_page'] = $this->model->get_page_count();   // Запрос в модели количества страница.

            if ($_GET['page'])
            {
                $this->model->set_page($_GET['page']);
                $data_for_view['page'] = $_GET['page'];
            }

            $data_for_view['fields_name'] = $this->model->get_fields_name_array_table();   // Запрос массива с наименованиями полей.
            $data_model = $this->model->get_data();

            $this->view->generate('goodsList_view.php', $this->template, $data_for_view, $data_model);
        }
    }
?>