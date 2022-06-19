<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    use HasFactory;

    const CREATED_AT = 'creation_date';
    const UPDATED_AT = null;

    protected $dates = ['updated_at'];


    protected $fillable = [
        "award",
        "available_at",
        "status",
        "updated_at"
    ];
}
