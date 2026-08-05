<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'description',
        'location',
        'year',
        'client_name',
        'budget',
        'image',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }
}
