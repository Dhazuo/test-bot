<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'state',
        'phone',
        'image',
        'email',
        'stage',
        'sub_stage'
    ];

    public function participations()
    {
        return $this->hasMany(Participation::class, 'participant_id', 'id');
    }
}
