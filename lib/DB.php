<?php

class DB {

    private $host = 'localhost';
    private $dbname = 'php_auth';
    private $user = 'root';
    private $pass = '';

    public $pdo;

    public function __construct() {

        if (!isset($this->pdo)) {
            try {
                $dsn = 'mysql:dbhost=' . $this->host . ';dbname=' . $this->dbname;
                $link = new PDO($dsn, $this->user, $this->pass);
                $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $link->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                $this->pdo = $link;
            } catch (PDOException $e) {
                die('Faild DB Connection... ') . $e->getMessage();
            }
        }
    }
}