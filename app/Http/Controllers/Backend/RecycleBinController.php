<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RecycleBinController extends Controller
{
    /**
     * Show Recycle Bin — all soft-deleted items grouped by type
     */
    public function index(Request $request)
    {
        $type   = $request->input('type', 'products');
        $search = $request->input('search', '');

        $tabs = [
            'products'   => ['label' => 'Products',   'icon' => '📦', 'color' => '#1e25fa'],
            'users'      => ['label' => 'Users',       'icon' => '👤', 'color' => '#00a855'],
            'orders'     => ['label' => 'Orders',      'icon' => '🛍️', 'color' => '#e8001d'],
            'coupons'    => ['label' => 'Coupons',     'icon' => '🎟️', 'color' => '#f57c00'],
            'sliders'    => ['label' => 'Sliders',     'icon' => '🖼️', 'color' => '#7b1fa2'],
            'categories' => ['label' => 'Categories',  'icon' => '📂', 'color' => '#0097a7'],
            'pages'      => ['label' => 'Pages',       'icon' => '📄', 'color' => '#555'],
        ];

        // Count for each tab
        $counts = [
            'products'   => Product::onlyTrashed()->count(),
            'users'      => User::onlyTrashed()->count(),
            'orders'     => Order::onlyTrashed()->count(),
            'coupons'    => Coupon::onlyTrashed()->count(),
            'sliders'    => Slider::onlyTrashed()->count(),
            'categories' => Category::onlyTrashed()->count(),
            'pages'      => Page::onlyTrashed()->count(),
        ];

        $totalTrashed = array_sum($counts);

        // Fetch items for current tab
        $items = match($type) {
            'products'   => Product::onlyTrashed()
                ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
                ->select('id','name','image','price','deleted_at')
                ->orderBy('deleted_at','desc')->paginate(20),

            'users'      => User::onlyTrashed()
                ->when($search, fn($q) => $q->where('name', 'like', "%$search%")->orWhere('email', 'like', "%$search%"))
                ->select('id','name','email','mobile','usertype','deleted_at')
                ->orderBy('deleted_at','desc')->paginate(20),

            'orders'     => Order::onlyTrashed()
                ->when($search, fn($q) => $q->where('invoice_no', 'like', "%$search%")->orWhere('order_no', 'like', "%$search%"))
                ->select('id','invoice_no','order_no','grand_total','order_payment','deleted_at')
                ->orderBy('deleted_at','desc')->paginate(20),

            'coupons'    => Coupon::onlyTrashed()
                ->when($search, fn($q) => $q->where('promoCode', 'like', "%$search%"))
                ->orderBy('deleted_at','desc')->paginate(20),

            'sliders'    => Slider::onlyTrashed()
                ->orderBy('deleted_at','desc')->paginate(20),

            'categories' => Category::onlyTrashed()
                ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
                ->select('id','name','name_bn','cat_icon','deleted_at')
                ->orderBy('deleted_at','desc')->paginate(20),

            'pages'      => Page::onlyTrashed()
                ->when($search, fn($q) => $q->where('title', 'like', "%$search%"))
                ->orderBy('deleted_at','desc')->paginate(20),

            default      => collect()->paginate(20),
        };

        return view('backend.recycle-bin.index', compact(
            'type','search','tabs','counts','totalTrashed','items'
        ));
    }

    /**
     * Restore single item
     */
    public function restore(Request $request, $type, $id)
    {
        try {
            $model = $this->getModel($type);
            $item  = $model::onlyTrashed()->findOrFail($id);
            $item->restore();

            Log::info("Recycle Bin: {$type} #{$id} restored", ['admin' => auth()->id()]);

            return back()->with('success', "✅ " . ucfirst($type) . " #$id সফলভাবে Restore হয়েছে!");
        } catch (\Exception $e) {
            return back()->with('error', '❌ Restore failed: ' . $e->getMessage());
        }
    }

    /**
     * Restore ALL items of a type
     */
    public function restoreAll(Request $request, $type)
    {
        $model = $this->getModel($type);
        $count = $model::onlyTrashed()->count();
        $model::onlyTrashed()->restore();

        Log::info("Recycle Bin: all {$type} restored ({$count} items)", ['admin' => auth()->id()]);

        return back()->with('success', "✅ {$count}টি " . ucfirst($type) . " সব Restore হয়েছে!");
    }

    /**
     * Permanently delete single item
     */
    public function forceDelete(Request $request, $type, $id)
    {
        try {
            $model = $this->getModel($type);
            $item  = $model::onlyTrashed()->findOrFail($id);

            // Extra cleanup for products
            if ($type === 'products') {
                \App\Models\ProductSubImage::where('product_id', $id)->delete();
                \App\Models\ProductVariant::where('product_id', $id)->forceDelete();
            }

            $item->forceDelete();

            Log::info("Recycle Bin: {$type} #{$id} permanently deleted", ['admin' => auth()->id()]);

            return back()->with('success', "🗑️ " . ucfirst($type) . " #$id সম্পূর্ণরূপে Delete হয়েছে। আর Restore করা যাবে না।");
        } catch (\Exception $e) {
            return back()->with('error', '❌ Force delete failed: ' . $e->getMessage());
        }
    }

    /**
     * Empty entire Recycle Bin (all types permanently deleted)
     */
    public function emptyBin(Request $request)
    {
        $request->validate(['confirm' => 'required|in:DELETE']);

        $types  = ['products','users','orders','coupons','sliders','categories','pages'];
        $total  = 0;

        foreach ($types as $type) {
            $model = $this->getModel($type);
            $count = $model::onlyTrashed()->count();
            $model::onlyTrashed()->forceDelete();
            $total += $count;
        }

        Log::warning("Recycle Bin: EMPTIED by admin #{auth()->id()} — {$total} items permanently deleted");

        return back()->with('success', "🗑️ Recycle Bin সম্পূর্ণ খালি করা হয়েছে! {$total}টি item চিরতরে মুছে গেছে।");
    }

    /**
     * Get model class by type string
     */
    private function getModel(string $type): string
    {
        return match($type) {
            'products'   => Product::class,
            'users'      => User::class,
            'orders'     => Order::class,
            'coupons'    => Coupon::class,
            'sliders'    => Slider::class,
            'categories' => Category::class,
            'pages'      => Page::class,
            default      => throw new \InvalidArgumentException("Unknown type: $type"),
        };
    }
}
