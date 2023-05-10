<?php
class Event
{
    private $conn;
    private $table = 'events';

    public $event_id;
    public $name;
    public $description;
    public $start_time;
    public $end_time;
    public $location;
    public $banner_image;
    public $category_id;
    public $city_id;
    public $user_id;
    public $slug;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Create Event
    public function create()
    {
        $query = 'INSERT INTO ' . $this->table . ' SET name = :name, description = :description, start_time = :start_time, end_time = :end_time, location = :location, banner_image = :banner_image, category_id = :category_id, city_id = :city_id, user_id = :user_id, slug = :slug';

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->start_time = htmlspecialchars(strip_tags($this->start_time));
        $this->end_time = htmlspecialchars(strip_tags($this->end_time));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->banner_image = htmlspecialchars(strip_tags($this->banner_image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->city_id = htmlspecialchars(strip_tags($this->city_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->slug = strtolower($this->name);
        $this->slug = preg_replace('/[^a-z0-9]+/', '-', $this->slug);
        $this->slug = trim($this->slug, '-');

        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':banner_image', $this->banner_image);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':city_id', $this->city_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':slug', $this->slug);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }

        printf("Error: %s.\n", $stmt->error);

        return null;
    }

    // Read all Events
    public function readAll()
    {
        $query = 'SELECT * FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function readSingle()
    {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE event_id = ? LIMIT 0,1';

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->event_id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return [
                'name' => $row['name'],
                'description' => $row['description'],
                'start_time' => $row['start_time'],
                'end_time' => $row['end_time'],
                'location' => $row['location'],
                'banner_image' => $row['banner_image'],
                'category_id' => $row['category_id'],
                'city_id' => $row['city_id'],
                'user_id' => $row['user_id'],
                'slug' => $row['slug']
            ];
        } else {
            return null;
        }
    }


    // Update Event
    public function update()
    {
        $query = 'UPDATE ' . $this->table . ' SET name = :name, description = :description, start_time = :start_time, end_time = :end_time, location = :location, banner_image = :banner_image, category_id = :category_id, city_id = :city_id, user_id = :user_id, slug = :slug WHERE event_id = :event_id';

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->start_time = htmlspecialchars(strip_tags($this->start_time));
        $this->end_time = htmlspecialchars(strip_tags($this->end_time));
        $this->location = htmlspecialchars(strip_tags($this->location));
        $this->banner_image = htmlspecialchars(strip_tags($this->banner_image));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->city_id = htmlspecialchars(strip_tags($this->city_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->slug = htmlspecialchars(strip_tags($this->slug));
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));

        // bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':start_time', $this->start_time);
        $stmt->bindParam(':end_time', $this->end_time);
        $stmt->bindParam(':location', $this->location);
        $stmt->bindParam(':banner_image', $this->banner_image);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':city_id', $this->city_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':slug', $this->slug);
        $stmt->bindParam(':event_id', $this->event_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Event
    public function delete()
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE event_id = :event_id';

        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));

        // bind event id
        $stmt->bindParam(':event_id', $this->event_id);

        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}