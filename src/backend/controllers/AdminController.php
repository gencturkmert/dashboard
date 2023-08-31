<?php


class AdminController
{
    private $userService;
    private $animalService;
    private $employeeService;
    private $campService;
    private $auth;

    public function __construct($userService, $animalService, $employeeService, $campService, $auth)
    {
        $this->userService = $userService;
        $this->animalService = $animalService;
        $this->employeeService = $employeeService;
        $this->campService = $campService;
        $this->auth = $auth;
    }

    public function handleRequest()
    {
        // Check token validity
        $token = $_SERVER["HTTP_AUTHORIZATION"] ?? '';
        if (!$this->auth->validateToken($token)) {
            http_response_code(401);
            echo json_encode(array("message" => "Unauthorized"));
            return;
        }

        $requestMethod = $_SERVER["REQUEST_METHOD"];
        $path = $_SERVER["REQUEST_URI"];

        switch ($requestMethod) {
            case "GET":
                $this->handleGetRequest($path);
                break;
                // Add cases for other HTTP methods (POST, PUT, DELETE) if needed
            default:
                http_response_code(405); // Method Not Allowed
                echo json_encode(array("message" => "Method not allowed"));
        }
    }

    public function handleGetRequest($path)
    {
        switch ($path) {
            case "/admin/users":
                $users = $this->userService->getAllUsers();
                echo json_encode($users);
                break;
            case "/admin/animals":
                $animals = $this->animalService->getAllAnimals();
                echo json_encode($animals);
                break;
            case "/admin/employees":
                $employees = $this->employeeService->getAllEmployees();
                echo json_encode($employees);
                break;
            case "/admin/camps":
                $camps = $this->campService->getAllCamps();
                echo json_encode($camps);
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Not Found"));
        }
    }
}
