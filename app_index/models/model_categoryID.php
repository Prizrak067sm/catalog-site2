<?php
    class Model_CategoryID extends Model
    {
        private $id;
        private $page;
        const ELEMENT_COUNT = 3;   // Количество записей выборки из таблицы БД для вывода.

        function __construct($_id, $_page=1)
        {
            parent::__construct();
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой.

            $this->id=$_id;
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
            $sql = "SELECT goods.id FROM goods LEFT JOIN categorygoods on goods.id = categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE category.id=?";
            $stmt = $this->dataBase->prepare($sql);
            $stmt->execute(array($this->id));
            $row_count = $stmt->rowCount();   // Количество строк выборки.
            return ceil($row_count/self::ELEMENT_COUNT);  // Количество страниц.
        }
        // --- Конец. get_page_count(). ---

        // Формирует массив наименования полей.
        function get_fields_name_array_table()
        {
            $sql = "SELECT goods.id AS id, goods.name_book AS Название, category.genre AS Жанр, goods.availability AS `Наличие (кол-во)`, goods.availability_order AS `Доступно для заказа` FROM goods LEFT JOIN categorygoods on goods.id = categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE category.id=?";
            $stmt = $this->dataBase->prepare($sql);
            $stmt->execute(array($this->id));
            $field_count = $stmt->columnCount();   // Количество полей.
            for ($field_index = 0; $field_index<$field_count; $field_index++)
            {
                $field_meta = $stmt->getColumnMeta($field_index);   // Характеристика поля.
                $field_name = $field_meta['name'];   // Имя поля.
                $fields_name_array[] = $field_name;
            }

            return $fields_name_array;
        }
        // --- Конец. get_fields_name_array_table(). --

        // Возвращает жанр по ид.
        function get_genre_for_id()
        {
            $sql = "SELECT category.genre FROM category WHERE id=?";
            $stmt = $this->dataBase->prepare($sql);
            $stmt->execute(array($this->id));
            $genre_for_id = $stmt->fetch();
            return $genre_for_id[0];
        }
        // --- Конец. get_genre_for_id(). ---

        // --- Получение и формиравание данных из бд для возврата. ---
        function get_data()
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для LIMIT надо числа).

            $offset = $this->page*self::ELEMENT_COUNT-self::ELEMENT_COUNT;   // Смещение для первой строки на странице выборки.

            $sql = "SELECT goods.id, goods.name_book, category.genre, goods.availability, goods.availability_order FROM goods LEFT JOIN categorygoods on goods.id = categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE category.id=? LIMIT ?,?";

            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($this->id, $offset, self::ELEMENT_COUNT));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        // --- Конец. get_data(). ---
    }
?>