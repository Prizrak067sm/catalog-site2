<?php
    class Model_CategoryEdit extends Model
    {
        private $page;
        const ELEMENT_COUNT = 3;   // Количество записей выборки из таблицы БД для вывода.

        function __construct($_page=1)
        {
            parent::__construct();
            $this->page=$_page;
        }

        // Устанавливаем номер страницы. От нее зависит какие строки из бд получать
        function set_page($page)
        {
            $this->page=$page;
        }
        // ---Конец. set_page($page). ---

        // Возвращает количество страниц. Необходимо для вьюшки. Число зависит от количества записей в таблице.
        function get_page_count()
        {
            $sql = "SELECT id FROM category";
            $stmt = $this->dataBase->query($sql);
            $row_count = $stmt->rowCount();
            return ceil($row_count/self::ELEMENT_COUNT);  // Количество страниц.
        }
        // --- Конец. get_page_count(). ---

        // Формирует массив наименования полей.
        function get_fields_name_array_table()
        {
            $sql = "SELECT id, genre AS Жанр, brief_description AS `Краткое описание`, full_description AS `Полное описание`, activ AS Активность FROM category";
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

            $sql = 'SELECT * FROM category LIMIT ?,?';

            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($offset,self::ELEMENT_COUNT));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        // --- Конец. get_data(). ---

        function get_data_id($id)
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для id надо числа).
            $sql = 'SELECT * FROM category WHERE id=?';
            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($id));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        function update_data($data)
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для id надо числа).
            $sql="UPDATE category SET genre = :genre, brief_description=:brief_description, full_description=:full_description, activ=:activ  WHERE id=:id";
            $stmt=$this->dataBase->prepare($sql);
            $result = $stmt->execute($data);
            return $result;
        }
    }
?>