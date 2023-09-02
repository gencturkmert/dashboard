<?php

class AnimalService
{
    private $animalDao;
    private $kindDao;

    private $campDao;

    private $employeeDao;

    public function __construct($animalDao, $kindDao, $campDao, $employeeDao)
    {
        $this->animalDao = $animalDao;
        $this->kindDao = $kindDao;
        $this->campDao = $campDao;
        $this->employeeDao = $employeeDao;
    }

    public function getAllAnimalsWithDetails()
    {
        $animals = $this->animalDao->getAllAnimals();
        // return $animals;

        // Iterate through animals and replace attributes
        // foreach ($animals as &$animal) {
        //     $kindId = $animal->getKind();
        //     $kind = $this->kindDao->getKindById($kindId);
        //     $animal->setKind($kind);

        //     $caretakerId = $animal->getCaretaker();
        //     $caretaker = $this->employeeDao->getEmployeeById($caretakerId);
        //     $animal->setCaretaker($caretaker);

        //     $placeId = $animal->getCamp();
        //     $camp = $this->campDao->getCampById($placeId);
        //     $animal->setCamp($camp);
        // }

        return $animals;
    }

    public function getAnimalByIdWithDetails($animalId)
    {
        $animal = $this->animalDao->getAnimalById($animalId);

        if ($animal) {
            $kindId = $animal->getKind();
            $kind = $this->kindDao->getKindById($kindId);
            $animal->setKind($kind);

            $caretakerId = $animal->getCaretaker();
            $caretaker = $this->employeeDao->getEmployeeById($caretakerId);
            $animal->setCaretaker($caretaker);

            $placeId = $animal->getCamp();
            $camp = $this->campDao->getCampById($placeId);
            $animal->setCamp($camp);
        }

        return $animal;
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
