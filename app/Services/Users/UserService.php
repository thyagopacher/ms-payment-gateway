<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        private UserRepository $userRepository
    ) {
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepository->create($data);
    }
}
