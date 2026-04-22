<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model implements TranslatableContract
{
    use HasFactory, Translatable, SoftDeletes;

    public $translatedAttributes = ['title', 'slug'];
    protected $fillable = ['is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }

    // Accessor for backward compatibility - views use 'name' but DB has 'title'
    public function getNameAttribute()
    {
        return $this->title;
    }
}
