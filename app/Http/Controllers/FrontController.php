<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Contact;
use App\Models\ContactItem;
use App\Models\Image;
use App\Models\Single;
use App\Models\Social;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    /**
     * Homepage
     */
    public function home()
    {
        $seo = Single::where('type', 'home')->first();

        // Hero slider blogs
        $sliderBlogs = Blog::with('category')
            ->active()
            ->slider()
            ->take(5)
            ->get();

        // Featured blog (only show if no slider blogs)
        $featuredBlog = $sliderBlogs->isEmpty()
            ? Blog::with('category')->active()->featured()->latest()->first()
            : null;

        // Categories with blogs for homepage sections
        $homeCategories = BlogCategory::with(['blogs' => function($query) {
            $query->active()->latest()->take(12);
        }])
            ->active()
            ->showOnHome()
            ->get();

        return view('front.home', compact('seo', 'sliderBlogs', 'featuredBlog', 'homeCategories'));
    }

    /**
     * Blog listing
     */
    public function blogs(Request $request)
    {
        $seo = Single::where('type', 'blogs')->first();

        $query = Blog::with(['category', 'tags'])->active();

        // Category filter
        if ($request->category) {
            $query->where('blog_category_id', $request->category);
        }

        // Tag filter
        if ($request->tag) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->whereHas('translations', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $blogs = $query->latest()->paginate(9)->withQueryString();

        // Get all categories and tags for filters
        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::has('blogs')->get();

        $currentCategory = $request->category
            ? BlogCategory::find($request->category)
            : null;

        $currentTag = $request->tag
            ? Tag::find($request->tag)
            : null;

        return view('front.blogs', compact('seo', 'blogs', 'categories', 'tags', 'currentCategory', 'currentTag'));
    }

    /**
     * Blogs by category (SEO-friendly URL)
     */
    public function blogsByCategory($categorySlug)
    {
        $seo = Single::where('type', 'blogs')->first();

        $currentCategory = BlogCategory::active()
            ->whereHas('translations', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })
            ->firstOrFail();

        $blogs = Blog::with(['category', 'tags'])
            ->active()
            ->where('blog_category_id', $currentCategory->id)
            ->latest()
            ->paginate(9);

        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::active()->has('blogs')->get();
        $currentTag = null;

        // Alternate URLs for language switching
        $alternateUrls = [];
        $defaultLocale = config('app.locale', 'az');
        foreach (['az', 'en', 'ru'] as $locale) {
            $translation = $currentCategory->translate($locale);
            if ($translation && $translation->slug) {
                $prefix = ($locale === $defaultLocale) ? '' : '/' . $locale;
                $alternateUrls[$locale] = url($prefix . '/blog/c/' . $translation->slug);
            }
        }

        return view('front.blogs', compact('seo', 'blogs', 'categories', 'tags', 'currentCategory', 'currentTag', 'alternateUrls'));
    }

    /**
     * Blogs by tag (SEO-friendly URL)
     */
    public function blogsByTag($tagSlug)
    {
        $seo = Single::where('type', 'blogs')->first();

        $currentTag = Tag::active()
            ->whereHas('translations', function($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            })
            ->firstOrFail();

        $blogs = Blog::with(['category', 'tags'])
            ->active()
            ->whereHas('tags', function($q) use ($currentTag) {
                $q->where('tags.id', $currentTag->id);
            })
            ->latest()
            ->paginate(9);

        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::active()->has('blogs')->get();
        $currentCategory = null;

        // Alternate URLs for language switching
        $alternateUrls = [];
        $defaultLocale = config('app.locale', 'az');
        foreach (['az', 'en', 'ru'] as $locale) {
            $translation = $currentTag->translate($locale);
            if ($translation && $translation->slug) {
                $prefix = ($locale === $defaultLocale) ? '' : '/' . $locale;
                $alternateUrls[$locale] = url($prefix . '/blog/t/' . $translation->slug);
            }
        }

        return view('front.blogs', compact('seo', 'blogs', 'categories', 'tags', 'currentCategory', 'currentTag', 'alternateUrls'));
    }

    /**
     * Blogs by category and tag (SEO-friendly URL)
     */
    public function blogsByCategoryAndTag($categorySlug, $tagSlug)
    {
        $seo = Single::where('type', 'blogs')->first();

        $currentCategory = BlogCategory::active()
            ->whereHas('translations', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            })
            ->firstOrFail();

        $currentTag = Tag::active()
            ->whereHas('translations', function($q) use ($tagSlug) {
                $q->where('slug', $tagSlug);
            })
            ->firstOrFail();

        $blogs = Blog::with(['category', 'tags'])
            ->active()
            ->where('blog_category_id', $currentCategory->id)
            ->whereHas('tags', function($q) use ($currentTag) {
                $q->where('tags.id', $currentTag->id);
            })
            ->latest()
            ->paginate(9);

        $categories = BlogCategory::active()->ordered()->get();
        $tags = Tag::active()->has('blogs')->get();

        // Alternate URLs for language switching
        $alternateUrls = [];
        $defaultLocale = config('app.locale', 'az');
        foreach (['az', 'en', 'ru'] as $locale) {
            $catTrans = $currentCategory->translate($locale);
            $tagTrans = $currentTag->translate($locale);
            if ($catTrans && $catTrans->slug && $tagTrans && $tagTrans->slug) {
                $prefix = ($locale === $defaultLocale) ? '' : '/' . $locale;
                $alternateUrls[$locale] = url($prefix . '/blog/c/' . $catTrans->slug . '/t/' . $tagTrans->slug);
            }
        }

        return view('front.blogs', compact('seo', 'blogs', 'categories', 'tags', 'currentCategory', 'currentTag', 'alternateUrls'));
    }

    /**
     * Blog detail
     */
    public function blogDetail($slug)
    {
        $blog = Blog::with(['category', 'tags'])
            ->active()
            ->whereHas('translations', function($q) use ($slug) {
                $q->where('slug', $slug);
            })
            ->firstOrFail();

        // Increment view count
        $blog->incrementView();

        // Most read blogs for sidebar
        $mostReadBlogs = Blog::with('category')
            ->active()
            ->where('id', '!=', $blog->id)
            ->orderByDesc('view')
            ->take(3)
            ->get();

        // Related blogs (same category) for bottom section
        $relatedBlogs = Blog::with('category')
            ->active()
            ->where('id', '!=', $blog->id)
            ->where('blog_category_id', $blog->blog_category_id)
            ->latest()
            ->take(12)
            ->get();

        // Alternate URLs for language switching
        $alternateUrls = [];
        $defaultLocale = config('app.locale', 'az');
        foreach (['az', 'en', 'ru'] as $locale) {
            $translation = $blog->translate($locale);
            if ($translation && $translation->slug) {
                $prefix = ($locale === $defaultLocale) ? '' : '/' . $locale;
                $alternateUrls[$locale] = url($prefix . '/blog/' . $translation->slug);
            }
        }

        return view('front.blog-detail', compact('blog', 'mostReadBlogs', 'relatedBlogs', 'alternateUrls'));
    }

    /**
     * Contact page
     */
    public function contact()
    {
        $seo = Single::where('type', 'contact')->first();
        $contactItems = ContactItem::ordered()->get();

        return view('front.contact', compact('seo', 'contactItems'));
    }

    /**
     * Contact form submit
     */
    public function contactSubmit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Contact::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return redirect()->back()->with('success', word('contact_success', 'Mesajınız uğurla göndərildi!'));
    }
}
