<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'degree',
        'institute',
        'location',
        'start_year',
        'end_year',
        'description',
        'responsibilities',
        'skills'
    ];

    // Automatically cast responsibilities and skills to arrays
    protected $casts = [
        'responsibilities' => 'array',
        'skills' => 'array',
    ];

    public function resume() {
        return $this->belongsTo(Resume::class);
    }
}
