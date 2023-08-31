<?php

class UserService {
    private $userDao;

    public function __construct($userDao) {
        $this->userDao = $userDao;
    }

    public function getAllUsers() {
        return $this->userDao->getAllUsers();
    }

    public function updateUser(User $user) {
        return $this->userDao->updateUser($user);
    }

    public function insertUser(User $user) {
        return $this->userDao->insertUser($user);
    }
}
