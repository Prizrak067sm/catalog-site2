<?php
    class Model_GoodsID extends Model
    {
        private $id;
        function __construct($_id)
        {
            parent::__construct();
            $this->id=$_id;
        }

        function get_data()
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой (для id надо число).

            $sql = "SELECT goods.Id AS goods_id, GROUP_CONCAT(category.id) AS id_genres, goods.name_book AS name_book, 
                    group_concat(category.genre) AS genres, goods.brief_description AS brief_description, 
                    goods.full_description AS full_description, goods.availability AS availability, goods.availability_order AS availability_order
                    FROM goods LEFT JOIN categorygoods on goods.Id = categorygoods.goods_id 
                    LEFT JOIN category ON category.id=categorygoods.category_id WHERE goods.Id=?";
            $stmt=$this->dataBase->prepare($sql);
            $stmt->execute(array($this->id));
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // --- Формируем массив для возврата данных. ---
            if ($row['goods_id'])
            {
                $genres = explode(",", $row['genres']);    // Категории(жанры) в ячейке перечислены через запятую. Создаем массив, элементы которого - категории(жанры).
                $id_genres = explode(",", $row['id_genres']); // ИД категорий(жанров) в ячейке перечислены через запятую. Создаем массив, элементы которого - ИДы категорий(жанров).
                $genres_and_id = array_combine($genres, $id_genres); // Из массивов жанров и ИДов создаем ассоциативный массив жанр=>ид
                $data['id'] = $row['goods_id'];
                $data['name'] = $row['name_book'];
                $data['genres_and_id'] = $genres_and_id;
                $data['brief_description'] = $row['brief_description'];
                $data['full_description'] = $row['full_description'];
                $data['availability'] = $row['availability'];
                $data['availability_order'] = $row['availability_order'];
                return $data;
            }
            else
                return null;
            // ----------------------------------------

        }
    }
?>