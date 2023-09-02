<?php

require_once("backend/entity/Employee.php");

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

    public function getEmployeeById($employeeId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM employees WHERE id = ?");
            $stmt->bind_param("i", $employeeId);
            $stmt->execute();
            $result = $stmt->get_result();
            $employeeData = $result->fetch_assoc();

            if ($employeeData) {
                return new Employee(
                    $employeeData['id'],
                    $employeeData['name'],
                    $employeeData['surname'],
                    $employeeData['role'],
                    $employeeData['gender'],
                    $employeeData['chief_id'],
                    $employeeData['location'],
                    $employeeData['active'],
                    $employeeData['age']
                );
            } else {
                return null; // Employee not found
            }
        } catch (mysqli_sql_exception $e) {
            die("Error retrieving employee: " . $e->getMessage());
        }
    }


    public function updateEmployee(Employee $employee)
    {
        $query = "UPDATE employees SET name=?, surname =?, role=?, gender=?, chief=?, location=?, active=?, registered_date=?, end_date=? WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiisiis", $employee->getName(), $employee->getRole(), $employee->getGender(), $employee->getChief(), $employee->getLocation(), $employee->isActive(), $employee->getRegisteredDate(), $employee->getEndDate(), $employee->getId());

        return $stmt->execute();
    }

    public function insertEmployee(Employee $employee)
    {
        $query = "INSERT INTO employees (name, surname,role, gender, chief, location, active, registered_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiisis", $employee->getName(), $employee->getSurname(), $employee->getRole(), $employee->getGender(), $employee->getChief(), $employee->getLocation(), $employee->isActive(), $employee->getRegisteredDate(), $employee->getEndDate());

        return $stmt->execute();
    }
}
