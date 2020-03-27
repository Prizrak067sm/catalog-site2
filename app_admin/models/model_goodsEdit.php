<?php
    class Model_GoodsEdit extends Model
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
            $sql = "SELECT id FROM goods";
            $stmt = $this->dataBase->query($sql);
            $row_count = $stmt->rowCount();
            return ceil($row_count/self::ELEMENT_COUNT);  // Количество страниц.
        }
        // --- Конец. get_page_count(). ---

        // Формирует массив наименования полей.
        function get_fields_name_array_table()
        {
            $sql = "SELECT goods.id AS id, goods.name_book AS `Название книги`, GROUP_CONCAT(category.genre) AS 'Жанр', goods.brief_description AS `Краткое описание книги`, goods.full_description AS `Полное описание книги`, goods.availability AS `Наличие (кол-во)`, goods.availability_order AS `Доступно для заказа`, goods.activ AS `Активность` FROM goods LEFT JOIN categorygoods ON goods.Id=categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id";
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
            $sql = "SELECT goods.id AS id, goods.name_book AS `Название книги`,  GROUP_CONCAT(category.genre) AS `Жанр`, goods.brief_description AS `Краткое описание книги`, goods.full_description AS `Полное описание книги`, goods.availability AS `Наличие (кол-во)`, goods.availability_order AS `Доступно для заказа`, goods.activ AS `Активность` FROM goods LEFT JOIN categorygoods ON goods.Id=categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id GROUP BY goods.id LIMIT ?,?";

            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($offset,self::ELEMENT_COUNT));
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $data;
        }
        // --- Конец. get_data(). ---

        function get_data_id($id)
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для id надо числа).
            $sql = 'SELECT goods.id AS id, goods.name_book AS name_book,  GROUP_CONCAT(category.genre) AS genre, goods.brief_description AS brief_description, goods.full_description AS full_description, goods.availability AS availability, goods.availability_order AS availability_order, goods.activ AS activ FROM goods LEFT JOIN categorygoods ON goods.Id=categorygoods.goods_id LEFT JOIN category ON category.id=categorygoods.category_id WHERE goods.id=?';

            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($id));
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        }

        function get_data_category()
        {
            $sql = 'SELECT id, genre FROM category';
            $stmt=$this->dataBase->query($sql);
            $data = $stmt->fetchALL(PDO::FETCH_ASSOC);
            return $data;
        }

        function update_data($data)
        {
            // --- Получаем из полученного параметра с данными из формы массив с ИДами
            //    категорий и удаляем, так как массив нужен для подготовленного запроса
            //    таблицы goods, а для нее массив с категориями лишний. ---
            $genres_id = $data['genres'];
            unset($data['genres']);
            // -------------------------------------------------------------

            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для id надо числа).

            $result = false;
            try{
                $this->dataBase->beginTransaction();
                $sql="UPDATE goods SET name_book = :name_book, brief_description=:brief_description, full_description=:full_description, availability= :availability, availability_order = :availability_order, activ=:activ  WHERE id=:id";
                $stmt=$this->dataBase->prepare($sql);
                $stmt->execute($data);

                $sql="DELETE FROM categorygoods WHERE goods_id=?";
                $stmt=$this->dataBase->prepare($sql);
                $stmt->execute(array($data['id']));

                $sql = "INSERT INTO categorygoods (goods_id, category_id) VALUES (?,?)";
                $stmt=$this->dataBase->prepare($sql);
                foreach ($genres_id AS $id_genre)
                {
                    $stmt->execute(array($data['id'], $id_genre));
                }

                $result = $this->dataBase->commit();
            }
            catch (Exception $e)
            {
                $this->dataBase->rollBack();
            }

            return $result;
        }
    }
?>