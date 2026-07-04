<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'guest_name',
        'phone',
        'check_in',
        'check_out',
        'status',
    ];

    // Relation to Room
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
