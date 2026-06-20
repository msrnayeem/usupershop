<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Auth;

class PaymentSettingController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $payment = PaymentSetting::where('user_id', auth()->user()->id)
                ->where('method', strtolower(request()->method_type))
                ->first();

            return response()->json([
                'status' => true,
                'data' => $payment,
            ]);
        }

        $payment = PaymentSetting::where('user_id', auth()->user()->id)->first();
        return $this->resolvePaymentSettingView($payment);
    }


    public function store(Request $request)
    {
        $request->validate([
            'method' => 'required',
            'number' => 'required|digits_between:10,15',
        ]);

        PaymentSetting::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'method' => $request->method,
            ],
            [
                'number' => $request->number,
            ]
        );

        return back()->with('success', 'Payment information saved successfully!');
    }

    public function dropshipperIndex()
    {
        if (request()->ajax()) {
            $payment = PaymentSetting::where('user_id', auth()->user()->id)
                ->where('method', strtolower(request()->method_type))
                ->first();

            return response()->json([
                'status' => true,
                'data' => $payment,
            ]);
        }

        $payment = PaymentSetting::where('user_id', auth()->user()->id)->first();
        return $this->resolvePaymentSettingView($payment);
    }

    public function dropshipperStore(Request $request)
    {
        $request->validate([
            'method' => 'required',
            'number' => 'required|digits_between:10,15',
        ]);

        PaymentSetting::updateOrCreate(
            [
                'user_id' => auth()->user()->id,
                'method' => $request->method,
            ],
            [
                'number' => $request->number,
            ]
        );

        return back()->with('success', 'Payment information saved successfully!');
    }

    private function resolvePaymentSettingView($payment)
    {
        $userType = auth()->user()->usertype;

        if ($userType === 'dropshipper') {
            return view('backend.dropshipper.user.payment_setting', compact('payment'));
        }

        if (in_array($userType, ['seller', 'vendor'], true)) {
            return view('backend.seller.user.payment_setting', compact('payment'));
        }

        abort(403, 'Unauthorized access');
    }
}
