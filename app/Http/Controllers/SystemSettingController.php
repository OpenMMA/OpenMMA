<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\SystemSetting;


class SystemSettingController extends Controller
{
    public function index()
    {
        return view('dashboard.system-settings');
    }

    public function update(Request $request)
    {
        $setting = SystemSetting::where('key', $request->key)->first();
        $old_value = $setting->value;
        $setting->value = $request->value;
        $setting->save();

        Cache::forget('settings');

        switch ($request->key) {
            case 'account.custom_fields':
                \App\Models\User::syncCustomFields($old_value, $setting->value);
                break;
        }

        return response()->redirectTo('/dashboard/system-settings');
    }
}
