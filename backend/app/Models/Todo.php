<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $table = 'todos';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class, 'user_id', 'id');
    }
}
