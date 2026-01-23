<?php

namespace App\Service;

use App\Reposiroty\Contract\ProfileRepositoryInterface;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ProfileService
{
    protected $profileRepo;

    public function __construct(ProfileRepositoryInterface $profileRepo)
    {
        $this->profileRepo = $profileRepo;
    }

    public function showProfile($id)
    {
        $data = $this->profileRepo->showProfile($id);
        return $data;
    }

    public function updateProfile($id, $data)
    {
        $profile = $this->profileRepo->updateProfile($id, [
            'name' => $data['name'],
            'age' => $data['age'],
            'phone' => $data['phone'],
        ]);
        return $profile;
    }
}
