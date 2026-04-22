<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SupportItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-support_items|create-support_items|edit-support_items|delete-support_items', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-support_items', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-support_items', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-support_items', ['only' => ['destroy']]);
    }

    public function index()
    {
        $supportItems = SupportItem::ordered()->paginate(10);
        return view('admin.support_items.index', compact('supportItems'));
    }

    public function create()
    {
        return view('admin.support_items.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'status' => $request->boolean('status', true),
                'az' => [
                    'title' => $request->az_title,
                    'description' => $request->az_description,
                ],
                'en' => [
                    'title' => $request->en_title,
                    'description' => $request->en_description,
                ],
                'ru' => [
                    'title' => $request->ru_title,
                    'description' => $request->ru_description,
                ],
            ];

            if ($request->hasFile('icon')) {
                $data['icon'] = $request->file('icon')->store('support_items', 'public');
            }

            SupportItem::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('support_items.index')->with('message', 'Dəstək elementi uğurla əlavə edildi');
    }

    public function edit(SupportItem $supportItem)
    {
        return view('admin.support_items.edit', compact('supportItem'));
    }

    public function update(Request $request, SupportItem $supportItem)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'status' => $request->boolean('status'),
                'az' => [
                    'title' => $request->az_title,
                    'description' => $request->az_description,
                ],
                'en' => [
                    'title' => $request->en_title,
                    'description' => $request->en_description,
                ],
                'ru' => [
                    'title' => $request->ru_title,
                    'description' => $request->ru_description,
                ],
            ];

            if ($request->hasFile('icon')) {
                if ($supportItem->icon) {
                    Storage::disk('public')->delete($supportItem->icon);
                }
                $data['icon'] = $request->file('icon')->store('support_items', 'public');
            }

            $supportItem->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Dəstək elementi uğurla yeniləndi');
    }

    public function destroy(SupportItem $supportItem)
    {
        if ($supportItem->icon) {
            Storage::disk('public')->delete($supportItem->icon);
        }
        $supportItem->delete();
        return redirect()->route('support_items.index')->with('message', 'Dəstək elementi uğurla silindi');
    }
}
