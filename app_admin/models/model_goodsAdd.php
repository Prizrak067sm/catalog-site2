<?php
    class  Model_GoodsAdd extends Model
    {
        function __construct()
        {
            parent::__construct();
        }

        // --- Выборка ид и имя категории. Нужно для вьюшки. Для указания категории товара. ---
        function get_data()
        {
            $sql = "SELECT id, genre FROM category";
            $stmt = $this->dataBase->query($sql);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        // -------- Конец. get_data. ------------------------------------------------------------

        function set_data($data_for_insert)
        {
            // --- Получаем из полученного параметра с данными из формы массив с ИДами
            //    категорий и удаляем, так как массив нужен для подготовленного запроса
            //    таблицы goods, а для нее массив с категориями лишний. ---
            $genres_id = $data_for_insert['genres'];
            unset($data_for_insert['genres']);
            // -------------------------------------------------------------

            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой

            extract($data_for_insert);

            if ($data_for_insert['activ'])
                $activ = 1;
            else
                $activ = 0;

            $result = false;
            try
            {
                $this->dataBase->beginTransaction();

                // Добавляем запись в таблицу товаров - goods.
                $sql = "INSERT INTO goods (id, name_book, brief_description, full_description, availability, availability_order, activ) VALUE (NULL,  ?, ?, ?, ?, ?, ?)";
                $stmt = $this->dataBase->prepare($sql);
                $stmt->execute(array($name_book, $brief_description, $full_description, $availability, $availability_order, $activ)); // Переменные из $data_for_insert.
                // ----Конец добавления в goods.--------------

                // --- Запрашиваем id добавленного товара. ---
                $sql= "SELECT id FROM goods ORDER BY id DESC LIMIT 1";
                $stmt = $this->dataBase->query($sql);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $id_goods = $result['id'];
                // --- id товара получен. ---

                // --- Добавляем связь товара и категории в дочернюю таблицу categorygoods. ---
                $sql = "INSERT INTO categorygoods (goods_id, category_id) VALUE (?, ?)";
                $stmt = $this->dataBase->prepare($sql);
                foreach ($genres_id AS $id_genre)
                {
                    $stmt->execute(array($id_goods, $id_genre));
                }

                $result =  $this->dataBase->commit();
            }
            catch (Exception $e)
            {
                $this->dataBase->rollBack();
                echo $e->getMessage();
            }

            return $result;
        }
    }
?>