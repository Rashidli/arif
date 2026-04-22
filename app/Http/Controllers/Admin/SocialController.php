<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Social;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SocialController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:list-socials|create-socials|edit-socials|delete-socials', ['only' => ['index','show']]);
        $this->middleware('permission:create-socials', ['only' => ['create','store']]);
        $this->middleware('permission:edit-socials', ['only' => ['edit']]);
        $this->middleware('permission:delete-socials', ['only' => ['destroy']]);
    }
    public function index()
    {
        $socials = Social::paginate(10);
        return view('admin.socials.index', compact('socials'));
    }

    public function create()
    {
        return view('admin.socials.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'link' => 'required|url',
        ]);

        $iconPath = null;
        if($request->hasFile('icon')){
            $iconPath = $request->file('icon')->store('socials', 'public');
        }

        Social::create([
            'title' => $request->title,
            'icon' => $iconPath,
            'link' => $request->link,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('socials.index')->with('message', 'Sosial şəbəkə uğurla əlavə edildi');
    }

    public function show(Social $social)
    {
        //
    }

    public function edit(Social $social)
    {
        return view('admin.socials.edit', compact('social'));
    }


    public function update(Request $request, Social $social)
    {
        $request->validate([
            'title' => 'required',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
            'link' => 'required|url',
        ]);

        if($request->hasFile('icon')){
            if ($social->icon) {
                \Storage::disk('public')->delete($social->icon);
            }
            $social->icon = $request->file('icon')->store('socials', 'public');
        }

        $social->update([
            'title' => $request->title,
            'link' => $request->link,
            'is_active' => $request->is_active,
        ]);

        return redirect()->back()->with('message', 'Sosial şəbəkə uğurla yeniləndi');
    }

    public function destroy(Social $social)
    {
        $social->delete();
        return redirect()->route('socials.index')->with('message', 'Sosial şəbəkə uğurla silindi');
    }
}
