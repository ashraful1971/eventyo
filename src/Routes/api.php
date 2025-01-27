<?php

use App\Controllers\API\AttendeeController;
use App\Controllers\API\EventController;
use App\Core\Route;

Route::get('/api/events', [EventController::class, 'index']);
Route::get('/api/events/{id}', [EventController::class, 'show']);
Route::get('/api/events/{id}/attendees', [AttendeeController::class, 'index']);