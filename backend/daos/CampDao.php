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
