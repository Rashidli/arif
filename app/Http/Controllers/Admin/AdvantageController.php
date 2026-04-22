<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advantage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvantageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-advantages|create-advantages|edit-advantages|delete-advantages', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-advantages', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-advantages', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-advantages', ['only' => ['destroy']]);
    }

    public function index()
    {
        $advantages = Advantage::ordered()->paginate(20);
        return view('admin.advantages.index', compact('advantages'));
    }

    public function create()
    {
        return view('admin.advantages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:admin,tenant',
            'az_text' => 'required|string|max:500',
            'en_text' => 'required|string|max:500',
            'ru_text' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            Advantage::create([
                'type' => $request->type,
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

        return redirect()->route('advantages.index')->with('message', 'Üstünlük uğurla əlavə edildi');
    }

    public function edit(Advantage $advantage)
    {
        return view('admin.advantages.edit', compact('advantage'));
    }

    public function update(Request $request, Advantage $advantage)
    {
        $request->validate([
            'type' => 'required|string|in:admin,tenant',
            'az_text' => 'required|string|max:500',
            'en_text' => 'required|string|max:500',
            'ru_text' => 'required|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            $advantage->update([
                'type' => $request->type,
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

        return redirect()->back()->with('message', 'Üstünlük uğurla yeniləndi');
    }

    public function destroy(Advantage $advantage)
    {
        $advantage->delete();
        return redirect()->route('advantages.index')->with('message', 'Üstünlük uğurla silindi');
    }
}
