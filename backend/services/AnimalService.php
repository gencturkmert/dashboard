<?php

class AnimalService
{
    private $animalDao;
    private $kindDao;

    public function __construct($animalDao, $kindDao)
    {
        $this->animalDao = $animalDao;
        $this->kindDao = $kindDao;
    }

    public function getAllAnimals()
    {
        return $this->animalDao->getAllAnimals();
    }

    public function updateAnimal(Animal $animal)
    {
        return $this->animalDao->updateAnimal($animal);
    }

    public function insertAnimal(Animal $animal)
    {
        return $this->animalDao->insertAnimal($animal);
    }

    public function getAllKinds()
    {
        return $this->kindDao->getAllKinds();
    }

    public function updateKind(Kind $kind)
    {
        return $this->kindDao->updateKind($kind);
    }

    public function insertKind(Kind $kind)
    {
        return $this->kindDao->insertKind($kind);
    }
}
