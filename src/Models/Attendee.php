<?php

namespace App\Models;

use App\Core\Model;

class Attendee extends Model {
    protected $table_name = 'attendees';
    protected $columns = ['event_id', 'name', 'phone', 'email'];

    public function getEventAttribute(): ?User
    {
        return Event::find('id', $this->event_id);
    }
}