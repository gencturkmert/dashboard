<?php

require('vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Auth
{
    private $userDao;
    private $jwtSecret = 'your-secret-key'; // Replace with your secret key

    public function __construct($userDao)
    {
        $this->userDao = $userDao;
    }

    public function generateToken($userData)
    {
        $currentTime = time();

        $tokenPayload = array(
            "sub" => $userData['id'],
            "username" => $userData['username'],
            "iat" => $currentTime, // Issued At
            "exp" => $currentTime + 900, // Expire in 15 minutes
        );

        $token = JWT::encode($tokenPayload, $this->jwtSecret, 'HS256');
        return $token;
    }

    public function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->jwtSecret, 'HS256'));

            $currentTime = time();
            if ($decoded->exp < $currentTime) {
                return false;
            }

            return true;
        } catch (Exception $e) {

            return false;
        }
    }

    public function logout($token)
    {
        // You can implement logout logic here
        // For example, mark the token as invalidated in the database
        // or simply delete it from the client-side storage
        // ...

        // In this example, we'll just return a message
        return "Logged out successfully";
    }

    public function login($username, $password)
    {
        // Validate username and password
        //password_verify($password, $user->getPassword()
        $user = $this->userDao->getUserByUsername($username);
        if (!$user || $password != $user->getPassword()) {
            echo "INVALID CREDENTIALS";
            return false; // Invalid credentials
        }

        // Generate a token
        $userData = [
            'id' => $user->getId(),
            'username' => $user->getUsername()
        ];

        $token = $this->generateToken($userData);

        return $token;
    }
}
