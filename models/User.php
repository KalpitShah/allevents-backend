<?php

class User
{
    // DB stuff
    private $conn;
    private $table = 'users';

    // User properties
    public $user_id;
    public $name;
    public $email;
    public $image_url;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get Users
    public function read()
    {
        // Create query
        $query = 'SELECT * FROM ' . $this->table;

        // Prepared statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }

    // Get Single User
    public function read_single()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE user_id = ? LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->user_id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if there is a result
        if ($row) {
            // Return the result as an associative array
            return array(
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'image_url' => $row['image_url']
            );
        } else {
            // Return null if no user was found
            return null;
        }
    }


    // Create User
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET user_id = :user_id, name = :name, email = :email, image_url = :image_url';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update User
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET name = :name, email = :email, image_url = :image_url WHERE user_id = :user_id';

        // Prepare statement
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->image_url = htmlspecialchars(strip_tags($this->image_url));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':image_url', $this->image_url);
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete User
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE user_id = :user_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));

        // Bind data
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}

?>