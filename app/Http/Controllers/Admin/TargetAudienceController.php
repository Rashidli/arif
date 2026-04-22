<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TargetAudience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TargetAudienceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-target-audiences|create-target-audiences|edit-target-audiences|delete-target-audiences', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-target-audiences', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-target-audiences', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-target-audiences', ['only' => ['destroy']]);
    }

    public function index()
    {
        $audiences = TargetAudience::ordered()->paginate(10);
        return view('admin.target_audiences.index', compact('audiences'));
    }

    public function create()
    {
        return view('admin.target_audiences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'order' => $request->order ?? 0,
                'status' => $request->boolean('status', true),
                'az' => ['title' => $request->az_title],
                'en' => ['title' => $request->en_title],
                'ru' => ['title' => $request->ru_title],
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('target_audiences', 'public');
            }

            TargetAudience::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('target_audiences.index')->with('message', 'Hədəf auditoriyası uğurla əlavə edildi');
    }

    public function edit(TargetAudience $targetAudience)
    {
        return view('admin.target_audiences.edit', compact('targetAudience'));
    }

    public function update(Request $request, TargetAudience $targetAudience)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'order' => $request->order ?? 0,
                'status' => $request->boolean('status'),
                'az' => ['title' => $request->az_title],
                'en' => ['title' => $request->en_title],
                'ru' => ['title' => $request->ru_title],
            ];

            if ($request->hasFile('image')) {
                if ($targetAudience->image) {
                    Storage::disk('public')->delete($targetAudience->image);
                }
                $data['image'] = $request->file('image')->store('target_audiences', 'public');
            }

            $targetAudience->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Hədəf auditoriyası uğurla yeniləndi');
    }

    public function destroy(TargetAudience $targetAudience)
    {
        if ($targetAudience->image) {
            Storage::disk('public')->delete($targetAudience->image);
        }
        $targetAudience->delete();
        return redirect()->route('target_audiences.index')->with('message', 'Hədəf auditoriyası uğurla silindi');
    }
}
