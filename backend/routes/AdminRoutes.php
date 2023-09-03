<?php
class AdminRoutes
{
    private $auth;
    private $adminController;

    public function __construct($auth, $adminController)
    {
        $this->auth = $auth;
        $this->adminController = $adminController;
    }

    public function handleRequest($requestMethod, $requestUri, $requestHeaders, $requestData = null)
    {

        if (strpos($requestUri, "/admin") !== 0) {
            http_response_code(404);
            echo json_encode(array("message" => "Not Found"));
            return;
        }

        if ($this->auth->validateToken($requestHeaders)) {


            switch ($requestMethod) {
                case "GET":
                    $this->adminController->handleGetRequest($requestUri, $requestData);
                    break;
                case "POST":
                    $this->adminController->handlePostRequest($requestUri, $requestData);
                    break;
                case "PUT":
                    $this->adminController->handlePutRequest($requestUri, $requestData);
                    break;
                default:
                    http_response_code(405); // Method not allowed
                    echo json_encode(array("message" => "Method Not Allowed"));
            }
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Unauthorized"));
        }
    }
}
