<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Benefit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BenefitController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-benefits|create-benefits|edit-benefits|delete-benefits', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-benefits', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-benefits', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-benefits', ['only' => ['destroy']]);
    }

    public function index()
    {
        $benefits = Benefit::ordered()->paginate(10);
        return view('admin.benefits.index', compact('benefits'));
    }

    public function create()
    {
        return view('admin.benefits.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'az_description' => 'required|string',
            'en_description' => 'required|string',
            'ru_description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'order' => $request->order ?? 0,
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

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('benefits', 'public');
            }

            Benefit::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('benefits.index')->with('message', 'Üstünlük uğurla əlavə edildi');
    }

    public function edit(Benefit $benefit)
    {
        return view('admin.benefits.edit', compact('benefit'));
    }

    public function update(Request $request, Benefit $benefit)
    {
        $request->validate([
            'az_title' => 'required|string|max:255',
            'en_title' => 'required|string|max:255',
            'ru_title' => 'required|string|max:255',
            'az_description' => 'required|string',
            'en_description' => 'required|string',
            'ru_description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'order' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'order' => $request->order ?? 0,
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

            if ($request->hasFile('image')) {
                if ($benefit->image) {
                    Storage::disk('public')->delete($benefit->image);
                }
                $data['image'] = $request->file('image')->store('benefits', 'public');
            }

            $benefit->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'Üstünlük uğurla yeniləndi');
    }

    public function destroy(Benefit $benefit)
    {
        if ($benefit->image) {
            Storage::disk('public')->delete($benefit->image);
        }
        $benefit->delete();
        return redirect()->route('benefits.index')->with('message', 'Üstünlük uğurla silindi');
    }
}
