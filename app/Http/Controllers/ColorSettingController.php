<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ColorSetting;

class ColorSettingController extends Controller
{
    public function save(Request $request)
    {
        $existComponent = ColorSetting::where([['user_id', auth()->user()->id], ['component', $request->component]])
            ->get();

        if (count($existComponent) == 0) {
            $color_settings = ColorSetting::create([
                'user_id' => auth()->user()->id,
                'component' => $request->component,
                'color' => $request->color,
            ]);
        } else {
            $color_settings = ColorSetting::find($existComponent[0]->id);
            $color_settings->color = $request->color;
            $color_settings->save();
        }
        return response()->json($color_settings);
    }
}
