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
        $setting->value = $request->value;
        $setting->save();

        Cache::forget('settings');

        return response()->redirectTo('/dashboard/system-settings');
    }
}
