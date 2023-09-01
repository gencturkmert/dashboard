<?php

require_once("backend/entity/Kind.php");


class KindDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllKinds()
    {
        $query = "SELECT * FROM kinds";
        $result = $this->conn->query($query);

        $kinds = array();
        while ($row = $result->fetch_assoc()) {
            $kinds[] = $row;
        }

        return $kinds;
    }

    public function updateKind(Kind $kind)
    {
        $query = "UPDATE kinds SET name=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("si", $kind->getName(), $kind->getId());

        return $stmt->execute();
    }

    public function insertKind(Kind $kind)
    {
        $query = "INSERT INTO kinds (name) VALUES (?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $kind->getName());

        return $stmt->execute();
    }
}
