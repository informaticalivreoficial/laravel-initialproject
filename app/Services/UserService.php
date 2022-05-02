<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers()
    {
       return $this->userRepository->getUsersAll();
    }

    public function getUser($id)
    {
       return $this->userRepository->getUser($id);
    }

    public function getTeam()
    {
       return $this->userRepository->getUsersTeam();
    }

    public function setStatus(array $data)
    {
        $data = $this->userRepository->userSetStatus($data);
        return ['success' => true];
    }
}