<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Courier;
use App\Services\CourierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourierController extends Controller
{
    public function settings()
    {
        $couriers = Courier::all();

        // Create defaults if not exist
        foreach (['Steadfast', 'Pathao'] as $name) {
            if (!$couriers->where('name', $name)->first()) {
                Courier::create([
                    'name'      => $name,
                    'is_active' => 0,
                    'base_url'  => $name === 'Steadfast'
                        ? 'https://portal.packzy.com/api/v1'
                        : 'https://courier-api.pathao.com',
                    'is_sandbox'=> 0,
                ]);
            }
        }
        $couriers = Courier::all();
        return view('backend.couriers.settings', compact('couriers'));
    }

    public function update(Request $request, $id)
    {
        $courier = Courier::findOrFail($id);

        $data = [
            'is_active'  => $request->has('is_active') ? 1 : 0,
            'base_url'   => $request->base_url ?? $courier->base_url,
            'is_sandbox' => $request->is_sandbox ?? 0,
        ];

        if ($courier->name === 'Steadfast') {
            $data['api_key']    = $request->api_key    ?? '';
            $data['secret_key'] = $request->secret_key ?? '';
        }

        if ($courier->name === 'Pathao') {
            $data['client_id']     = $request->client_id     ?? '';
            $data['client_secret'] = $request->client_secret ?? '';
            $data['username']      = $request->username       ?? '';
            $data['password']      = $request->password       ?? '';
            $data['store_id']      = $request->store_id       ?? '';
        }

        $courier->update($data);

        // Clear courier caches
        Cache::forget('pathao_access_token_' . md5($request->client_id ?? ''));
        Cache::forget('pathao_cities_' . md5($request->client_id ?? ''));
        Cache::forget('pathao_store_id_' . md5($request->client_id ?? ''));

        $status = $data['is_active'] ? 'Active' : 'Inactive';
        return redirect()->route('couriers.settings')
            ->with('success', "✅ {$courier->name} settings saved! Status: {$status}");
    }

    public function testConnection(Request $request)
    {
        $courier = $request->input('courier');
        try {
            $service = new CourierService();
            $result  = $service->testConnection($courier);
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => '❌ Error: ' . $e->getMessage()]);
        }
    }
}
