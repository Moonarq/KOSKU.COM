<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'kos_id',
        'name',
        'rating',
        'comment',
        'images',
        'reply',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function kos()
    {
        return $this->belongsTo(Kos::class);
    }
}
