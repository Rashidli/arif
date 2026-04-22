<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-abouts|create-abouts|edit-abouts|delete-abouts', ['only' => ['index','show']]);
        $this->middleware('permission:create-abouts', ['only' => ['create','store']]);
        $this->middleware('permission:edit-abouts', ['only' => ['edit']]);
        $this->middleware('permission:delete-abouts', ['only' => ['destroy']]);
    }

    public function index()
    {
        $about = About::first();
        if ($about) {
            return redirect()->route('abouts.edit', $about->id);
        }
        return redirect()->route('abouts.create');
    }

    public function create()
    {
        return view('admin.abouts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_title' => 'required',
            'en_title' => 'required',
            'ru_title' => 'required',
        ]);

        $data = [
            'key' => 'main',
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

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('abouts', 'public');
        }

        About::create($data);

        return redirect()->route('abouts.index')->with('message', 'Haqqımızda uğurla əlavə edildi');
    }

    public function show(About $about)
    {
        //
    }

    public function edit(About $about)
    {
        return view('admin.abouts.edit', compact('about'));
    }

    public function update(Request $request, About $about)
    {
        $request->validate([
            'az_title' => 'required',
            'en_title' => 'required',
            'ru_title' => 'required',
        ]);

        $data = [
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

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $data['image'] = $request->file('image')->store('abouts', 'public');
        }

        $about->update($data);

        return redirect()->back()->with('message', 'Haqqımızda uğurla yeniləndi');
    }

    public function destroy(About $about)
    {
        if ($about->image) {
            Storage::disk('public')->delete($about->image);
        }
        $about->delete();
        return redirect()->route('abouts.index')->with('message', 'Haqqımızda uğurla silindi');
    }
}
