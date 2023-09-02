<?php
require_once("backend/entity/Animal.php");

class AnimalDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllAnimals()
    {
        $animals = array();

        try {
            $query = "SELECT * FROM animals";
            $result = $this->conn->query($query);

            while ($row = $result->fetch_assoc()) {
                $animalData = array(
                    "id" => $row['id'],
                    "name" => $row['name'],
                    "kind_id" => $row['kind_id'],
                    "age" => $row['age'],
                    "camp" => $row['place'],
                    "caretaker_id" => $row['caretaker_id']
                );


                $animals[] = $animalData;
            }
        } catch (mysqli_sql_exception $e) {
            die("Error retrieving animals: " . $e->getMessage());
        }

        return $animals;
    }

    public function getAnimalById($animalId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM animals WHERE id = :animalId");
            $stmt->bindParam(":animalId", $animalId, PDO::PARAM_INT);
            $stmt->execute();
            $animalData = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($animalData) {
                $animal = new Animal(
                    $animalData['id'],
                    $animalData['name'],
                    $animalData['kind_id'],
                    $animalData['age'],
                    $animalData['place'],
                    $animalData['caretaker_id']
                );

                return $animal;
            } else {
                return null; // Animal not found
            }
        } catch (PDOException $e) {
            die("Error retrieving animal: " . $e->getMessage());
        }
    }

    public function insertAnimal(Animal $animal)
    {
        try {
            $stmt = $this->conn->prepare("INSERT INTO animals (name, kind_id, age, place, caretaker_id) VALUES (:name, :kind_id, :age, :place, :caretaker_id)");
            $stmt->bindValue(":name", $animal->getName());
            $stmt->bindValue(":kind_id", $animal->getKind());
            $stmt->bindValue(":age", $animal->getAge());
            $stmt->bindValue(":place", $animal->getPlace());
            $stmt->bindValue(":caretaker_id", $animal->getCaretaker());
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error inserting animal: " . $e->getMessage());
        }
    }

    public function updateAnimal(Animal $animal)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE animals SET name = :name, kind_id = :kind_id, age = :age, place = :place, caretaker_id = :caretaker_id WHERE id = :id");
            $stmt->bindValue(":name", $animal->getName());
            $stmt->bindValue(":kind_id", $animal->getKind());
            $stmt->bindValue(":age", $animal->getAge());
            $stmt->bindValue(":place", $animal->getPlace());
            $stmt->bindValue(":caretaker_id", $animal->getCaretaker());
            $stmt->bindValue(":id", $animal->getId());
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error updating animal: " . $e->getMessage());
        }
    }
}
