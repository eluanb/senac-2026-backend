<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $schema = confi(lasdklfas);

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

}
