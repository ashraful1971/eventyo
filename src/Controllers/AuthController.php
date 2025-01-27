<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Services\AuthService;
use Exception;

class AuthController
{

    /**
     * Get login page view
     *
     * @return Response
     */
    public function loginPage(): Response
    {
        return Response::view('login');
    }

    /**
     * Login the user
     *
     * @param Request $request
     * @return Response
     */
    public function handleLogin(Request $request): Response
    {
        try {
            AuthService::login($request->all());
            return Response::redirect('/admin/dashboard');
        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
            return Response::redirect('/login');
        }
    }

    /**
     * Get register page view
     *
     * @return Response
     */
    public function registerPage(): Response
    {
        return Response::view('register');
    }

    /**
     * Register new user
     *
     * @param Request $request
     * @return Response
     */
    public function handleRegister(Request $request): Response
    {
        try {
            $request->is_admin = false;

            AuthService::register($request->all());

            flash_message('success', 'Your account was created successfully!');

            return Response::redirect('/login');
        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
            return Response::redirect('/register');
        }
    }

    /**
     * Logout logged in user
     *
     * @param Request $request
     * @return Response
     */
    public function handleLogout(): Response
    {
        return Auth::logout();
    }
}
