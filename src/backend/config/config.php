<?php
require_once("core/db.php");

require_once("services/EmployeeService.php");
require_once("services/AnimalService.php");
require_once("services/CampService.php");
require_once("services/UserService.php");

require_once("daos/EmployeeDao.php");
require_once("daos/AnimalDao.php");
require_once("daos/CampDao.php");
require_once("daos/UserDao.php");
require_once("daos/KindDao.php");


// Create DAO instances
$workerDao = new EmployeeDao($conn);
$animalDao = new AnimalDao($conn);
$campDao = new CampDao($conn);
$userDao = new UserDao($conn);
$kindDao = new KindDao($conn);

// Create Service instances with injected DAOs
$workerService = new EmployeeService($workerDao);
$animalService = new AnimalService($animalDao, $kindDao);
$campService = new CampService($campDao);
$userService = new USerService($userDao);
