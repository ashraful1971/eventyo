<?php

namespace App\Services;

use App\Core\Auth;
use App\Core\Validation;
use App\Models\User;
use Exception;

class AuthService {

    /**
     * Login by user credentials
     *
     * @param array $credentials
     * @return void
     */
    public static function login(array $credentials): void
    {
        self::validateLoginCredentials($credentials);
        self::attemptToLogin($credentials);
    }
    
    /**
     * Register by new user info
     *
     * @param array $credentials
     * @return void
     */
    public static function register(array $credentials): void
    {
        self::validateRegisterCredentials($credentials);
        self::attemptToRegister($credentials);
    }

    /**
     * Validate register credentials
     *
     * @param array $credentials
     * @return void
     */
    private static function validateRegisterCredentials(array $credentials): void
    {
        $validation = Validation::make($credentials, [
            'first_name' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'password'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }
    }

    /**
     * Try to register using the credentials
     *
     * @param array $credentials
     * @return void
     */
    private static function attemptToRegister(array $credentials): void
    {
        $credentials['password'] = password_hash($credentials['password'], PASSWORD_DEFAULT);

        if (User::find('email', $credentials['email'])) {
            throw new Exception('An account already exist with this email.');
        } else {
            User::create($credentials);
        }
    }

    /**
     * Validate login credentials
     *
     * @param array $credentials
     * @return void
     */
    private static function validateLoginCredentials(array $credentials): void
    {
        $validation = Validation::make($credentials, [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }
    }

    /**
     * Try to login using the credentials
     *
     * @param array $credentials
     * @return void
     */
    private static function attemptToLogin(array $credentials): void
    {
        $user = User::find('email', $credentials['email']);

        if (!$user || !password_verify($credentials['password'], $user?->password)) {
            throw new Exception('Invalid credentials!');
        }

        Auth::login($user);
    }
    
}