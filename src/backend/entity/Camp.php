<?php

class Camp
{
    private $id;
    private $name;
    private $city;
    private $zipcode;
    private $maxCapacity;
    private $active;

    public function __construct($id, $name, $city, $zipcode, $maxCapacity, $active)
    {
        $this->id = $id;
        $this->name = $name;
        $this->city = $city;
        $this->zipcode = $zipcode;
        $this->maxCapacity = $maxCapacity;
        $this->active = $active;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getZipcode()
    {
        return $this->zipcode;
    }

    public function getMaxCapacity()
    {
        return $this->maxCapacity;
    }

    public function isActive()
    {
        return $this->active;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;
    }

    public function setMaxCapacity($maxCapacity)
    {
        $this->maxCapacity = $maxCapacity;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }
}
