<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $setting = Setting::first();

        return view('setting',compact('setting'));


    }
    public function update(Request $request)
    {
        $request->validate([
            'primary_email' => 'nullable|email',
        ]);

        $setting = Setting::first();

        if ($setting) {
            // Update existing setting
            $setting->update([
                'primary_email' => $request->primary_email,
            ]);
            return redirect()->back()->with('success', 'Setting updated successfully.');
        }

        // Create new setting if not found
        Setting::create([
            'primary_email' => $request->primary_email,
        ]);

        return redirect()->back()->with('success', 'Setting created successfully.');
    }


}
