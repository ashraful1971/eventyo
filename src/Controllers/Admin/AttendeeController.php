<?php

namespace App\Controllers\Admin;

use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Models\Attendee;
use App\Models\Event;
use Exception;

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
        if ($event->user_id != $request->user->id) {
            flash_message('error', 'You are not authorized to view the attendees list!');
            return Response::redirect('/admin/events');
        }

        $conditions = [['event_id', '=', $id]];

        if ($request->q && $request->q != '') {
            $conditions[] = ['name', 'like', $request->q];
        }

        $per_page = 3;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $per_page;
        $records_count = Attendee::findCount($conditions);

        $attendees = Attendee::findAll($conditions, Operation::AND, $offset, $per_page);

        return Response::view('admin/events/attendees', [
            'page_title' => 'Attendees',
            'event_id' => $id,
            'attendees' => $attendees,
            'current_page' => $page,
            'count' => $records_count,
            'per_page' => $per_page,
        ]);
    }

    /**
     * Resource index
     *
     * @param Request $request
     * @return mixed
     */
    public function download(Request $request, $id): mixed
    {
        $event = Event::findOrFail('id', $id);
        if ($event->user_id != $request->user->id) {
            flash_message('error', 'You are not authorized to view the attendees list!');
            return Response::redirect('/admin/events');
        }

        $attendees = Attendee::findAll([
            ['event_id', '=', $id],
        ]);

        $event_slug = str_replace(' ', '_', strtolower($event->name));

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $event_slug . '_attendees.csv"');

        $output = fopen('php://output', 'w');

        fputcsv($output, ['Name', 'Phone', 'Email']);

        foreach ($attendees as $row) {
            fputcsv($output, [$row->name, $row->phone, $row->email]);
        }

        fclose($output);

        return null;
    }

    /**
     * Resource store
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request, $id): mixed
    {
        try {
            $event = Event::findOrFail('id', $id);

            if (strtotime($event->date) < strtotime(date('Y-m-d'))) {
                throw new Exception('Event has been expired!');
            }
            
            if ($event->attendees_count >= $event->capacity) {
                throw new Exception('Event has reached maximum capacity!');
            }

            $request->user_id = $request->user->id;
            $request->event_id = $id;

            $this->validateRequestData($request->all());
            Attendee::create($request->all());

            $event->attendees_count += 1;
            $event->save();

            return Response::json(['message' => 'Registration Successfull!']);
        } catch (Exception $e) {
            return Response::json(['message' => $e->getMessage()], 400);
        }

        return Response::redirect('/event/' . $id);
    }

    /**
     * Validate the request data
     *
     * @param array $data
     * @return mixed
     */
    private function validateRequestData(array $data): mixed
    {
        $validation = Validation::make($data, [
            'event_id' => ['required'],
            'name' => ['required'],
            'phone' => ['required'],
            'email' => ['required', 'email'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }

        return $validation->validatedData();
    }

    /**
     * Resource delete
     *
     * @param Request $request
     * @param int $event_id
     * @param int $id
     * @return mixed
     */
    public function destroy(Request $request, int $event_id, int $id): mixed
    {
        $event = Event::findOrFail('id', $event_id);
        if ($event->user_id != $request->user->id) {
            flash_message('error', 'You are not authorized to delete this attendee!');
            return Response::redirect('/admin/events/' . $event_id . '/attendees');
        }

        Attendee::delete($id);
        $event->attendees_count -= 1;
        $event->save();

        flash_message('success', 'Attendee has been deleted!');
        return Response::redirect('/admin/events/' . $event_id . '/attendees');
    }
}
