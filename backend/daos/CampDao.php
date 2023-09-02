<?php

require_once("backend/entity/Camp.php");

class CampDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllCamps()
    {
        $query = "SELECT * FROM camps";
        $result = $this->conn->query($query);

        $camps = array();
        while ($row = $result->fetch_assoc()) {
            $camps[] = $row;
        }

        return $camps;
    }

    public function getAllActiveCamps()
    {
        $query = "SELECT * FROM camps WHERE active = 1";
        $result = $this->conn->query($query);

        $camps = array();
        while ($row = $result->fetch_assoc()) {
            $camps[] = $row;
        }

        return $camps;
    }

    public function getCampById($campId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM camps WHERE id = ?");
            $stmt->bind_param("i", $campId);
            $stmt->execute();
            $result = $stmt->get_result();
            $campData = $result->fetch_assoc();

            if ($campData) {
                return new Camp(
                    $campData['id'],
                    $campData['name'],
                    $campData['city'],
                    $campData['zipcode'],
                    $campData['max_capacity'],
                    $campData['active']
                );
            } else {
                return null; // Camp not found
            }
        } catch (mysqli_sql_exception $e) {
            die("Error retrieving camp: " . $e->getMessage());
        }
    }


    public function updateCamp(Camp $camp)
    {
        $query = "UPDATE camps SET name=?, city=?, zipcode=?, max_capacity=?, active=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiiii", $camp->getName(), $camp->getCity(), $camp->getZipcode(), $camp->getMaxCapacity(), $camp->isActive(), $camp->getId());

        return $stmt->execute();
    }

    public function insertCamp(Camp $camp)
    {
        $query = "INSERT INTO camps (name, city, zipcode, max_capacity, active) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssiii", $camp->getName(), $camp->getCity(), $camp->getZipcode(), $camp->getMaxCapacity(), $camp->isActive());

        return $stmt->execute();
    }
}
