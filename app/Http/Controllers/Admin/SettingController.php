<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $inputs = $request->except(['_token', '_method', 'logo', 'kop_surat']);

        // Handle text/string settings
        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'type' => 'string']
            );
        }

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'logo'],
                ['value' => $path, 'type' => 'file']
            );
        }

        if ($request->hasFile('kop_surat')) {
            $path = $request->file('kop_surat')->store('settings', 'public');
            Setting::updateOrCreate(
                ['key' => 'kop_surat'],
                ['value' => $path, 'type' => 'file']
            );
        }

        return redirect()->back()->with('success', 'Pengaturan berhasil diperbarui.');
    }
}
