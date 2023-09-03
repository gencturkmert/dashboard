<?php


class AuthController
{
    private $auth;

    public function __construct($auth)
    {
        $this->auth = $auth;
    }

    public function handleRequest($requestMethod, $requestUri, $requestHeaders, $requestData)
    {
        // Check if the request URI matches "/auth/login"
        if ($requestUri === "/auth/login" && $requestMethod === "POST") {
            $this->handleLogin($requestData);
        }
        // Check if the request URI matches "/auth/logout"
        elseif ($requestUri === "/auth/logout" && $requestMethod === "POST") {
            $this->handleLogout($requestData);
        } elseif ($requestUri === "/auth/validate" && $requestMethod === "POST") {
            $this->handleValidateToken($requestData);
        } else {
            http_response_code(404);
            echo json_encode(array("message" => "Not Found", "error" => $requestUri));
        }
    }


    private function handleLogin($requestData)
    {
        $username = $requestData["username"];
        $password = $requestData["password"];

        $token = $this->auth->login($username, $password);

        if ($token) {
            http_response_code(200);
            echo json_encode(array("success" => true, "token" => $token));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid Credentials"));
        }
    }

    public function handleValidateToken($requestData)
    {
        $token = $requestData["token"];
        if ($this->auth->validateToken($token)) {
            echo json_encode(array("success" => true));
            http_response_code(200);
        } else {
            echo json_encode(array("success" => false));
            http_response_code(401);
        }
    }

    private function handleLogout($requestData)
    {
    }
}
