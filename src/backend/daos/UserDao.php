<?php

require_once("src/backend/entity/User.php");

class UserDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllUsers()
    {
        $query = "SELECT * FROM users";
        $result = $this->conn->query($query);

        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }

        return $users;
    }

    public function updateUser(User $user)
    {
        $query = "UPDATE users SET username=?, email=?, password=?, name=?, role=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssssi", $user->getUsername(), $user->getEmail(), $user->getPassword(), $user->getName(), $user->getRole(), $user->getId());

        return $stmt->execute();
    }

    public function insertUser(User $user)
    {
        $query = "INSERT INTO users (username, email, password, name, role) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssss", $user->getUsername(), $user->getEmail(), $user->getPassword(), $user->getName(), $user->getRole());

        return $stmt->execute();
    }


    public function getUserByUsername($username)
    {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            return new User(
                $row["id"],
                $row["username"],
                $row["email"],
                $row["password"],
                $row["name"],
                $row["role"]
            );
        }

        return null;
    }
}
