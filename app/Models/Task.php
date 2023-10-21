<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'isPublic',
        'todolist_id',
    ];

    public function steps()
    {
        return $this->hasMany(Step::class);
    }

    public function sharedUsers()
    {
        return $this->belongsToMany(User::class, 'user_tasks');
    }
}
