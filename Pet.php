<?php
class Pet {
    private $conn;
    private $table = 'pets';

    public $id;
    public $name;
    public $species;
    public $breed;
    public $birth_date;
    public $owner_name;
    public $owner_phone;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                SET name = :name,
                    species = :species,
                    breed = :breed,
                    birth_date = :birth_date,
                    owner_name = :owner_name,
                    owner_phone = :owner_phone";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->species = htmlspecialchars(strip_tags($this->species));
        $this->breed = htmlspecialchars(strip_tags($this->breed));
        $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
        $this->owner_name = htmlspecialchars(strip_tags($this->owner_name));
        $this->owner_phone = htmlspecialchars(strip_tags($this->owner_phone));

        // Bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':species', $this->species);
        $stmt->bindParam(':breed', $this->breed);
        $stmt->bindParam(':birth_date', $this->birth_date);
        $stmt->bindParam(':owner_name', $this->owner_name);
        $stmt->bindParam(':owner_phone', $this->owner_phone);

        return $stmt->execute();
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                  SET name = :name,
                      species = :species,
                      breed = :breed,
                      birth_date = :birth_date,
                      owner_name = :owner_name,
                      owner_phone = :owner_phone
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->species = htmlspecialchars(strip_tags($this->species));
        $this->breed = htmlspecialchars(strip_tags($this->breed));
        $this->birth_date = htmlspecialchars(strip_tags($this->birth_date));
        $this->owner_name = htmlspecialchars(strip_tags($this->owner_name));
        $this->owner_phone = htmlspecialchars(strip_tags($this->owner_phone));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind parameters
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':species', $this->species);
        $stmt->bindParam(':breed', $this->breed);
        $stmt->bindParam(':birth_date', $this->birth_date);
        $stmt->bindParam(':owner_name', $this->owner_name);
        $stmt->bindParam(':owner_phone', $this->owner_phone);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}
?>
