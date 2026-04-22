<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
        $this->middleware('permission:list-blogs|create-blogs|edit-blogs|delete-blogs', ['only' => ['index','show']]);
        $this->middleware('permission:create-blogs', ['only' => ['create','store']]);
        $this->middleware('permission:edit-blogs', ['only' => ['edit']]);
        $this->middleware('permission:delete-blogs', ['only' => ['destroy']]);
    }

    function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Blog::whereTranslation('title', $title)->count();

        if ($count > 0) {
            $slug .= '-' . $count;
        }

        return $slug;
    }

    public function index(Request $request)
    {
        $query = Blog::with('category');

        // Search by title
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('translations', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Filter by featured
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'yes');
        }

        // Filter by slider
        if ($request->filled('slider')) {
            $query->where('is_slider', $request->slider === 'yes');
        }

        $blogs = $query->latest()->paginate(15)->withQueryString();
        $categories = BlogCategory::all();

        return view('admin.blogs.index', compact('blogs', 'categories'));
    }

    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_title'=>'required',
            'blog_category_id'=>'required|exists:blog_categories,id',
            'az_description'=>'required',
            'image'=>'required',
        ]);

        DB::beginTransaction();
        try {
            if($request->hasFile('image')){
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            Blog::create([
                'image'=> $filename,
                'blog_category_id'=> $request->blog_category_id,
                'is_active'=> $request->boolean('is_active', true),
                'is_featured'=> $request->boolean('is_featured'),
                'is_slider'=> $request->boolean('is_slider'),
                'slider_order'=> $request->slider_order ?? 0,
                'az'=>[
                    'title'=>$request->az_title,
                    'description'=>$request->az_description,
                    'short_description'=>$request->az_short_description,
                    'img_alt'=>$request->az_img_alt,
                    'img_title'=>$request->az_img_title,
                    'slug'=>$this->generateUniqueSlug($request->az_title),
                    'meta_title'=>$request->az_meta_title,
                    'meta_description'=>$request->az_meta_description,
                ],
                'en'=>[
                    'title'=>$request->en_title,
                    'description'=>$request->en_description,
                    'short_description'=>$request->en_short_description,
                    'img_alt'=>$request->en_img_alt,
                    'img_title'=>$request->en_img_title,
                    'slug'=>$this->generateUniqueSlug($request->en_title ?: $request->az_title),
                    'meta_title'=>$request->en_meta_title,
                    'meta_description'=>$request->en_meta_description,
                ],
                'ru'=>[
                    'title'=>$request->ru_title,
                    'description'=>$request->ru_description,
                    'short_description'=>$request->ru_short_description,
                    'img_alt'=>$request->ru_img_alt,
                    'img_title'=>$request->ru_img_title,
                    'slug'=>$this->generateUniqueSlug($request->ru_title ?: $request->az_title),
                    'meta_title'=>$request->ru_meta_title,
                    'meta_description'=>$request->ru_meta_description,
                ]
            ]);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }

        return redirect()->route('blogs.index')->with('message','Məqalə uğurla əlavə edildi');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::active()->ordered()->get();
        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'az_title'=>'required',
            'blog_category_id'=>'required|exists:blog_categories,id',
            'az_description'=>'required',
        ]);

        DB::beginTransaction();
        try {
            if($request->hasFile('image')){
                $blog->image = $this->imageUploadService->upload($request->file('image'));
            }

            $blog->update([
                'is_active'=> $request->boolean('is_active'),
                'is_featured'=> $request->boolean('is_featured'),
                'is_slider'=> $request->boolean('is_slider'),
                'slider_order'=> $request->slider_order ?? 0,
                'blog_category_id'=> $request->blog_category_id,
                'az'=>[
                    'title'=>$request->az_title,
                    'img_alt'=>$request->az_img_alt,
                    'img_title'=>$request->az_img_title,
                    'description'=>$request->az_description,
                    'short_description'=>$request->az_short_description,
                    'meta_title'=>$request->az_meta_title,
                    'meta_description'=>$request->az_meta_description,
                ],
                'en'=>[
                    'title'=>$request->en_title,
                    'img_alt'=>$request->en_img_alt,
                    'img_title'=>$request->en_img_title,
                    'description'=>$request->en_description,
                    'short_description'=>$request->en_short_description,
                    'meta_title'=>$request->en_meta_title,
                    'meta_description'=>$request->en_meta_description,
                ],
                'ru'=>[
                    'title'=>$request->ru_title,
                    'img_alt'=>$request->ru_img_alt,
                    'img_title'=>$request->ru_img_title,
                    'description'=>$request->ru_description,
                    'short_description'=>$request->ru_short_description,
                    'meta_title'=>$request->ru_meta_title,
                    'meta_description'=>$request->ru_meta_description,
                ]
            ]);

            DB::commit();
        }catch (\Exception $exception){
            DB::rollBack();
            return $exception->getMessage();
        }
        return redirect()->back()->with('message','Məqalə uğurla yeniləndi');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {

        $blog->delete();
        return redirect()->route('blogs.index')->with('message', 'Məqalə uğurla silindi');

    }

}
