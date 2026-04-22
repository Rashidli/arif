<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-sections|create-sections|edit-sections|delete-sections', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-sections', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-sections', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-sections', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sections = Section::paginate(10);
        return view('admin.sections.index', compact('sections'));
    }

    public function create()
    {
        return view('admin.sections.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:50|unique:sections,type',
            'az_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'az_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'ru_description' => 'nullable|string',
            'az_button_text' => 'nullable|string|max:100',
            'en_button_text' => 'nullable|string|max:100',
            'ru_button_text' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'type' => $request->type,
                'status' => $request->boolean('status', true),
                'az' => [
                    'title' => $request->az_title,
                    'subtitle' => $request->az_subtitle,
                    'description' => $request->az_description,
                    'button_text' => $request->az_button_text,
                ],
                'en' => [
                    'title' => $request->en_title,
                    'subtitle' => $request->en_subtitle,
                    'description' => $request->en_description,
                    'button_text' => $request->en_button_text,
                ],
                'ru' => [
                    'title' => $request->ru_title,
                    'subtitle' => $request->ru_subtitle,
                    'description' => $request->ru_description,
                    'button_text' => $request->ru_button_text,
                ],
            ];

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('sections', 'public');
            }

            Section::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('sections.index')->with('message', 'Bölmə uğurla əlavə edildi');
    }

    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function update(Request $request, Section $section)
    {
        $request->validate([
            'type' => 'required|string|max:50|unique:sections,type,' . $section->id,
            'az_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'az_description' => 'nullable|string',
            'en_description' => 'nullable|string',
            'ru_description' => 'nullable|string',
            'az_button_text' => 'nullable|string|max:100',
            'en_button_text' => 'nullable|string|max:100',
            'ru_button_text' => 'nullable|string|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'type' => $request->type,
                'status' => $request->boolean('status'),
                'az' => [
                    'title' => $request->az_title,
                    'subtitle' => $request->az_subtitle,
                    'description' => $request->az_description,
                    'button_text' => $request->az_button_text,
                ],
                'en' => [
                    'title' => $request->en_title,
                    'subtitle' => $request->en_subtitle,
                    'description' => $request->en_description,
                    'button_text' => $request->en_button_text,
                ],
                'ru' => [
                    'title' => $request->ru_title,
                    'subtitle' => $request->ru_subtitle,
                    'description' => $request->ru_description,
                    'button_text' => $request->ru_button_text,
                ],
            ];

            if ($request->hasFile('image')) {
                if ($section->image) {
                    Storage::disk('public')->delete($section->image);
                }
                $data['image'] = $request->file('image')->store('sections', 'public');
            }

            if ($request->hasFile('banner_image')) {
                if ($section->banner_image) {
                    Storage::disk('public')->delete($section->banner_image);
                }
                $data['banner_image'] = $request->file('banner_image')->store('sections', 'public');
            }

            $section->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Bölmə uğurla yeniləndi');
    }

    public function destroy(Section $section)
    {
        if ($section->image) {
            Storage::disk('public')->delete($section->image);
        }
        $section->delete();
        return redirect()->route('sections.index')->with('message', 'Bölmə uğurla silindi');
    }

    public function editByType($type)
    {
        $section = Section::where('type', $type)->firstOrFail();
        return view('admin.sections.edit', compact('section'));
    }
}
