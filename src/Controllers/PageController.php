<?php

namespace App\Controllers;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Models\Event;

class PageController
{
    /**
     * Get home page view
     *
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $per_page = 10;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $per_page;
        $records_count = Event::findCount();

        $events = Event::findAll([], Operation::AND, $offset, $per_page, 'id', 'desc');

        return Response::view('home', [
            'page_title' => 'Eventyo - Discover and Manage Events',
            'events' => $events,
            'current_page' => $page,
            'count' => $records_count,
            'per_page' => $per_page,
        ]);
    }

    /**
     * Get 404 page view
     *
     * @return mixed
     */
    public function pageNotFound(): mixed
    {
        return Response::view('404');
    }
}
