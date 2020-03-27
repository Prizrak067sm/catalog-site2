<?php
    class Controller_GoodsID extends Controller
    {
        private $id = '_';
        function __construct()
        {
            parent::__construct();

            if ($_GET['goods_id'])
            {
                $this->id = $_GET['goods_id'];
                $this->model=new Model_goodsID($this->id);
            }
        }

        function action_goodsID()
        {
            $data_for_view['title'] = "Информация о товаре № $this->id";

            $data_model=$this->model->get_data();
            if ($data_model)
                $this->view->generate('goodsID_view.php', $this->template, $data_for_view, $data_model);
            else
                Route::error_goods404();

        }
    }
?>