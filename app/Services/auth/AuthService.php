<?php

namespace App\Services\Auth;

use App\Models\User;

class AuthService
{
    /**
     *
     * @param User $user
     * @return array
     */
    public function getResponseBodyAuth(User $user): array
    {
        $token = $user->createToken(config('app.name'));

        return [
            'user' => $user,
            'sanctum_token' => $token->plainTextToken
        ];
    }
}
