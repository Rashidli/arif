<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::ordered()->paginate(10);
        return view('admin.blog_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.blog_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_name' => 'required|string|max:255',
        ]);

        BlogCategory::create([
            'order' => $request->order ?? 0,
            'status' => $request->boolean('status', true),
            'show_on_home' => $request->boolean('show_on_home'),
            'home_order' => $request->home_order ?? 0,
            'az' => ['name' => $request->az_name, 'slug' => \Str::slug($request->az_name)],
            'en' => ['name' => $request->en_name, 'slug' => \Str::slug($request->en_name ?: $request->az_name)],
            'ru' => ['name' => $request->ru_name, 'slug' => \Str::slug($request->ru_name ?: $request->az_name)],
        ]);

        return redirect()->route('blog_categories.index')->with('message', 'Kateqoriya uğurla əlavə edildi');
    }

    public function edit(BlogCategory $blog_category)
    {
        return view('admin.blog_categories.edit', compact('blog_category'));
    }

    public function update(Request $request, BlogCategory $blog_category)
    {
        $request->validate([
            'az_name' => 'required|string|max:255',
        ]);

        $blog_category->update([
            'order' => $request->order ?? 0,
            'status' => $request->boolean('status'),
            'show_on_home' => $request->boolean('show_on_home'),
            'home_order' => $request->home_order ?? 0,
            'az' => ['name' => $request->az_name, 'slug' => \Str::slug($request->az_name)],
            'en' => ['name' => $request->en_name, 'slug' => \Str::slug($request->en_name ?: $request->az_name)],
            'ru' => ['name' => $request->ru_name, 'slug' => \Str::slug($request->ru_name ?: $request->az_name)],
        ]);

        return redirect()->back()->with('message', 'Kateqoriya uğurla yeniləndi');
    }

    public function destroy(BlogCategory $blog_category)
    {
        $blog_category->delete();
        return redirect()->route('blog_categories.index')->with('message', 'Kateqoriya uğurla silindi');
    }
}
