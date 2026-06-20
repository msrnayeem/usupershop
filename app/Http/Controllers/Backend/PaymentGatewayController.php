<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentGatewayController extends Controller
{
    public function view(){
        $data['countpay'] = PaymentGateway::count();
        $data['allData'] = PaymentGateway::select('id','BKASH_USERNAME','active_status','BKASH_PASSWORD',
        'BKASH_API_KEY','BKASH_SECRET_KEY','NAGAD_USERNAME','NAGAD_PASSWORD','NAGAD_SECRET_KEY',
        'NAGAD_API_KEY')
        ->orderBy('id','DESC')->get();
        return view('backend.payment-gateway.view-paymentgateway',$data);
    }

    public function add(){
        return view('backend.payment-gateway.add-paymentgateway');
    }

    public function store(Request $request){

        DB::transaction(function() use($request){
            $this->validate($request,[
                'BKASH_USERNAME' => 'required'
            ]);

            PaymentGateway::create([
                'active_status'=> $request->active_status,
                'BKASH_USERNAME'=> $request->BKASH_USERNAME,
                'BKASH_PASSWORD'=> $request->BKASH_PASSWORD,
                'BKASH_API_KEY'=> $request->BKASH_API_KEY,
                'BKASH_SECRET_KEY'=> $request->BKASH_SECRET_KEY,
                'NAGAD_USERNAME'=> $request->NAGAD_USERNAME,
                'NAGAD_PASSWORD'=> $request->NAGAD_PASSWORD,
                'NAGAD_API_KEY'=> $request->NAGAD_API_KEY,
                'NAGAD_SECRET_KEY'=> $request->NAGAD_SECRET_KEY
            ]);
          
        });
        return redirect()->route('paymentgatways.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id){
        $data['editData'] = PaymentGateway::find($id);
        return view('backend.payment-gateway.add-paymentgateway', $data);
    }

    public function update(Request $request, $id){

        DB::transaction(function() use($request,$id){
            $data = PaymentGateway::find($id);
            $data->active_status = $request->active_status ?? 0;
            $data->BKASH_USERNAME = $request->BKASH_USERNAME;
            $data->BKASH_PASSWORD = $request->BKASH_PASSWORD;
            $data->BKASH_API_KEY = $request->BKASH_API_KEY;
            $data->BKASH_SECRET_KEY = $request->BKASH_SECRET_KEY;
            $data->NAGAD_USERNAME = $request->NAGAD_USERNAME;
            $data->NAGAD_PASSWORD = $request->NAGAD_PASSWORD;
            $data->NAGAD_API_KEY = $request->NAGAD_API_KEY;
            $data->NAGAD_SECRET_KEY = $request->NAGAD_SECRET_KEY;
            
            $data->save();
        });
        return redirect()->route('paymentgatways.view')->with('success', 'Data updated successfully');
    }
}
