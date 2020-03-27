<?php
    class Controller_GoodsAdd extends Controller
    {
        function action_default()
        {
            $data_for_view['title'] = 'Админ. Добавка товара';
            $data_for_view['msgResult']='';
            $this->model=new Model_GoodsAdd();
            $ids_and_genres_from_category = $this->model->get_data();   // Запрашиваем иды и жанры из таблицы category. Для списка на вьюшке.
            $data_for_view['ids_and_genres_from_category']=$ids_and_genres_from_category;

            if ($_POST)
            {


                // ~~~~~~~~~~~~~ Получаем данные из формы. ~~~~~~~~~~~~~
                // --- Категорий(жанров) может быть неопределенное количество, причем они могут повторятся.
                //     По соглашению имя селектов selectGenre_i, где i [0,Z].
                //     Собираем все элементы в массив genres и из супер массива POST удаляем.
                //     Чтобы далее не мешались при сохранении элементов из запроса. ---
                $i=0;
                while ($_POST["selectGenre_$i"])
                {
                    $genres[] = $_POST["selectGenre_$i"];
                    unset($_POST["selectGenre_$i"]);
                    $i++;
                }
                // ---------------------------------------------------------------------
                $genres = array_unique($genres);   // Удаляем повторяющиеся категории.
                $data_from_form['genres'] = $genres;   // Добавляем в массив для модели сформированный массив из полученных из формы категорий(жанров).

                // --- Получаем остальные данные из формы и добавляем в массив для модели. ---
                foreach ($_POST as $field_name=>$field_value)
                {
                    $data_from_form[$field_name]=$field_value;
                }
                //-------- Конец получения данных. -------------------------------------------------------------------
                print_r($data_from_form);

                $this->model=new Model_GoodsAdd();
                $result = $this->model->set_data($data_from_form);

                if ($result)
                    $data_for_view['msgResult']='<<< Данные успешно добавлены!>>>';
                else
                    $data_for_view['msgResult']='<<< Данные не добавлены!>>>';

            }
            $this->view->generate('goodsAdd_view.php', $this->template, $data_for_view);
        }
    }
?>