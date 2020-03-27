<?php
    class DBconnect
    {
        public $host;
        public $db;
        public $user;
        public $pass;
        public $charset;
        public $dsn;

        function __construct()
        {
            $this->host = 'localhost';
            $this->db   = 'catalog-site';
            $this->user = 'root';
            $this->pass = '1234567';
            $this->charset = 'utf8';
            $this->dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        }

        function connect()
        {
            $pdo = new PDO($this->dsn, $this->user, $this->pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        }
    }
?>