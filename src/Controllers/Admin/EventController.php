<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Enums\Operation;
use App\Core\Request;
use App\Core\Response;
use App\Core\Validation;
use App\Models\Event;
use Exception;

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
        $sort_by = ['id', 'desc'];
        $conditions = [['user_id', '=', $request->user->id]];

        if ($request->q && $request->q != '') {
            $conditions[] = ['name', 'like', $request->q];
        }
        
        if ($request->filter && $request->filter == 'upcoming') {
            $conditions[] = ['date', '>=', date('Y-m-d')];
        }

        if ($request->filter && $request->filter == 'past') {
            $conditions[] = ['date', '<', date('Y-m-d')];
        }

        if ($request->sort) {
            $new_sort_by = explode(':', $request->sort);

            if ($new_sort_by[0] == 'name' || $new_sort_by[0] == 'date') {
                $sort_by = $new_sort_by;
            }
        }

        $per_page = 10;
        $page = $request->page ?? 1;
        $offset = ($page - 1) * $per_page;
        $records_count = Event::findCount($conditions);

        $events = Event::findAll($conditions, Operation::AND, $offset, $per_page, $sort_by[0], $sort_by[1]);

        return Response::view('admin/events/index', [
            'page_title' => 'Events',
            'events' => $events,
            'current_page' => $page,
            'count' => $records_count,
            'per_page' => $per_page,
        ]);
    }

    /**
     * Resource create
     *
     * @param Request $request
     * @return mixed
     */
    public function create(Request $request): mixed
    {
        return Response::view('admin/events/create', ['page_title' => 'Create a Events']);
    }

    /**
     * Resource show
     *
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function show(Request $request, string $id): mixed
    {
        $event = Event::findOrFail('id', $id);

        return Response::view('show-event', [
            'page_title' => $event->name,
            'is_expired' => strtotime($event->date) < strtotime(date('Y-m-d')),
            'is_full' => $event->attendees_count >= $event->capacity,
            'event' => $event
        ]);
    }

    /**
     * Resource store
     *
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request): mixed
    {
        try {
            $request->user_id = $request->user->id;
            $this->validateRequestData($request->all());
            Event::create($request->all());

            flash_message('success', 'New event has been created!');
        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
        }

        return Response::redirect('/admin/events');
    }

    /**
     * Resource edit
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function edit(Request $request, $id): mixed
    {
        $event = Event::findOrFail('id', $id);
        if ($event->user_id != $request->user->id) {
            flash_message('error', 'You are not authorized to edit this event!');
            return Response::redirect('/admin/events');
        }

        $event = Event::findOrFail('id', $id);
        return Response::view('admin/events/edit', ['page_title' => 'Edit a Event', 'event' => $event]);
    }

    /**
     * Resource update
     *
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request, $id): mixed
    {
        $event = Event::findOrFail('id', $id);
        if ($event->user_id != $request->user->id) {
            flash_message('error', 'You are not authorized to update this event!');
            return Response::redirect('/admin/events');
        }

        try {
            $data = $request->all();
            $data['user_id'] = $request->user->id;
            $data['id'] = $id;

            $this->validateRequestData($data);

            Event::update($id, $data);

            flash_message('success', 'Event has been updated!');
        } catch (Exception $e) {
            flash_message('error', $e->getMessage());
        }

        return Response::redirect('/admin/events');
    }

    /**
     * Resource delete
     *
     * @param Request $request
     * @param int $id
     * @return mixed
     */
    public function destroy(Request $request, $id): mixed
    {
        Event::delete($id);
        flash_message('success', 'Event has been deleted!');
        return Response::redirect('/admin/events');
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
            'name' => ['required'],
            'date' => ['required'],
            'time' => ['required'],
            'location' => ['required'],
            'capacity' => ['required'],
        ]);

        if ($validation->failed()) {
            throw new Exception($validation->getMessage());
        }

        return $validation->validatedData();
    }
}
