<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'todos';
    public $fillable = ['name', 'is_done', 'completed_at', 'position'];
    protected $dates = ['deleted_at'];
}
