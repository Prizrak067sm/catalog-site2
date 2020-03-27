<?php
    class  Model_CategoryAdd extends Model
    {
        private $data_for_insert;
        function __construct($_data_for_insert)
        {
            parent::__construct();
            $this->data_for_insert=$_data_for_insert;
        }

        function set_data()
        {
            $this->dataBase->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );   // Выключаем эмуляцию, чтобы привязка переменных к плейсхолдерам в запросе не была строкой
            $genre = $this->data_for_insert['genre'];
            $brief_description = $this->data_for_insert['brief_description'];
            $full_description = $this->data_for_insert['full_description'];
            if ($this->data_for_insert['activ'])
                $activ = 1;
            else
                $activ = 0;

            $sql = "INSERT INTO category (id, genre, brief_description, full_description, activ) VALUE (NULL, ?, ?, ?, ?)";
            $stmt = $this->dataBase->prepare($sql);
            $result = $stmt->execute(array($genre, $brief_description, $full_description, $activ));

            return $result;
        }
    }
?>