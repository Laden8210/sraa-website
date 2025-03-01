<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventResult extends Model
{
    use HasFactory;

    protected $table = 'event_results';

    protected $primaryKey = 'result_id'; 

    public $timestamps = true; 

    protected $fillable = [
        'event_name',
        'medal_type',
        'winner_name',
        'division',
    ];
}
