<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CommissionSettingController extends Controller
{
    public function index(){
        $pageTitle = "Commission Settings";
        return view('backend.settings.commission-setting', compact('pageTitle'));
    }

    public function update(Request $request){
        $request->validate([
            'refer_commission_type' => ['required'],
            'refer_commission' => ['required', 'min:0']
        ]);


        $data = Setting::findOrFail(1);
        
        $data->refer_commission_type = $request->refer_commission_type;
        $data->refer_commission = $request->refer_commission;
        $data->save();
        
        return redirect()->back()->with('success', 'Refer Commission Setup Successful');
    }
}
