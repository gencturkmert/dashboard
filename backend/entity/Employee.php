<?php
class Employee
{
    private $id;
    private $name;
    private $surname;
    private $role;
    private $gender;
    private $chief_id;
    private $location;
    private $active;
    private $age;

    public function __construct($id, $name, $surname, $role, $gender, $chief_id, $location, $active, $age)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->role = $role;
        $this->gender = $gender;
        $this->chief_id = $chief_id;
        $this->location = $location;
        $this->active = $active;
        $this->age = $age;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function getChiefId()
    {
        return $this->chief_id;
    }

    public function setChiefId($chief_id)
    {
        $this->chief_id = $chief_id;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }

    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }
}
