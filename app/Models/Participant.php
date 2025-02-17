<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $table = 'participants';
    protected $primaryKey = 'participant_id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'username',
        'participant_role',
        'division',
        'school',
        'event',
        'password',
        'is_deleted',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'participant_id', 'participant_id');
    }
}