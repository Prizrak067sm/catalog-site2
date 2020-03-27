<?php
class Controller_CategoryList extends Controller
{
    function __construct()
    {
        parent::__construct();
        $this->model=new Model_CategoryList();
    }

    function action_default()
    {
        $data_for_view['title'] = 'Админ. Список категорий';
        $data_for_view['page'] = 1;
        $data_for_view['count_page'] = $this->model->get_page_count();

        if ($_GET['page'])
        {
            $this->model->set_page($_GET['page']);
            $data_for_view['page'] = $_GET['page'];
        }

        $data_model = $this->model->get_data();

        $this->view->generate('categoryList_view.php', $this->template, $data_for_view, $data_model);
    }
}