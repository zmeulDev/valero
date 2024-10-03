<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'app_timezone' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Add more validation rules for other settings
        ]);

        foreach ($validatedData as $key => $value) {
            if ($key !== 'logo') {
                Setting::set($key, $value);
            }
        }

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            
            // Define the path where the logo should be saved
            $path = storage_path('app/public/brand/logo.png');
            
            // Ensure the directory exists
            File::ensureDirectoryExists(dirname($path));

            // Backup old logo
            if (File::exists($path)) {
                File::move($path, storage_path('app/public/brand/logo_backup_' . time() . '.png'));
            }
            
            try {
                File::move($file->getRealPath(), $path);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Failed to update logo: ' . $e->getMessage());
            }

            // Update the logo path in settings
            Setting::set('logo_path', 'storage/brand/logo.png');

            // Increment logo version
            Setting::set('logo_version', (int)Setting::get('logo_version', '1') + 1);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}