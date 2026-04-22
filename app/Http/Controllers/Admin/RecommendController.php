<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RecommendController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit-sections');
    }

    // Hero Section
    public function heroEdit()
    {
        $section = Section::where('type', 'recommend_us_hero')->first();
        return view('admin.recommend.hero', compact('section'));
    }

    public function heroUpdate(Request $request)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $section = Section::where('type', 'recommend_us_hero')->first();

            if (!$section) {
                $section = new Section();
                $section->type = 'recommend_us_hero';
            }

            $section->status = $request->boolean('status', true);

            if ($request->hasFile('image')) {
                if ($section->image) {
                    Storage::disk('public')->delete($section->image);
                }
                $section->image = $request->file('image')->store('recommend', 'public');
            }

            $section->save();

            foreach (['az', 'en', 'ru'] as $lang) {
                $section->translateOrNew($lang)->title = $request->input("{$lang}_title");
                $section->translateOrNew($lang)->subtitle = $request->input("{$lang}_subtitle");
                $section->translateOrNew($lang)->description = $request->input("{$lang}_description");
            }
            $section->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Məlumat uğurla yeniləndi');
    }

    // Reviews Section Title
    public function reviewsEdit()
    {
        $section = Section::where('type', 'recommend_us_reviews')->first();
        return view('admin.recommend.reviews', compact('section'));
    }

    public function reviewsUpdate(Request $request)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $section = Section::where('type', 'recommend_us_reviews')->first();

            if (!$section) {
                $section = new Section();
                $section->type = 'recommend_us_reviews';
            }

            $section->status = $request->boolean('status', true);
            $section->save();

            foreach (['az', 'en', 'ru'] as $lang) {
                $section->translateOrNew($lang)->title = $request->input("{$lang}_title");
            }
            $section->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Məlumat uğurla yeniləndi');
    }
}
