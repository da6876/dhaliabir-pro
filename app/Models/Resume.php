<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = ['title','description'];

    public function educations() {
        return $this->hasMany(Education::class);
    }

    public function experiences() {
        return $this->hasMany(Experience::class);
    }

    public function summaries() {
        return $this->hasMany(Summary::class);
    }
}
