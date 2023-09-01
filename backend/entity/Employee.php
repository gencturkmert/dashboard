<?php

class Employee
{
    private $id;
    private $name;
    private $role;
    private $gender;
    private $chief;
    private $location;
    private $active;
    private $registeredDate;
    private $endDate;

    public function __construct($id, $name, $chief, $location, $active, $registeredDate, $endDate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->chief = $chief;
        $this->location = $location;
        $this->active = $active;
        $this->registeredDate = $registeredDate;
        $this->endDate = $endDate;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function getChief()
    {
        return $this->chief;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function getRegisteredDate()
    {
        return $this->registeredDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($name)
    {
        $this->name = $name;
    }

    public function setRole($role)
    {
        if (in_array($role, array(EmployeeRole::MANAGER, EmployeeRole::CARETAKER, EmployeeRole::WORKER))) {
            $this->role = $role;
        } else {
            throw new Exception("Invalid role");
        }
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setChief($chief)
    {
        $this->chief = $chief;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function setRegisteredDate($registeredDate)
    {
        $this->registeredDate = $registeredDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }
}
