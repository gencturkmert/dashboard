<?php
// api/daos/EmployeeDao.php

class EmployeeDao
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAllEmployees()
    {
        $query = "SELECT * FROM employees";
        $result = $this->conn->query($query);

        $employees = array();
        while ($row = $result->fetch_assoc()) {
            $employees[] = $row;
        }

        return $employees;
    }

    public function updateEmployee(Employee $employee)
    {
        $query = "UPDATE employees SET username=?, role=?, gender=?, chief=?, location=?, active=?, registered_date=?, end_date=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiisiis", $employee->getName(), $employee->getRole(), $employee->getGender(), $employee->getChief(), $employee->getLocation(), $employee->isActive(), $employee->getRegisteredDate(), $employee->getEndDate(), $employee->getId());

        return $stmt->execute();
    }

    public function insertEmployee(Employee $employee)
    {
        $query = "INSERT INTO employees (username, role, gender, chief, location, active, registered_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiisis", $employee->getName(), $employee->getRole(), $employee->getGender(), $employee->getChief(), $employee->getLocation(), $employee->isActive(), $employee->getRegisteredDate(), $employee->getEndDate());

        return $stmt->execute();
    }
}
