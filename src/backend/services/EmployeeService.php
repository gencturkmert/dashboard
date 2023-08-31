<?php

class EmployeeService {
    private $employeeDao;

    public function __construct($employeeDao) {
        $this->employeeDao = $employeeDao;
    }

    public function getAllEmployees() {
        return $this->employeeDao->getAllEmployees();
    }

    public function updateEmployee(Employee $employee) {
        return $this->employeeDao->updateEmployee($employee);
    }

    public function insertEmployee(Employee $employee) {
        return $this->employeeDao->insertEmployee($employee);
    }
}
