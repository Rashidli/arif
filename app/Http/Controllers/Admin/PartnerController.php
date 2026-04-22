<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-partners|create-partners|edit-partners|delete-partners', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-partners', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-partners', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-partners', ['only' => ['destroy']]);
    }

    public function index()
    {
        $partners = Partner::ordered()->paginate(10);
        return view('admin.partners.index', compact('partners'));
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'name' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'name' => $request->name,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'status' => $request->boolean('status', true),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('partners', 'public');
        }

        Partner::create($data);

        return redirect()->route('partners.index')->with('message', 'Partner uğurla əlavə edildi');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'name' => 'nullable|string|max:255',
            'link' => 'nullable|url|max:255',
            'order' => 'nullable|integer',
        ]);

        $data = [
            'name' => $request->name,
            'link' => $request->link,
            'order' => $request->order ?? 0,
            'status' => $request->boolean('status'),
        ];

        if ($request->hasFile('image')) {
            if ($partner->image) {
                Storage::disk('public')->delete($partner->image);
            }
            $data['image'] = $request->file('image')->store('partners', 'public');
        }

        $partner->update($data);

        return redirect()->back()->with('message', 'Partner uğurla yeniləndi');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->image) {
            Storage::disk('public')->delete($partner->image);
        }
        $partner->delete();
        return redirect()->route('partners.index')->with('message', 'Partner uğurla silindi');
    }
}
