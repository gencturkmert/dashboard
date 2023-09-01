<?php

require_once("backend/auth/auth.php");
require_once("backend/config/config.php");
require_once("backend/controllers/AdminController.php");
require_once("backend/controllers/AuthController.php");

require_once("backend/routes/AdminRoutes.php");

$adminController = new AdminController($userService, $animalService, $employeeService, $campService, $auth);
$authController = new AuthController($auth);

$adminRoutes = new AdminRoutes($auth, $adminController);



// Simulate handling of requests
$requestMethod = $_SERVER["REQUEST_METHOD"];
$requestUri = $_SERVER["REQUEST_URI"];
$requestHeaders = $_SERVER["HTTP_AUTHORIZATION"] ?? '';
$requestData = json_decode(file_get_contents("php://input"), true); // Get request data

// Check if the request starts with "/admin"
if (strpos($requestUri, "/admin") === 0) {
    // Requests starting with "/admin" go to AdminRoutes
    $adminRoutes->handleRequest($requestMethod, $requestUri, $requestHeaders, $requestData);
} elseif (strpos($requestUri, "/auth") === 0) {
    // Login requests go to AuthController's login method
    $authController->handleRequest($requestMethod, $requestUri, $requestHeaders, $requestData);
} else {
    // Handle other routes or return a "Not Found" response
    http_response_code(404);
    echo json_encode(array("message" => "Not Found"));
}
