<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Log extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'transaction_id',
        'user_id',
    ];
}
