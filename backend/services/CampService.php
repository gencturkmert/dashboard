<?php

class CampService {
    private $campDao;

    public function __construct($campDao) {
        $this->campDao = $campDao;
    }

    public function getAllCamps() {
        return $this->campDao->getAllCamps();
    }

    public function updateCamp(Camp $camp) {
        return $this->campDao->updateCamp($camp);
    }

    public function insertCamp(Camp $camp) {
        return $this->campDao->insertCamp($camp);
    }
}
