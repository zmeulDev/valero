<?php

namespace App\Services;

class AssetService
{
    public static function getViteAssets(): array
    {
        $isDev = app()->environment('local');
        
        if ($isDev) {
            return [
                'css' => '@vite("resources/css/app.css")',
                'js' => '@vite("resources/js/app.js")'
            ];
        }

        $manifest = self::getManifest();
        
        if (!$manifest) {
            return self::getFallbackAssets();
        }

        return [
            'css' => self::getCssAssets($manifest),
            'js' => self::getJsAssets($manifest)
        ];
    }

    private static function getManifest(): ?array
    {
        $manifestPath = public_path('build/manifest.json');
        
        if (!file_exists($manifestPath)) {
            return null;
        }

        return json_decode(file_get_contents($manifestPath), true);
    }

    private static function getFallbackAssets(): array
    {
        $cwd = getcwd();
        $cssFiles = glob($cwd . '/build/assets/*.css');
        $jsFiles = glob($cwd . '/build/assets/*.js');

        return [
            'css' => $cssFiles ? asset('build/assets/' . basename($cssFiles[0])) : null,
            'js' => $jsFiles ? asset('build/assets/' . basename($jsFiles[0])) : null
        ];
    }

    private static function getCssAssets($manifest): ?string
    {
        foreach ($manifest as $file) {
            if (isset($file['css']) && !empty($file['css'])) {
                return asset('build/' . $file['css'][0]);
            }
        }
        return null;
    }

    private static function getJsAssets($manifest): ?string
    {
        foreach ($manifest as $key => $file) {
            if (str_contains($key, 'resources/js/app.js')) {
                return asset('build/' . $file['file']);
            }
        }
        return null;
    }
} 