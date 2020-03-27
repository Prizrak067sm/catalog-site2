<?php
    class Controller_CategoryEdit extends Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->model = new Model_CategoryEdit();
            session_start();
        }

        // --- Метод для рендеринга начальной страницы. Запрос данных из таблицы, чтобы
        //     на вьюшке можно было выбрать запись для последующего редактирования. ---
        public function action_choice()
        {
            $data_for_view['title'] = 'Админ. Выбор жанра';
            $data_for_view['page'] = 1;
            $data_for_view['count_page'] = $this->model->get_page_count();

            // ---Если в сессии есть переменная result_update - весточка с метода action_update.
            //    В нем произошла работа с БД и в сессию записалось сообщение о результате,
            //   затем переход к начальной странице - сюда. ---
            $data_for_view['result_update'] = null;
            if (isset($_SESSION['msgUpdate']))
            {
                // Сохраняем сообщение из сессии в массив переменных для вьюшки и удаляем его из сессии.
                // Чтобы, когда переходим на начальную страницу до внесения изменений в БД, никаких сообщений не было в сессии.
                $data_for_view['result_update'] = $_SESSION['msgUpdate'];
                unset($_SESSION['msgUpdate']);
                // ------------------------------------------------------------------------------------------------------------
            }
            // -------------------------------------------------

            if ($_GET['page'])
            {
                $this->model->set_page($_GET['page']);
                $data_for_view['page'] = $_GET['page'];
            }
            $data_for_view['fields'] = $this->model->get_fields_name_array_table();
            $data_model = $this->model->get_data();

            $this->view->generate('categoryEditChoice_view.php', $this->template, $data_for_view, $data_model);
        }
        // --- Конец action_choice. ---

        // --- По полученному в пост с прошлой страницы id, получаем из БД всю запись.
        //     На вьюшке будет на ее основе вывод инфы и форма для изменения. ---
        public function action_set()
        {
            $data_for_view['title'] = 'Админ. Ввод данных';
            $data_model=null;
            if ($_POST['radio_id'])
            {
                $data_model = $this->model->get_data_id($_POST['radio_id']);
            }

            $this->view->generate('categoryEditSet_view.php', $this->template, $data_for_view, $data_model);
        }
        // --- Конец action_set. ---

        // --- На основе полученных данных с формы (значения полей записи
        //     на пред. странице) изменяется запись в бд. ---
        public function action_update()
        {
            if ($_POST)
            {
                // Получаем данные из формы.
                foreach ($_POST as $field_name=>$field_value)
                {
                    $data_from_form[$field_name]=$field_value;
                }
                if(!isset($_POST['activ']))
                    $data_from_form['activ']=0;
                else
                    $data_from_form['activ']=1;
                //-----------------------------

                // Отправляем данные в модель. Где реализовано изменение записи.
                $this->model=new Model_CategoryEdit();
                $result = $this->model->update_data($data_from_form);
                // -------------------------------------------------------------

                if ($result)
                    $msgResult='<<< Данные успешно обновлены!>>>';
                else
                    $msgResult='<<< Данные не обновлены!>>>';

                // Записываем сообщение о результате работы с бд в сессиию и переходим на начальную страницу.
                $_SESSION['msgUpdate'] = $msgResult;
                header("Location: /catalog-site2.ru/admin/categoryEdit/choice");
                // -----------------------------------------------------------------------------------------
            }
        }
        // --- Конец action_update. ---
    }
?>