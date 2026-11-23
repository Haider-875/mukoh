<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        $settings = WebsiteSetting::all()->groupBy('group');
        return view('admin.content.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        foreach ($data as $key => $value) {
            $setting = WebsiteSetting::where('key', $key)->first();
            if ($setting) {
                if ($setting->type === 'boolean') {
                    $setting->value = $value ? '1' : '0';
                } else {
                    $setting->value = $value;
                }
                $setting->save();
            } else {
                WebsiteSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'group' => 'general',
                    'type' => 'text',
                    'label' => ucfirst(str_replace('_', ' ', $key)),
                ]);
            }
        }

        return back()->with('success', 'Website content and settings updated successfully.');
    }
}
