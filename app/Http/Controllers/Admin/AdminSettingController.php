<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminSettingController extends Controller
{
    protected $socialPlatforms = [
        'facebook' => [
            'label' => 'Facebook',
            'icon' => 'facebook',
            'url' => 'facebook.com'
        ],
        'twitter' => [
            'label' => 'Twitter',
            'icon' => 'twitter',
            'url' => 'twitter.com'
        ],
        'instagram' => [
            'label' => 'Instagram',
            'icon' => 'instagram',
            'url' => 'instagram.com'
        ],
        'linkedin' => [
            'label' => 'LinkedIn',
            'icon' => 'linkedin',
            'url' => 'linkedin.com'
        ],
        'github' => [
            'label' => 'GitHub',
            'icon' => 'github',
            'url' => 'github.com'
        ]
    ];

    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        $socialPlatforms = $this->socialPlatforms;
        
        return view('admin.settings.index', compact('settings', 'socialPlatforms'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'app_name' => 'required|string|max:255',
            'app_url' => 'required|url',
            'app_timezone' => 'required|string|in:' . implode(',', timezone_identifiers_list()),
            'app_tinymce' => 'required|string',
            'app_googlesearchmeta' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'app_socialinstagram' => 'nullable|url',
            'app_socialfacebook' => 'nullable|url',
            'app_socialtwitter' => 'nullable|url',
            'app_sociallinkedin' => 'nullable|url',
            'app_socialgithub' => 'nullable|url',
        ]);

        // Save all settings except logo
        foreach ($validatedData as $key => $value) {
            if ($key !== 'logo') {
                Setting::set($key, $value);
            }
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $path = 'brand/logo.png';
            
            // Create backup of existing file if it exists
            if (Storage::disk('public')->exists($path)) {
                $timestamp = now()->format('Y-m-d_H-i-s');
                $backupPath = 'brand/backups/logo_' . $timestamp . '.png';
                Storage::disk('public')->copy($path, $backupPath);
            }
            
            // Store the new file
            Storage::disk('public')->putFileAs(dirname($path), $file, basename($path));
            
            // Update settings
            Setting::set('app_logo', 'storage/' . $path);
            $currentVersion = intval(Setting::get('app_logo_version', 0));
            Setting::set('app_logo_version', $currentVersion + 1);
        }

        // Force cache clear and refresh for all settings updates
        \Artisan::call('optimize:clear');
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'refresh' => true
            ]);
        }

        return redirect()
            ->route('admin.settings.index')
            ->with('success', 'Settings updated successfully')
            ->with('refresh', true);
    }
}