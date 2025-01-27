<?php

use App\Controllers\AuthController;
use App\Controllers\Admin\AttendeeController;
use App\Controllers\Admin\DashboardController;
use App\Controllers\Admin\EventController;
use App\Controllers\PageController;
use App\Core\Route;
use App\Middlewares\Authentication;
use App\Middlewares\Guest;

Route::get('/', [PageController::class, 'index']);
Route::get('/404', [PageController::class, 'pageNotFound']);

Route::get('/admin/dashboard', [DashboardController::class, 'index'], [Authentication::class]);

Route::get('/admin/events', [EventController::class, 'index'], [Authentication::class]);
Route::get('/admin/events/create', [EventController::class, 'create'], [Authentication::class]);
Route::post('/admin/events', [EventController::class, 'store'], [Authentication::class]);
Route::get('/admin/events/{id}/edit', [EventController::class, 'edit'], [Authentication::class]);
Route::put('/admin/events/{id}', [EventController::class, 'update'], [Authentication::class]);
Route::delete('/admin/events/{id}', [EventController::class, 'destroy'], [Authentication::class]);
Route::get('/admin/events/{id}/attendees', [AttendeeController::class, 'index', [Authentication::class]]);
Route::get('/admin/events/{id}/attendees/download', [AttendeeController::class, 'download', [Authentication::class]]);
Route::delete('/admin/events/{event_id}/attendees/{id}', [AttendeeController::class, 'destroy', [Authentication::class]]);

Route::get('/event/{id}', [EventController::class, 'show']);
Route::post('/event/{id}/attendees', [AttendeeController::class, 'store']);

Route::get('/login', [AuthController::class, 'loginPage'], [Guest::class]);
Route::post('/login', [AuthController::class, 'handleLogin'], [Guest::class]);
Route::get('/register', [AuthController::class, 'registerPage'], [Guest::class]);
Route::post('/register', [AuthController::class, 'handleRegister'], [Guest::class]);
Route::get('/logout', [AuthController::class, 'handleLogout', [Authentication::class]]);