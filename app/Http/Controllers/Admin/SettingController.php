<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'whatsapp' => Setting::get('whatsapp'),
            'map_embed' => Setting::get('map_embed'),
            'stat_years' => Setting::get('stat_years', '10+'),
            'stat_customers' => Setting::get('stat_customers', '500+'),
            'stat_service_hours' => Setting::get('stat_service_hours', '24/7'),
            'stat_warranty' => Setting::get('stat_warranty', '1 il'),
            'developer_name' => Setting::get('developer_name', 'Developer'),
            'developer_link' => Setting::get('developer_link', '#'),
        ];
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        Setting::set('whatsapp', $request->whatsapp);
        Setting::set('map_embed', $request->map_embed);
        Setting::set('stat_years', $request->stat_years);
        Setting::set('stat_customers', $request->stat_customers);
        Setting::set('stat_service_hours', $request->stat_service_hours);
        Setting::set('stat_warranty', $request->stat_warranty);
        Setting::set('developer_name', $request->developer_name);
        Setting::set('developer_link', $request->developer_link);

        return redirect()->back()->with('message', 'Ayarlar uğurla yeniləndi');
    }
}
