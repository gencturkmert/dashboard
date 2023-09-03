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
        $query = "SELECT * FROM employees WHERE active = 1";
        $result = $this->conn->query($query);

        $employees = array();
        while ($row = $result->fetch_assoc()) {
            $employeeData = array(
                "id" => $row['id'],
                "name" => $row['name'],
                "surname" => $row['surname'],
                "role" => $row['role'],
                "gender" => $row['gender'],
                "chief_id" => $row['chief_id'],
                "camp" => $row['location'],
                "active" => $row['active'],
                "age" => $row['age']
            );

            $employees[] = $employeeData;
        }

        return $employees;
    }

    public function getEmployeeById($employeeId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM employees WHERE id = ? AND WHERE active = 1");
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


    public function updateEmployee($requestData)
    {
        $query = "UPDATE employees SET name=?, surname =?, role=?, chief_id=?, location=?  WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("sssiii", $requestData["name"], $requestData["surname"], $requestData["role"], $requestData["chief"], $requestData["camp"], $requestData["id"]);

        return $stmt->execute();
    }

    public function deleteEmployee($employeeId)
    {
        $query = "UPDATE employees SET active=0 WHERE id=?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $employeeId);

        return $stmt->execute();
    }

    public function insertEmployee(Employee $employee)
    {
        $query = "INSERT INTO employees (name, surname,role, gender, chief, location, active, age) VALUES (?, ?, ?, ?, ?, ?, ?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssiiii", $employee->getName(), $employee->getSurname(), $employee->getRole(), $employee->getGender(), $employee->getChiefId(), $employee->getLocation(), $employee->getActive(), $employee->getAge());

        return $stmt->execute();
    }
}
