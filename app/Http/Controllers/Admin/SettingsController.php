<?php

namespace App\Http\Controllers\Admin;

use App\Models\Settings;
use App\Http\Requests\Admin\SettingRequest;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $settings=Settings::where('show_edit',1)->get();
        $settings=$settings->groupBy('tab_name');

        return view('admin.settings.index',compact('settings'));
    }
    public function save(SettingRequest $request)
    {
        foreach ($request->except(['_token']) as $name=>$value){
            Settings::updateOrCreate(
                ['name' => $name],
                ['value' => $value]
            );
        }
        flash('تم التعديل بنجاح');
        return redirect(route('system.settings.index'));
    }
}
