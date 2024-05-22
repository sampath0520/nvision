<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\AuthenticateRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(AuthenticateRequest $request)
    {

        $validated = $request->validated();
        try {
            $loginResponse = $this->authService->SignIn($validated);

            if ($loginResponse['status']) {
                return ResponseHelper::success($loginResponse['message'], $loginResponse['data']);
            } else {
                return ResponseHelper::error($loginResponse['message']);
            }
        } catch (\Exception $e) {
            return ResponseHelper::error($e->getMessage());
        }
    }
}
