<?php
namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;

class SettingController extends Controller
{
    public function __construct()
    {
        if(\Auth::check() && !\Auth::User()->can('manage', Setting::class)) {
            abort(403);
        }
    }

    public function getIndex()
    {
        return view('app.setting.index')->with([
            'settings' => Setting::all(),
        ]);
    }

    public function postStore()
    {
        $key = \Input::get('key');
        $value = \Input::get('value');
        if(empty($key) || empty($value)) {
            return back();
        }
        $setting = new Setting();
        $setting->key = $key;
        $setting->value = $value;
        $setting->save();
        return back();
    }

    public function postUpdate($id)
    {
        $value = \Input::get('value');
        if(empty($value)) {
            return back();
        }
        $setting = Setting::id($id)->firstOrFail();
        $setting->value = $value;
        $setting->save();
        return back();
    }

    public function getDelete($id)
    {
        Setting::id($id)->delete();
        return back();
    }
}
