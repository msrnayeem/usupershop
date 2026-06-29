<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['orders'] = Order::select('id')->count();
        $data['sellers'] = User::where('usertype','seller')->select('id')->count();
        $data['customers'] = User::where('usertype','customer')->select('id')->count();
        $data['products'] = Product::select('id')->count();
        $data['pending_products'] = Product::where('status', 2)->count();
        $data['inactive_products'] = Product::where('status', 0)->count();
        $data['pending_order'] = Order::where('status', 'pending')->count();
        $data['confirmed_order'] = Order::where('status','confirmed')->count();
        $data['delivered_order'] = Order::where('status','delivered')->count();
        $data['return_order'] = Order::where('status','return')->count();
        $data['cancel_order']     = Order::where('status', 'canceled')->count();
        $data['stock_out_count']  = \App\Models\Product::where('quantity', '<=', 0)->where('status', 1)->count();
        $data['low_stock_count']  = \App\Models\Product::where('quantity', '>', 0)->where('quantity', '<=', 5)->where('status', 1)->count();
        $data['is_profile_verify'] = User::where('is_profile_verify',1)->count();
        $data['user_total_balance'] = User::sum('balance');
       $data['total_reffer'] = User::whereNotNull('code')->count();
       $data['total_withdraw_request'] = Wallet::count();

        
         $sellers = User::where('usertype', 'seller')->orderBy('id','DESC');
         $data['paid_sellers']  = $sellers->where('payment_status', 1)->count();
         $sellers = User::where('usertype', 'seller')->orderBy('id','DESC');
         $data['unPaid_sellers']  = $sellers->where('payment_status', 0)->count();
 $vendors = User::where('usertype', 'vendor')->orderBy('id','DESC');
  $data['paid_vendor']  = $vendors->where('payment_status', 1)->count();
 $vendors = User::where('usertype', 'vendor')->orderBy('id','DESC');
  $data['upPaid_vendor']  = $vendors->where('payment_status', 0)->count();
  
         $data['unPaid_dropshipper'] = 0;

        // 14-day order trend for chart
        $trendRaw = \App\Models\Order::selectRaw('DATE(created_at) as day, COUNT(*) as cnt')
            ->where('created_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('cnt', 'day')
            ->toArray();

        $trend = [];
        for ($i = 13; $i >= 0; $i--) {
            $day = now()->subDays($i)->format('Y-m-d');
            $trend[] = $trendRaw[$day] ?? 0;
        }
        $data['orderTrend'] = $trend;

        return view('backend.layouts.home', $data);
    }
}
