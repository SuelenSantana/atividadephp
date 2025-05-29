<?php
class Procedure {
    private $conn;
    private $table = 'procedures';

    public $id;
    public $pet_id;
    public $procedure_name;
    public $procedure_date;
    public $description;
    public $veterinarian;

    // Construtor: recebe a conexão com o banco e armazena na propriedade $conn
    public function __construct($db) {
        $this->conn = $db;
    }

    // Método para criar um novo procedimento no banco de dados
    public function create() {
        $query = "INSERT INTO " . $this->table . " 
                  (pet_id, procedure_name, procedure_date, description, veterinarian)
                  VALUES (:pet_id, :procedure_name, :procedure_date, :description, :veterinarian)";
        
        $stmt = $this->conn->prepare($query);

        // Sanitiza os dados
        $this->pet_id = htmlspecialchars(strip_tags($this->pet_id));
        $this->procedure_name = htmlspecialchars(strip_tags($this->procedure_name));
        $this->procedure_date = htmlspecialchars(strip_tags($this->procedure_date));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->veterinarian = htmlspecialchars(strip_tags($this->veterinarian));

        // Faz o bind dos parâmetros
        $stmt->bindParam(':pet_id', $this->pet_id);
        $stmt->bindParam(':procedure_name', $this->procedure_name);
        $stmt->bindParam(':procedure_date', $this->procedure_date);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':veterinarian', $this->veterinarian);

        // Executa e retorna o resultado (true ou false)
        return $stmt->execute();
    }

    public function readByPet($pet_id) {
        $query = "SELECT * FROM " . $this->table . " 
                 WHERE pet_id = ? 
                 ORDER BY procedure_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $pet_id);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table . " 
                SET procedure_name = :procedure_name,
                    procedure_date = :procedure_date,
                    description = :description,
                    veterinarian = :veterinarian
                WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->procedure_name = htmlspecialchars(strip_tags($this->procedure_name));
        $this->procedure_date = htmlspecialchars(strip_tags($this->procedure_date));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->veterinarian = htmlspecialchars(strip_tags($this->veterinarian));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':procedure_name', $this->procedure_name);
        $stmt->bindParam(':procedure_date', $this->procedure_date);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':veterinarian', $this->veterinarian);
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
