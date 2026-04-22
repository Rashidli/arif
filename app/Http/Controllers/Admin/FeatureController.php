<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FeatureController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-features|create-features|edit-features|delete-features', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-features', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-features', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-features', ['only' => ['destroy']]);
    }

    public function index()
    {
        $features = Feature::ordered()->paginate(10);
        return view('admin.features.index', compact('features'));
    }

    public function create()
    {
        return view('admin.features.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
            'ru_name' => 'required|string|max:255',
            'az_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'ru_description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'order' => $request->order ?? 0,
                'status' => $request->boolean('status', true),
                'az' => [
                    'name' => $request->az_name,
                    'description' => $request->az_description,
                ],
                'en' => [
                    'name' => $request->en_name,
                    'description' => $request->en_description,
                ],
                'ru' => [
                    'name' => $request->ru_name,
                    'description' => $request->ru_description,
                ],
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('features', 'public');
            }

            Feature::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('features.index')->with('message', 'Xüsusiyyət uğurla əlavə edildi');
    }

    public function edit(Feature $feature)
    {
        return view('admin.features.edit', compact('feature'));
    }

    public function update(Request $request, Feature $feature)
    {
        $request->validate([
            'az_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
            'ru_name' => 'required|string|max:255',
            'az_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'ru_description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'order' => $request->order ?? 0,
                'status' => $request->boolean('status'),
                'az' => [
                    'name' => $request->az_name,
                    'description' => $request->az_description,
                ],
                'en' => [
                    'name' => $request->en_name,
                    'description' => $request->en_description,
                ],
                'ru' => [
                    'name' => $request->ru_name,
                    'description' => $request->ru_description,
                ],
            ];

            if ($request->hasFile('image')) {
                if ($feature->image) {
                    Storage::disk('public')->delete($feature->image);
                }
                $data['image'] = $request->file('image')->store('features', 'public');
            }

            $feature->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Xüsusiyyət uğurla yeniləndi');
    }

    public function destroy(Feature $feature)
    {
        if ($feature->image) {
            Storage::disk('public')->delete($feature->image);
        }
        $feature->delete();
        return redirect()->route('features.index')->with('message', 'Xüsusiyyət uğurla silindi');
    }
}
