<?php

namespace App\Controllers\API;;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Models\Attendee;
use App\Models\Event;

class AttendeeController
{

    /**
     * Resource index
     *
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request, $id): mixed
    {
        $event = Event::findOrFail('id', $id);
        if (!$event) {
            return Response::json(['message' => 'Event not found'], 404);
        }

        $attendees = Attendee::findAllRaw([
            ['event_id', '=', $id],
        ]);

        return Response::json($attendees);
    }
}
