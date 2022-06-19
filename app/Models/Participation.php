<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participation extends Model
{
    use HasFactory;

    protected $fillable = [
        'participant_id',
        'status',
        'code',
        'type',
        'award'
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class, 'participation_id', 'id');
    }
}
