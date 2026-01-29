<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Apartment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'price',
        'contact_person',
        'address',
        'description',
        'facilities',
        'rules',
        'image',
        'gender',
        'type',
        'room_size',
    ];

    protected $casts = [
        'facilities' => 'array',
        'image' => 'array',
        'price' => 'decimal:2',
    ];

    public function getGenderLabelAttribute(): string
    {
        return match ($this->gender) {
            'male' => 'Laki-laki',
            'female' => 'Perempuan',
            'mixed' => 'Campuran',
            default => 'Apartment',
        };
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
