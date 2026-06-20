<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ColorSetting;
use Illuminate\Http\Request;

class ColorSettingController extends Controller
{
    public function index()
    {
        $colorSettings = ColorSetting::all();
        
        // Default color elements if not exists
        $defaultElements = [
            'header_bg' => ['display' => 'Header Background', 'default' => '#0824AC'],
            'sub_header_bg' => ['display' => ' Sub Header Background', 'default' => '#0a00a1'],
            'header_text' => ['display' => 'Header Text', 'default' => '#000000'],
            'footer_bg' => ['display' => 'Footer Background', 'default' => '#202020'],
            'footer_text' => ['display' => 'Footer Text', 'default' => '#ffffff'],
            'search_icon_bg' => ['display' => 'Search Icon Background', 'default' => '#007bff'],
            'search_icon_color' => ['display' => 'Search Icon Color', 'default' => '#ffffff'],
            'add_to_cart_bg' => ['display' => 'Add to Cart Background', 'default' => '#0824ac'],
            'add_to_cart_text' => ['display' => 'Add to Cart Text', 'default' => '#ffffff'],
            'price_color' => ['display' => 'Price Color', 'default' => '#0824AC'],
            'primary_button' => ['display' => 'Primary Button', 'default' => '#007bff'],
            'secondary_button' => ['display' => 'Secondary Button', 'default' => '#6c757d']
        ];

        // Create missing elements
        foreach ($defaultElements as $key => $element) {
            if (!$colorSettings->where('element_name', $key)->first()) {
                ColorSetting::create([
                    'element_name' => $key,
                    'color_code' => $element['default'],
                    'display_name' => $element['display']
                ]);
            }
        }

        $colorSettings = ColorSetting::all();
        return view('backend.color-settings.index', compact('colorSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'colors' => 'required|array',
            'colors.*' => 'required|regex:/^#[a-fA-F0-9]{6}$/'
        ]);

        foreach ($request->colors as $elementName => $colorCode) {
            ColorSetting::where('element_name', $elementName)
                ->update(['color_code' => $colorCode]);
        }

        return redirect()->back()->with('success', 'Color settings updated successfully!');
    }

    public function reset()
    {
        $defaultColors = [
            'header_bg' => '#ffffff',
            'header_text' => '#000000',
            'footer_bg' => '#333333',
            'footer_text' => '#ffffff',
            'search_icon_bg' => '#007bff',
            'search_icon_color' => '#ffffff',
            'add_to_cart_bg' => '#28a745',
            'add_to_cart_text' => '#ffffff',
            'price_color' => '#dc3545',
            'primary_button' => '#007bff',
            'secondary_button' => '#6c757d'
        ];

        foreach ($defaultColors as $element => $color) {
            ColorSetting::where('element_name', $element)
                ->update(['color_code' => $color]);
        }

        return redirect()->back()->with('success', 'Colors reset to default successfully!');
    }
}