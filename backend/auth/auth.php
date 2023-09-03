<?php

require('vendor/autoload.php');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;


class Auth
{
    private $userDao;
    private $jwtSecret = 'jhsdkjfyu003h'; // Replace with your secret key

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
            "exp" => $currentTime + 1200, // Expire in 15 minutes
        );

        $token = JWT::encode($tokenPayload, $this->jwtSecret, 'HS256');
        return $token;
    }

    public function validateToken($token)
    {
        $token = trim(str_replace("Bearer", "", $token));


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



    public function login($username, $password)
    {
        // Validate username and password
        //password_verify($password, $user->getPassword()
        $user = $this->userDao->getUserByUsername($username);
        if (!$user || password_verify($password, $user->getPassword())) {
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

    private function decrypt($encryptedData, $key)
    {
        $encryptedData = base64_decode($encryptedData);
        $iv = substr($encryptedData, 0, 16); // Extract the IV from the beginning
        $cipherText = substr($encryptedData, 16); // Extract the cipher text
        $plainText = openssl_decrypt($cipherText, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        return $plainText;
    }
}
