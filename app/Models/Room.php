<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type_id',
        'room_Number',
        'room_number',
        'image',
        'description',
        'wifi',
        'type',
        'price',
        'status',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order');
    }

    public function getRoomNumberAttribute()
    {
        return $this->attributes['room_Number'] ?? null;
    }

    public function setRoomNumberAttribute($value)
    {
        $this->attributes['room_Number'] = $value;
    }
}
