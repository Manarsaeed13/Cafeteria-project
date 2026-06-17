<?php
class Database
{
    public $connection;
    public $statement;

    public function __construct()
    {
        $config = require 'config.php';

        $dsn = "mysql:" . http_build_query([
            'host' => $config['host'],
            'port' => $config['port'],
            'dbname' => $config['dbname'],
            'charset' => $config['charset']
        ], '', ';');

        
        $this->connection = new PDO($dsn, $config['user'], $config['password'], [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    public function query($query, $params = [])
    {
        $this->statement = $this->connection->prepare($query);
        $this->statement->execute($params);
        return $this;
    }

    public function get()
    {
        return $this->statement->fetchAll();
    }
}