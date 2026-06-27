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

    /**
     * Show WhatsApp + SMS notification settings page
     */
    public function notificationSettings()
    {
        $setting = \App\Models\Setting::first();
        return view('backend.settings.notification-settings', compact('setting'));
    }

    /**
     * Update WhatsApp + SMS notification settings
     */
    public function updateNotificationSettings(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'callmebot_api_key'      => 'nullable|string|max:50',
            'admin_whatsapp_number'  => 'nullable|string|max:20',
            'whatsapp_notify_order'  => 'nullable',
            'whatsapp_notify_member' => 'nullable',
            'sms_notify_enabled'     => 'nullable',
        ]);

        $setting = \App\Models\Setting::first();
        if (!$setting) {
            $setting = \App\Models\Setting::create([]);
        }

        $setting->update([
            'callmebot_api_key'      => $request->callmebot_api_key,
            'admin_whatsapp_number'  => $request->admin_whatsapp_number ?? '8801816622128',
            'whatsapp_notify_order'  => $request->has('whatsapp_notify_order') ? 1 : 0,
            'whatsapp_notify_member' => $request->has('whatsapp_notify_member') ? 1 : 0,
            'sms_notify_enabled'     => $request->has('sms_notify_enabled') ? 1 : 0,
        ]);

        // Also update .env file dynamically
        $this->updateEnvValue('CALLMEBOT_API_KEY', $request->callmebot_api_key ?? '');
        $this->updateEnvValue('ADMIN_WHATSAPP_NUMBER', $request->admin_whatsapp_number ?? '8801816622128');

        // Clear config cache so new values take effect
        try {
            \Artisan::call('config:clear');
        } catch (\Exception $e) {}

        return redirect()->route('settings.notification')
            ->with('success', '✅ Notification Settings সফলভাবে আপডেট হয়েছে!');
    }

    /**
     * Update a value in .env file
     */
    private function updateEnvValue(string $key, string $value): void
    {
        $path = base_path('.env');
        if (!file_exists($path)) return;

        $env = file_get_contents($path);
        $escaped = preg_quote("$key=", '/');

        if (preg_match("/^{$escaped}.*/m", $env)) {
            $env = preg_replace("/^{$escaped}.*/m", "$key=$value", $env);
        } else {
            $env .= "\n$key=$value";
        }

        file_put_contents($path, $env);
    }


    /**
     * Invoice Settings Page
     */
    public function invoiceSettings()
    {
        $setting = \App\Models\Setting::first();
        return view('backend.settings.invoice-settings', compact('setting'));
    }

    /**
     * Update Invoice Settings
     */
    public function updateInvoiceSettings(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'invoice_prefix'   => 'required|string|max:10|alpha',
            'invoice_digits'   => 'required|integer|between:3,7',
            'invoice_start_no' => 'required|integer|min:1',
        ]);

        \App\Models\Setting::where('id', 1)->update([
            'invoice_prefix'      => strtoupper($request->invoice_prefix),
            'invoice_digits'      => $request->invoice_digits,
            'invoice_start_no'    => $request->invoice_start_no,
            'invoice_footer_note' => $request->invoice_footer_note,
            'invoice_thank_you'   => $request->invoice_thank_you,
        ]);

        return redirect()->route('settings.invoice')
            ->with('success', '✅ Invoice Settings সফলভাবে save হয়েছে!');
    }


    public function livechatSettings()
    {
        $setting = \App\Models\Setting::first();
        return view('backend.settings.livechat-settings', compact('setting'));
    }

    public function updateLivechatSettings(\Illuminate\Http\Request $request)
    {
        \App\Models\Setting::where('id', 1)->update([
            'livechat_enabled'       => $request->has('livechat_enabled') ? 1 : 0,
            'livechat_provider'      => 'tawkto',
            'tawkto_property_id'     => $request->tawkto_property_id ?? '',
            'tawkto_widget_id'       => $request->tawkto_widget_id ?? '',
            'whatsapp_float_enabled' => $request->has('whatsapp_float_enabled') ? 1 : 0,
        ]);

        $liveStatus = $request->has('livechat_enabled') ? 'চালু' : 'বন্ধ';
        $waStatus   = $request->has('whatsapp_float_enabled') ? 'চালু' : 'বন্ধ';
        return redirect()->route('settings.livechat')
            ->with('success', "✅ Live Chat → {$liveStatus} | WhatsApp Button → {$waStatus} করা হয়েছে!");
    }


    public function seoSettings()
    {
        $setting = \App\Models\Setting::first();
        return view('backend.settings.seo-settings', compact('setting'));
    }

    public function updateSeoSettings(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'seo_site_title'       => 'nullable|string|max:200',
            'seo_meta_description' => 'nullable|string|max:500',
            'seo_meta_keywords'    => 'nullable|string|max:1000',
            'seo_og_image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'seo_favicon'          => 'nullable|mimes:ico,png,jpg,jpeg|max:512',
            'seo_logo'             => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ]);

        $data = [
            'seo_site_title'          => $request->seo_site_title,
            'seo_meta_description'    => $request->seo_meta_description,
            'seo_meta_keywords'       => $request->seo_meta_keywords,
            'seo_google_verification' => $request->seo_google_verification,
            'social_facebook'         => $request->social_facebook,
            'social_youtube'          => $request->social_youtube,
            'social_instagram'        => $request->social_instagram,
            'social_telegram'         => $request->social_telegram,
            'social_tiktok'           => $request->social_tiktok,
            'business_address'        => $request->business_address,
            'business_email'          => $request->business_email,
        ];

        // Handle OG image upload
        if ($request->hasFile('seo_og_image')) {
            $img     = $request->file('seo_og_image');
            $imgName = 'og-image-' . date('YmdHis') . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('upload/seo'), $imgName);
            $data['seo_og_image'] = $imgName;
        }

        // Handle Favicon upload
        if ($request->hasFile('seo_favicon')) {
            $fav     = $request->file('seo_favicon');
            $favName = 'favicon-' . date('YmdHis') . '.' . $fav->getClientOriginalExtension();
            $fav->move(public_path('upload/seo'), $favName);
            $data['seo_favicon'] = $favName;
        }

        // Handle Logo upload
        if ($request->hasFile('seo_logo')) {
            $logo     = $request->file('seo_logo');
            $logoName = 'logo-' . date('YmdHis') . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('upload/seo'), $logoName);
            $data['seo_logo'] = $logoName;
        }

        \App\Models\Setting::where('id', 1)->update($data);

        // Clear view cache so new meta tags show immediately
        try { \Artisan::call('view:clear'); } catch (\Exception $e) {}

        return redirect()->route('settings.seo')
            ->with('success', '✅ SEO Settings সফলভাবে Save হয়েছে!');
    }

}