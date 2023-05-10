<?php
class Category
{
    private $conn;
    private $table = 'categories';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function readAll()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}