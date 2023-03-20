<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use App\Services\Contracts\AuthContract;

class AuthService implements AuthContract
{
    /**
     * test if user and password is ok and return token 
     *
     * @param User $user
     * @param [type] $input
     * @return JsonResponse
     */
    public function accessToken(User $user, $password): JsonResponse
    {
        if ($user && Hash::check($password, $user->password)) {
            $user->picture;
            return response()->json([
                'access_token' => $user->createToken('test_token')->plainTextToken,
                'authenticated' => true,
                'user' => $user
            ], 200);
        } else {
            return response()->json([
                'authenticated' => false,
                'error_message' => 'Vos identifiants ne sont pas valide'
            ], 403);
        }
    }

    /**
     * test if user and password is ok return message
     * info for send email and send email
     *
     * @param User $user
     * @param [type] $password
     * @return JsonResponse
     */
    public function accessTokenVerified(User $user, $password): JsonResponse
    {
        if ($user && Hash::check($password, $user->password)) {
            $user->sendEmailVerificationNotification();
            return response()->json([
                'message' => "Un email vous a ete envoyé. Veuillez valider votre compte afin de terminer l'inscription",
                'authenticated' => false,
            ], 200);
        } else {
            return response()->json([
                'authenticated' => false,
                'error_message' => 'Les données saisies ne sont pas valide'
            ], 403);
        }
    }
}
