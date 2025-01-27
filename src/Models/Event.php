<?php

namespace App\Models;

use App\Core\Model;

class Event extends Model {
    protected $table_name = 'events';
    protected $columns = ['user_id', 'name', 'description', 'date', 'time', 'location', 'attendees_count', 'capacity'];

    public function getUserAttribute(): ?User
    {
        return User::find('id', $this->user_id);
    }
}