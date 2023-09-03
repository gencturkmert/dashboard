<?php

class EmployeeService
{
    private $employeeDao;

    public function __construct($employeeDao)
    {
        $this->employeeDao = $employeeDao;
    }

    public function getAllEmployees()
    {
        return $this->employeeDao->getAllEmployees();
    }

    public function updateEmployee($requestData)
    {
        return $this->employeeDao->updateEmployee($requestData);
    }

    public function insertEmployee(Employee $employee)
    {
        return $this->employeeDao->insertEmployee($employee);
    }

    public function deleteEmployee($employeeData)
    {
        $employeId = $employeeData["id"];
        return $this->employeeDao->deleteEmployee($employeId);
    }
}
