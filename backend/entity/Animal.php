<?php

class Animal
{
    private $id;
    private $name;
    private $kind;
    private $age;
    private $place;
    private $caretaker;

    public function __construct($id, $name, $kind, $age, $place, $caretaker)
    {
        $this->id = $id;
        $this->name = $name;
        $this->kind = $kind;
        $this->age = $age;
        $this->place = $place;
        $this->caretaker = $caretaker;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getKind()
    {
        return $this->kind;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function getCamp()
    {
        return $this->place;
    }

    public function getCaretaker()
    {
        return $this->caretaker;
    }

    // Setter methods
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setKind($kind)
    {
        $this->kind = $kind;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setCamp($place)
    {
        $this->place = $place;
    }

    public function setCaretaker($caretaker)
    {
        $this->caretaker = $caretaker;
    }
}
