<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

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
        return view('admin.settings.index', [
            'settings' => Setting::getAllSettings(),
            'socialPlatforms' => $this->socialPlatforms
        ]);
    }

    public function update(Request $request)
    {
        try {
            // Validate basic settings
            $validatedData = $request->validate([
                'app_name' => 'required|string|max:255',
                'app_url' => 'required|url',
                'app_timezone' => 'required|string|in:' . implode(',', timezone_identifiers_list()),
                'app_tinymce' => 'required|string',
                'app_googlesearchmeta' => 'required|string',
                'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'app_profitshare' => 'nullable|string',
            ], [
                'app_name.required' => 'The application name is required.',
                'app_url.url' => 'Please enter a valid URL.',
                'app_timezone.in' => 'Please select a valid timezone.',
                'logo.image' => 'The logo must be an image.',
                'logo.max' => 'The logo must not be larger than 2MB.',
                'app_profitshare.string' => 'The profitshare ID must be a string.',
            ]);

            // Validate social media URLs
            foreach ($this->socialPlatforms as $platform => $data) {
                $validatedData['app_social' . $platform] = $request->validate([
                    'app_social' . $platform => 'nullable|url'
                ])['app_social' . $platform] ?? null;
            }

            // Save all settings except logo
            foreach ($validatedData as $key => $value) {
                if ($key !== 'logo') {
                    Setting::set($key, $value);
                }
            }

            // Handle logo upload
            if ($request->hasFile('logo')) {
                $this->handleLogoUpload($request->file('logo'));
            }

            // Clear cache
            Artisan::call('optimize:clear');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => __('Settings updated successfully'),
                    'refresh' => true
                ]);
            }

            return redirect()
                ->route('admin.settings.index')
                ->with('success', __('Settings updated successfully'));
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 422);
            }

            return redirect()
                ->route('admin.settings.index')
                ->with('error', $e->getMessage());
        }
    }

    protected function handleLogoUpload($file)
    {
        try {
            $path = 'brand/logo.png';
            
            // Backup existing logo if it exists
            if (Storage::disk('public')->exists($path)) {
                $timestamp = now()->format('Y-m-d_H-i-s');
                $backupPath = 'brand/backups/logo_' . $timestamp . '.png';
                Storage::disk('public')->copy($path, $backupPath);
            }
            
            // Store new logo
            Storage::disk('public')->putFileAs(dirname($path), $file, basename($path));
            
            // Update settings
            Setting::set('app_logo', 'storage/' . $path);
            Setting::set('app_logo_version', (int)Setting::get('app_logo_version', 0) + 1);
        } catch (\Exception $e) {
            throw new \Exception('Failed to upload logo: ' . $e->getMessage());
        }
    }
}