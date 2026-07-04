<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomTypeFacility extends Model
{
    protected $fillable = [
        'room_type_id',
        'name',
        'icon',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}
