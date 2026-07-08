<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoomType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'category',
        'room_number',
        'description',
        'short_description',
        'price_per_night',
        'discount_price',
        'room_size',
        'bed_type',
        'capacity_adults',
        'capacity_children',
        'total_rooms',
        'available_rooms',
        'status',
        'is_active',
    ];

    protected $casts = [
        'price_per_night' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public const CATEGORIES = [
        'single' => 'Single Room',
        'double' => 'Double Room',
        'family' => 'Family Room',
    ];

    protected static function booted(): void
    {
        static::creating(function (RoomType $roomType) {
            if (empty($roomType->slug)) {
                $base = Str::slug(trim(($roomType->name ?? 'room') . '-' . ($roomType->room_number ?? '')));
                $roomType->slug = $base ?: Str::slug($roomType->name ?? 'room');
            }
        });
    }

    public function scopeCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? ucfirst($this->category);
    }

    public function images()
    {
        return $this->hasMany(RoomTypeImage::class)->orderBy('sort_order');
    }

    public function facilities()
    {
        return $this->hasMany(RoomTypeFacility::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getPrimaryImageAttribute(): ?string
    {
        return $this->images->first()?->image_path;
    }

    public function getDisplayPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price_per_night);
    }

    public function getCapacityLabelAttribute(): string
    {
        $label = $this->capacity_adults . ' Adult' . ($this->capacity_adults > 1 ? 's' : '');

        if ($this->capacity_children > 0) {
            $label .= ' + ' . $this->capacity_children . ' Child' . ($this->capacity_children > 1 ? 'ren' : '');
        }

        return $label;
    }

    public function availableUnitsForDates(string $checkIn, string $checkOut): int
    {
        $booked = $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '<', $checkOut)
            ->where('check_out', '>', $checkIn)
            ->sum('rooms_count');

        return max(0, $this->total_rooms - (int) $booked);
    }
    
    public function getIsCurrentlyBookedAttribute(): bool
    {
        if ($this->status !== 'available') {
            return true;
        }

        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');
        return $this->availableUnitsForDates($today, $tomorrow) <= 0;
    }
}
