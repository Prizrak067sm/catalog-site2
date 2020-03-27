<?php
spl_autoload_register();   // Включаем автозагрузку файлов.
class Model extends DBconnect
{
    public $dataBase;

    function __construct()
    {
        parent::__construct();
        $this->dataBase = $this->connect();
    }

    function get_data()   // Для выборки данных
    {

    }
}
?>