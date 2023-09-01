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
        $query = "SELECT * FROM animals";
        $result = $this->conn->query($query);

        $animals = array();
        while ($row = $result->fetch_assoc()) {
            $animals[] = $row;
        }

        return $animals;
    }

    public function updateAnimal(Animal $animal)
    {
        $query = "UPDATE animals SET name=?, kind=?, age=?, place=?, caretaker=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiiii", $animal->getName(), $animal->getKind()->getId(), $animal->getAge(), $animal->getPlace(), $animal->getCaretaker(), $animal->getId());

        return $stmt->execute();
    }

    public function insertAnimal(Animal $animal)
    {
        $query = "INSERT INTO animals (name, kind, age, place, caretaker) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiii", $animal->getName(), $animal->getKind()->getId(), $animal->getAge(), $animal->getPlace(), $animal->getCaretaker());

        return $stmt->execute();
    }
}
