<?php

require_once("auth/auth.php");
require_once("routes/adminRoutes.php");

require_once("config/config.php");

$adminController = new AdminController($workerService, $animalService, $campService);
$adminController->handleRequest($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
