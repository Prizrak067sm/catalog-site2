<?php
    class Model_goods extends Model
    {
        private $page;
        const ELEMENT_COUNT = 7;   // Количество записей выборки из таблицы БД для вывода.

        function __construct($_page=1)
        {
            parent::__construct();
            $this->page=$_page;

        }

        // Устанавливаем номер страницы. От нее зависит какие строки из бд получать.
        function set_page($page)
        {
            $this->page=$page;
        }
        // ---Конец. set_page($page). ---

        // Возвращает количество страниц. Необходимо для вьюшки. Число зависит от количества записей в таблице.
        function get_page_count()
        {
            $sql = 'SELECT id FROM goods WHERE activ>0';   // Строка запроса на выборку записей товаров со значением поля активность больше нуля.
            $stmt = $this->dataBase->query($sql);
            $row_count = $stmt->rowCount();   // Количество строк выборки.
            return ceil($row_count/self::ELEMENT_COUNT);  // Количество страниц.
        }
        // --- Конец. get_page_count(). ---

        // Формирует массив наименования полей.
        function get_fields_name_array_table()
        {
            $sql = 'SELECT id, name_book AS `Название книги`, availability AS `Наличие (кол-во)`, availability_order AS `Доступно для заказа` FROM goods WHERE activ>0';   // Строка запроса на выборку записей товаров со значением поля активность больше нуля.
            $stmt = $this->dataBase->query($sql);
            $field_count = $stmt->columnCount();   // Количество полей.
            for ($field_index = 0; $field_index<$field_count; $field_index++)
            {
                $field_meta = $stmt->getColumnMeta($field_index);   // Характеристика поля.
                $field_name = $field_meta['name'];   // Имя поля.
                $fields_name_array[] = $field_name;
            }

            return $fields_name_array;

        }
        // --- Конец. get_fields_name_array_table(). ---

        // --- Получение и формиравание данных из бд для возврата. ---
        function get_data()
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для LIMIT надо числа).

            $offset = $this->page*self::ELEMENT_COUNT-self::ELEMENT_COUNT;   // Смещение для первой строки на странице выборки.

            $sql = 'SELECT id, name_book AS `Название книги`, availability AS `Наличие (кол-во)`, availability_order AS `Доступно для заказа` FROM goods WHERE activ>0 LIMIT ?,?';

            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($offset,self::ELEMENT_COUNT));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        // --- Конец. get_data(). ---
    }
?>