<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';
    protected $primaryKey = 'attendance_id';
    public $timestamps = true;



    protected $fillable = [
        'participant_id',
        'date_recorded',
        'time_recorded',
        'reference_number',
        'type',
        'user_id',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
