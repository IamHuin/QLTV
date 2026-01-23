<?php

namespace App\Repository\Eloquent;

use App\Models\Profile;
use App\Repository\Contract\ProfileRepositoryInterface;

class ProfileRepository implements ProfileRepositoryInterface
{

    public function showProfile($id)
    {
        // TODO: Implement showProfile() method.
        $profile = Profile::where('id', $id)->first();
        if (isset($profile)) {
            return $profile;
        }
        return  null;
    }

    public function updateProfile($id, array $data)
    {
        // TODO: Implement updateProfile() method.
        $profile = Profile::where('id', $id)->first();
        if (isset($profile)) {
            $profile->update($data);
            return $profile;
        }
        return null;
    }
}
