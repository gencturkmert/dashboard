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

    public function getKindById($kindId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM kinds WHERE id = ?");
            $stmt->bind_param("i", $kindId);
            $stmt->execute();
            $result = $stmt->get_result();
            $kindData = $result->fetch_assoc();

            if ($kindData) {
                return new Kind(
                    $kindData['id'],
                    $kindData['name']
                );
            } else {
                return null; // Kind not found
            }
        } catch (mysqli_sql_exception $e) {
            die("Error retrieving kind: " . $e->getMessage());
        }
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
