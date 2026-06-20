<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
  
    public function index()
    {
       $data['settings'] = Setting::all();
       $data['countSettings'] = Setting::count();
       return view('backend.settings.view-setting',$data);
    }

   
    public function create()
    {
        return view('backend.settings.add-setting');
    }

  
    public function store(Request $request)
    {
        $this->validate($request,[
            'app_name' => 'required',
            'keywords' => 'required',
            'description' => 'required',
        ]);

        $data = new Setting();
        $data->app_name = $request->app_name;
        $data->keywords = $request->keywords;
        $data->description = $request->description;
        $data->whatsapp_notify_number = $request->whatsapp_notify_number;
        $data->save();
        return redirect()->route('settings.view')->with('success', 'Data inserted successfully');

    }

    
    public function edit($id){
        $editData = Setting::find($id);
        return view('backend.settings.add-setting', compact('editData'));
    }

    public function update(Request $request, $id){
        $data = Setting::find($id);
        $data->app_name = $request->app_name;
        $data->keywords = $request->keywords;
        $data->description = $request->description;
        $data->whatsapp_notify_number = $request->whatsapp_notify_number;
        $data->save();
        return redirect()->route('settings.view')->with('success','Data updated successfully !!!');
    }

    public function delete(Request $request){
        $data = Setting::find($request->id);
        $data->delete();
        return redirect()->route('settings.view')->with('success', 'Data deleted successfully !!!');
    }
}
