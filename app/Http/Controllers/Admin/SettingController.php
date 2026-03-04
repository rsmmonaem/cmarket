<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display all system settings
     */
    public function index()
    {
        $settings = SystemSetting::orderBy('group')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings in bulk
     */
    public function update(Request $request)
    {
        $settings = $request->except('_token');

        foreach ($settings as $key => $value) {
            $setting = SystemSetting::where('key', $key)->first();
            if ($setting) {
                // Validate if it's float/decimal type
                if (in_array($setting->type, ['float', 'decimal'])) {
                    $value = filter_var($value, FILTER_VALIDATE_FLOAT);
                }
                
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully! 🚀');
    }
}
