<?php
    class Controller_CategoryAdd extends Controller
    {
        function action_default()
        {
            $data_for_view['title'] = 'Админ. Добавка категории';
            $data_for_view['msgResult']='';
            if ($_POST)
            {
                // Получаем данные из формы.
                foreach ($_POST as $field_name=>$field_value)
                {
                    $data_from_form[$field_name]=$field_value;
                }
                // -------------------------

                $this->model=new Model_CategoryAdd($data_from_form);
                $result = $this->model->set_data($data_from_form);

                if ($result)
                    $data_for_view['msgResult']='<<< Данные успешно добавлены!>>>';
                else
                    $data_for_view['msgResult']='<<< Данные не добавлены!>>>';
            }
            $this->view->generate('categoryAdd_view.php', $this->template, $data_for_view);
        }
    }
?>