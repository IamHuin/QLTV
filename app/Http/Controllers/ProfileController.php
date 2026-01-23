<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileFormRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use App\Service\ProfileService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;


class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Profile $profile)
    {
        try {
            $this->authorize('view', $profile);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $data = $this->profileService->showProfile($profile->id);
        return response()->json([
            'success' => true,
            'message' => __('Show successfully'),
            'data' => new ProfileResource($data)
        ]);
    }

    public function update(Profile $profile, ProfileFormRequest $request)
    {
        try {
            $this->authorize('update', $profile);
        } catch (AuthorizationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
        $this->profileService->updateProfile($profile->id, $request->validated());
        return response()->json([
            'success' => true,
            'message' => __('Update successfully')
        ]);
    }
}
