<?php
class City
{
    private $conn;
    private $table = 'cities';
    public $name;
    public $slug;

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

    public function findOrCreate()
    {
        // Check if city exists
        $query = 'SELECT id FROM ' . $this->table . ' WHERE name = :name AND slug = :slug LIMIT 1';
        $stmt = $this->conn->prepare($query);

        $this->slug = strtolower($this->name);
        $this->slug = preg_replace('/[^a-z0-9]+/', '-', $this->slug);
        $this->slug = trim($this->slug, '-');

        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // If city exists, return the id
        if ($row) {
            return $row['id'];
        } else {
            // If city does not exist, create it and return the new id
            $query = 'INSERT INTO ' . $this->table . ' (name, slug) VALUES (:name, :slug)';
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':slug', $this->slug);
            $stmt->execute();
            return $this->conn->lastInsertId();
        }
    }


}