<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'order_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_tasks', 'task_id', 'user_id');
    }
}
