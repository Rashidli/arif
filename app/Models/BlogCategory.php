<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model implements TranslatableContract
{
    use HasFactory, Translatable;

    protected $fillable = ['order', 'status', 'show_on_home', 'home_order'];

    public $translatedAttributes = ['name', 'slug'];

    protected $casts = [
        'status' => 'boolean',
        'show_on_home' => 'boolean',
    ];

    public function blogs()
    {
        return $this->hasMany(Blog::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->latest();
    }

    public function scopeShowOnHome($query)
    {
        return $query->where('show_on_home', true)->orderBy('home_order');
    }
}
