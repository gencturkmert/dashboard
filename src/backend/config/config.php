<?php
require_once("src/backend/core/db.php");

require_once("src/backend/services/EmployeeService.php");
require_once("src/backend/services/AnimalService.php");
require_once("src/backend/services/CampService.php");
require_once("src/backend/services/UserService.php");
require_once("src/backend/daos/EmployeeDao.php");
require_once("src/backend/daos/AnimalDao.php");
require_once("src/backend/daos/CampDao.php");
require_once("src/backend/daos/UserDao.php");
require_once("src/backend/daos/KindDao.php");
require_once("src/backend/auth/auth.php");



// Create DAO instances
$employeeDao = new EmployeeDao($conn);
$animalDao = new AnimalDao($conn);
$campDao = new CampDao($conn);
$userDao = new UserDao($conn);
$kindDao = new KindDao($conn);

// Create Service instances with injected DAOs
$employeeService = new EmployeeService($workerDao);
$animalService = new AnimalService($animalDao, $kindDao);
$campService = new CampService($campDao);
$userService = new USerService($userDao);

$auth = new Auth($userDao);
