<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use SoftDeletes;
    // use softDelets trait so model can utilize softDelete methods
    protected $fillable = [
        'title', 'is_completed'
    ];
}
