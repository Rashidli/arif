<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TargetAudience;
use App\Models\TargetItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-target-audiences|create-target-audiences|edit-target-audiences|delete-target-audiences', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-target-audiences', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-target-audiences', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-target-audiences', ['only' => ['destroy']]);
    }

    public function index(TargetAudience $targetAudience)
    {
        $items = $targetAudience->items()->paginate(10);
        return view('admin.target_items.index', compact('targetAudience', 'items'));
    }

    public function create(TargetAudience $targetAudience)
    {
        return view('admin.target_items.create', compact('targetAudience'));
    }

    public function store(Request $request, TargetAudience $targetAudience)
    {
        $request->validate([
            'az_text' => 'required|string',
            'en_text' => 'required|string',
            'ru_text' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $targetAudience->items()->create([
                'order' => $request->order ?? 0,
                'status' => $request->boolean('status', true),
                'az' => ['text' => $request->az_text],
                'en' => ['text' => $request->en_text],
                'ru' => ['text' => $request->ru_text],
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('target_items.index', $targetAudience->id)->with('message', 'Element uğurla əlavə edildi');
    }

    public function edit(TargetAudience $targetAudience, TargetItem $targetItem)
    {
        return view('admin.target_items.edit', compact('targetAudience', 'targetItem'));
    }

    public function update(Request $request, TargetAudience $targetAudience, TargetItem $targetItem)
    {
        $request->validate([
            'az_text' => 'required|string',
            'en_text' => 'required|string',
            'ru_text' => 'required|string',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $targetItem->update([
                'order' => $request->order ?? 0,
                'status' => $request->boolean('status'),
                'az' => ['text' => $request->az_text],
                'en' => ['text' => $request->en_text],
                'ru' => ['text' => $request->ru_text],
            ]);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Element uğurla yeniləndi');
    }

    public function destroy(TargetAudience $targetAudience, TargetItem $targetItem)
    {
        $targetItem->delete();
        return redirect()->route('target_items.index', $targetAudience->id)->with('message', 'Element uğurla silindi');
    }
}
