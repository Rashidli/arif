<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    public function __construct(protected ImageUploadService $imageUploadService)
    {
    }

    public function index()
    {
        $reviews = Review::latest()->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function create()
    {
        return view('admin.reviews.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_name' => 'required',
            'az_content' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $filename = null;
            if ($request->hasFile('image')) {
                $filename = $this->imageUploadService->upload($request->file('image'));
            }

            Review::create([
                'image' => $filename,
                'rating' => $request->rating ?? 5,
                'is_active' => $request->boolean('is_active', true),
                'order' => $request->order ?? 0,
                'az' => [
                    'name' => $request->az_name,
                    'position' => $request->az_position,
                    'content' => $request->az_content,
                ],
                'en' => [
                    'name' => $request->en_name,
                    'position' => $request->en_position,
                    'content' => $request->en_content,
                ],
                'ru' => [
                    'name' => $request->ru_name,
                    'position' => $request->ru_position,
                    'content' => $request->ru_content,
                ],
            ]);

            DB::commit();
            return redirect()->route('reviews.index')->with('message', 'Rəy uğurla əlavə edildi');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Review $review)
    {
        return view('admin.reviews.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $request->validate([
            'az_name' => 'required',
            'az_content' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $review->image = $this->imageUploadService->upload($request->file('image'));
            }

            $review->update([
                'rating' => $request->rating ?? 5,
                'is_active' => $request->boolean('is_active'),
                'order' => $request->order ?? 0,
                'az' => [
                    'name' => $request->az_name,
                    'position' => $request->az_position,
                    'content' => $request->az_content,
                ],
                'en' => [
                    'name' => $request->en_name,
                    'position' => $request->en_position,
                    'content' => $request->en_content,
                ],
                'ru' => [
                    'name' => $request->ru_name,
                    'position' => $request->ru_position,
                    'content' => $request->ru_content,
                ],
            ]);

            DB::commit();
            return redirect()->back()->with('message', 'Rəy uğurla yeniləndi');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('reviews.index')->with('message', 'Rəy uğurla silindi');
    }
}
