<?php

namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table_name = 'users';
    protected $columns = ['first_name', 'last_name', 'email', 'password'];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getEventsAttribute(): array
    {
        return Event::findAll([
            ['user_id', '=', $this->id]
        ]);
    }
}
