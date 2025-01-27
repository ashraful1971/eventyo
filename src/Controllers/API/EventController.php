<?php

namespace App\Controllers\API;;

use App\Core\Request;
use App\Core\Response;
use App\Models\Attendee;
use App\Models\Event;

class EventController
{

    /**
     * Resource index
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request): mixed
    {
        $events = Event::findAllRaw([['user_id', '=', $request->user->id]]);

        return Response::json($events);
    }
    
    /**
     * Resource show
     *
     * @param Request $request
     * @return mixed
     */
    public function show(Request $request, $id): mixed
    {
        $event = Event::findRaw('id', $id);
        if (!$event) {
            return Response::json(['message' => 'Event not found'], 404);
        }

        $event['attendees'] = Attendee::findAllRaw([
            ['event_id', '=', $id],
        ]);

        return Response::json($event);
    }
}
