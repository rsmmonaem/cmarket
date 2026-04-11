<?php

namespace Modules\Admin\Http\Controllers;

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
        return view('admin::settings.index', compact('settings'));
    }

    /**
     * Update settings in bulk
     */
    public function update(Request $request)
    {
        $settingsData = $request->input('settings', []);

        foreach ($settingsData as $key => $value) {
            $setting = SystemSetting::where('key', $key)->first();
            if ($setting) {
                // If checkbox (boolean) is not present in request, it's false
                // But since we are looping over input, checkboxes handle themselves if checked
                $setting->update(['value' => $value]);
            }
        }

        return redirect()->back()->with('success', 'Settings updated successfully! 🚀');
    }
}
