<?php

namespace App\Controllers\Admin;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Models\Event;

class DashboardController
{
    
    /**
     * Get dashboard page view
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $events = Event::findAll([
            ['user_id', '=', $request->user->id],
        ], Operation::AND, 0, 5);

        return Response::view('admin/dashboard', [
            'page_title' => "Howdy, ".authUser()->fullname." 👋",
            'events' => array_reverse($events),
        ]);
    }
    
}
