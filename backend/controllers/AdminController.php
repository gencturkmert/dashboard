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

    public function handleRequest($requestMethod, $requestUri, $requestHeaders, $requestData)
    {
        // Check token validity
        $token = $_SERVER["HTTP_AUTHORIZATION"] ?? '';
        if (!$this->auth->validateToken($token)) {
            echo json_encode(array("success" => false, "message" => "Unauthorized"));
            return;
        }


        switch ($requestMethod) {
            case "GET":
                $this->handleGetRequest($requestUri, $requestData);
                break;
            case "POST":
                $this->handlePostRequest($requestUri, $requestData);
                break;
            default:
                http_response_code(405); // Method Not Allowed
                echo json_encode(array("message" => "Method not allowed"));
        }
    }

    public function handleGetRequest($path, $requestData)
    {
        switch ($path) {
            case "/admin/users":
                $users = $this->userService->getAllUsers();
                echo json_encode($users);
                break;
            case "/admin/animals":
                $animals = $this->animalService->getAllAnimalsWithDetails();
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

            case "/admin/kinds":
                $kinds = $this->animalService->getAllKinds();
                echo json_encode($kinds);
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Not Found"));
        }
    }

    public function handlePostRequest($path, $requestData)
    {
        switch ($path) {
            case "/admin/deleteEmployee":
                $success = $this->employeeService->deleteEmployee($requestData);
                echo json_encode(array("success" => $success, "data" => $requestData));
                break;
            case "/admin/updateEmployee":
                $success = $this->employeeService->updateEmployee($requestData);
                echo json_encode(array("success" => $success, "data" => $requestData));
                break;
            default:
                http_response_code(404);
                echo json_encode(array("message" => "Not Found"));
        }
    }
}
