<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IntegrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:list-integrations|create-integrations|edit-integrations|delete-integrations', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-integrations', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-integrations', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-integrations', ['only' => ['destroy']]);
    }

    public function index()
    {
        $integrations = Integration::ordered()->paginate(10);
        return view('admin.integrations.index', compact('integrations'));
    }

    public function create()
    {
        return view('admin.integrations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'az_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
            'ru_name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
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

            if ($request->hasFile('icon')) {
                $data['icon'] = $request->file('icon')->store('integrations', 'public');
            }

            Integration::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->route('integrations.index')->with('message', 'İnteqrasiya uğurla əlavə edildi');
    }

    public function edit(Integration $integration)
    {
        return view('admin.integrations.edit', compact('integration'));
    }

    public function update(Request $request, Integration $integration)
    {
        $request->validate([
            'az_name' => 'required|string|max:255',
            'en_name' => 'required|string|max:255',
            'ru_name' => 'required|string|max:255',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:10240',
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

            if ($request->hasFile('icon')) {
                if ($integration->icon) {
                    Storage::disk('public')->delete($integration->icon);
                }
                $data['icon'] = $request->file('icon')->store('integrations', 'public');
            }

            $integration->update($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('message', 'İnteqrasiya uğurla yeniləndi');
    }

    public function destroy(Integration $integration)
    {
        if ($integration->icon) {
            Storage::disk('public')->delete($integration->icon);
        }
        $integration->delete();
        return redirect()->route('integrations.index')->with('message', 'İnteqrasiya uğurla silindi');
    }
}
