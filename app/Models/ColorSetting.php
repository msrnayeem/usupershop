<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'element_name',
        'color_code',
        'display_name'
    ];

    public static function getColor($elementName, $default = '#000000')
    {
        $setting = self::where('element_name', $elementName)->first();
        return $setting ? $setting->color_code : $default;
    }

    public static function setColor($elementName, $colorCode, $displayName = null)
    {
        return self::updateOrCreate(
            ['element_name' => $elementName],
            [
                'color_code' => $colorCode,
                'display_name' => $displayName ?: ucfirst(str_replace('_', ' ', $elementName))
            ]
        );
    }

    public static function getAllColors()
    {
        return self::all()->pluck('color_code', 'element_name');
    }
}