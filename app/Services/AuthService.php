<?php

namespace App\Services;

use App\Constants\AppConstants;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    /**
     * @param array $data
     * @return array
     */

    public function SignIn($data)
    {
        try {

            $user = User::where('email', $data['email'])->first();

            if ($user && Hash::check($data['password'], $user->password)) {
                $token = $user->createToken('auth_token')->accessToken;

                return [
                    'status' => true,
                    'message' => 'Login successful',
                    'data' => [
                        'user' => $user,
                        'token' => $token
                    ]
                ];
            } else {
                return [
                    'status' => false,
                    'message' => 'Login failed'
                ];
            }
        } catch (\Exception $e) {
            return [
                'status' => false,
                'message' => 'Login failed'
            ];
        }
    }
}
