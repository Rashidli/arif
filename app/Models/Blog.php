<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory, Translatable, SoftDeletes;

    public $translatedAttributes = [
        'title', 'short_description', 'description', 'slug',
        'img_alt', 'img_title', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    protected $fillable = ['blog_category_id', 'image', 'youtube_video', 'is_active', 'is_featured', 'is_slider', 'slider_order', 'view'];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_slider' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSlider($query)
    {
        return $query->where('is_slider', true)->orderBy('slider_order');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'blog_category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function incrementView()
    {
        $this->increment('view');
    }

    public function getViewsAttribute()
    {
        return $this->view ?? 0;
    }
}
