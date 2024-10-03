<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'logo_path'];

    public static function get($key)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : null;
    }

    public static function set($key, $value)
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getLogo()
    {
        return static::get('logo_path', 'default_logo_path.png');
    }

    public static function setLogo($path)
    {
        static::updateOrCreate(['key' => 'logo'], ['logo_path' => $path]);
    }
}