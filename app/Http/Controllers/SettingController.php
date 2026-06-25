<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::first();

        if (!$setting) {
            $setting = Setting::create([
                'gram_per_point' => 1000,
                'point_per_voucher' => 100,
            ]);
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'data' => $setting
            ]);
        }

        $data['page_title'] = 'Pengaturan Poin';
        $data['setting'] = $setting;

        return view('settings.index', $data);
    }

    public function update(Request $request, $id = null)
    {
        $validated = $request->validate([
            'gram_per_point' => 'required|integer|min:1',
            'point_per_voucher' => 'required|integer|min:1',
        ]);

        $setting = Setting::first();

        if (!$setting) {
            $setting = new Setting();
        }

        $setting->gram_per_point = $validated['gram_per_point'];
        $setting->point_per_voucher = $validated['point_per_voucher'];
        $setting->save();

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'success' => true,
                'message' => 'Settings updated successfully',
                'data' => $setting
            ]);
        }

        return redirect()->route('settings.index')->with('success', 'Pengaturan berhasil diperbarui!');
    }
}
