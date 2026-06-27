<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Sms;
use App\Rules\BdPhoneNumber;
use App\Traits\SendSmsTrait;
use Illuminate\Http\Request;

class SmsGatewayController extends Controller
{
    use SendSmsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['countsms'] = Sms::count();
        $data['allData'] = Sms::select('id','apiKey','userName','SenderName')->orderBy('id','DESC')->get();
        return view('backend.sms-gateway.view-smsgateway',$data);
    }

    public function testPage()
    {
        $data['countsms'] = Sms::count();
        $data['allData'] = Sms::select('id','apiKey','userName','SenderName')->orderBy('id','DESC')->get();
        return view('backend.sms-gateway.view-smsgateway', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.sms-gateway.add-smsgateway');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Illuminate\Support\Facades\DB::transaction(function() use($request){
            $this->validate($request,[
                'apiKey'=>'required',
                'userName'=>'required',
                'SenderName'=>'required'
            ]);
            $smsData = new Sms();
            $smsData->apiKey = $request->apiKey;
            $smsData->userName = $request->userName;
            $smsData->SenderName = $request->SenderName;
            $smsData->save();
        });
        return redirect()->route('smsgateways.view')->with('success', 'Data inserted successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['editData'] = Sms::find($id);
        return view('backend.sms-gateway.add-smsgateway', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        \Illuminate\Support\Facades\DB::transaction(function() use($request,$id){
            $data = Sms::find($id);
            $data->apiKey = $request->apiKey;
            $data->userName = $request->userName;
            $data->SenderName = $request->SenderName;
            $data->save();
        });
        return redirect()->route('smsgateways.view')->with('success', 'Data updated successfully');
    }

public function testSend(Request $request)
    {
        try {
            $validationErrors = [];
            
            $mobileInput = $request->mobile;
            $mobileNormalized = $this->normalizeBangladeshMobileNumber($mobileInput);
            
            // Accept 11 digit format (01XXXXXXXXX)
            if (!preg_match('/^(\+?88|0088)?01[0-9]{9}$/', str_replace('+', '', $mobileInput))) {
                $validationErrors[] = 'Mobile format does not match Bangladeshi format (01XXXXXXXXX)';
            }
            
            // Now expects 13 chars (88 + 11 digits)
            if (strlen($mobileNormalized) !== 13) {
                $validationErrors[] = 'Normalized mobile length is ' . strlen($mobileNormalized) . ', expected 13 digits (88 + 11 digits)';
            }
            
            // Now expects 11 digits after 88 (format: 8801[3-9]XXXXXXXX)
            if (!preg_match('/^8801[3-9]\d{8}$/', $mobileNormalized)) {
                $validationErrors[] = 'Normalized mobile should be 88 + 01 + operator(3-9) + 8 digits = 13 chars';
            }

            $this->validate($request, [
                'mobile' => ['required', new BdPhoneNumber(), 'regex:/^(\+?88|0088)?01[0-9]{9}$/'],
                'message' => 'required|string|max:300',
            ]);

            $response = $this->send_rapid_message($mobileNormalized, $request->message);
            $success = isset($response['status']) && strtolower((string) $response['status']) === 'success';
            $providerMessage = $response['responseResult'] ?? $response['message'] ?? 'Unable to send test SMS.';
            
            $digitCountAfterCode = strlen(substr($mobileNormalized, 2));
            $prefixAfter88 = substr($mobileNormalized, 2, 2); // Should be 01
            $operatorDigit = substr($mobileNormalized, 4, 1); // e.g. 3, 7
            $isValidPrefix = ($prefixAfter88 === '01');
            $isValidOperatorCode = in_array($operatorDigit, ['3', '4', '5', '6', '7', '8', '9']);
            
            $operatorNames = [
                '13' => 'Banglalion (013)',
                '14' => 'Robi (014)',
                '15' => 'Banglalink (015)',
                '16' => 'CityCell (016)',
                '17' => 'Grameenphone (017)',
                '18' => 'Banglalion (018)',
                '19' => 'Teletalk (019)',
            ];
            
            $isValidDigitCount = ($digitCountAfterCode === 11);
            
            $debugData = [
                'input_mobile' => $mobileInput,
                'mobile_after_normalization' => $mobileNormalized,
                'validation_errors' => $validationErrors,
                'mobile_length_check' => [
                    'input_length' => strlen($mobileInput),
                    'normalized_length' => strlen($mobileNormalized),
                    'digit_count_after_country_code' => $digitCountAfterCode,
                    'expected_digits_after_88' => 11,
                    'expected_total_length' => 13,
                    'is_valid' => $isValidDigitCount && $isValidPrefix && $isValidOperatorCode
                ],
                'mobile_prefix_check' => [
                    'normalized_mobile' => $mobileNormalized,
                    'prefix' => $prefixAfter88,
                    'operator_digit' => $operatorDigit ?? 'N/A',
                    'operator_name' => $operatorDigit ? ($operatorNames['1' . $operatorDigit] ?? 'Unknown') : null,
                    'is_valid_operator_code' => $isValidOperatorCode,
                    'is_valid_prefix' => $isValidPrefix && $isValidOperatorCode && $isValidDigitCount,
                    'digit_count_issue' => !$isValidDigitCount
                ],
                'curl_http_code' => $response['debug_info']['http_code'] ?? null,
                'curl_error' => $response['debug_info']['curl_error'] ?? null,
                'api_request' => $response['debug_info']['api_request'] ?? null,
                'credentials_status' => $response['debug_info']['credentials_status'] ?? null,
                'normalization_steps' => $response['debug_info']['normalization_steps'] ?? null,
                'validation_results' => $response['debug_info']['validation_results'] ?? null,
            ];

            return redirect()
                ->route('smsgateways.view')
                ->with($success ? 'success' : 'error', $success ? 'Test SMS sent successfully.' : 'Test SMS failed: ' . $providerMessage)
                ->with('sms_test_response', $response)
                ->with('sms_test_mobile', $mobileNormalized)
                ->with('sms_test_input_mobile', $mobileInput)
                ->with('sms_test_debug', $debugData);
        } catch (\Exception $e) {
            return redirect()
                ->route('smsgateways.view')
                ->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    /**
     * Show SMS Templates edit page
     */
    public function templates()
    {
        $smsSettings = \App\Models\Sms::first();
        return view('backend.sms-gateway.sms-templates', compact('smsSettings'));
    }

    /**
     * Update SMS Templates from admin panel
     */
    public function updateTemplates(\Illuminate\Http\Request $request)
    {
        $templateKeys = [
            'tpl_order_confirmed_cod_free', 'tpl_order_confirmed_cod_paid',
            'tpl_order_confirmed_bkash', 'tpl_order_processing',
            'tpl_order_shipped', 'tpl_order_delivered',
            'tpl_order_cancelled', 'tpl_order_return',
            'tpl_welcome_seller', 'tpl_welcome_vendor',
            'tpl_welcome_dropshipper', 'tpl_subscription_expiry',
            'tpl_withdrawal_approved',
            'tpl_password_reset',
        ];

        $data = [];
        foreach ($templateKeys as $key) {
            if ($request->has($key)) {
                $data[$key] = $request->input($key);
            }
        }

        \App\Models\Sms::where('id', 1)->update($data);

        return redirect()->route('sms.templates.view')
            ->with('success', '✅ সব SMS Templates সফলভাবে Save হয়েছে!');
    }

}
