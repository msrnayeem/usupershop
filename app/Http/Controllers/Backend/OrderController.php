<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommissionLedger;
use App\Models\Logo;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\Product;
use App\Traits\OrderAmountDistributionTrait;
use App\Traits\SendSmsTrait;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\CourierService;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use OrderAmountDistributionTrait;
    use SendSmsTrait;
    protected $courierService;

    public function __construct(CourierService $courierService)
    {
        $this->courierService = $courierService;
    }
    public function pendingList()
    {

        return view('backend.order.pending-list');
    }
    public function AllOrderList()
    {
        return view('backend.order.all-order-list');
    }
    public function PendingOrderList()
    {
        return view('backend.order.order-list', ['status' => 'pending']);
    }

    public function ConfirmedOrderList()
    {
        return view('backend.order.order-list', ['status' => 'confirmed']);
    }

    public function DeliveredOrderList()
    {
        return view('backend.order.order-list', ['status' => 'delivered']);
    }

    public function PackagingOrderList()
    {
        return view('backend.order.order-list', ['status' => 'packaging']);
    }

    public function ReturnOrderList()
    {
        return view('backend.order.order-list', ['status' => 'return']);
    }

    public function CanceledOrderList()
    {
        return view('backend.order.order-list', ['status' => 'canceled']);
    }
    public function SellerOrderList()
    {
        return view('backend.order.seller-order-list');
    }
    // public function pList(Request $request)
    // {
    //     $draw = $request->input("draw");
    //     $length = $request->input("length");
    //     $start = $request->input("start");
    //     $columns = $request->input('columns');
    //     $Data = [];
    //     $Result = Order::getPendingResult($start, $length, $columns);
    //     $sn = $start + 1;
    //     foreach ($Result as $key => $Res) {
    //         $DetailsRoute = route('pending.orders.details', $Res->id);
    //         $DeleteRoute = route('orders.delete', $Res->id);
    //         $action = "<a title='Deatails' class='btn btn-sm btn-info' href='$DetailsRoute'><i class='fas fa-eye'></i> Details</a>";
    //         $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
    //         $order_no = 'ODR-#' . ($Res->order_no);
    //         $order_total = ($Res->order_total);
    //         $newtime = strtotime($Res->created_at);
    //         $order_date = date('d-m-Y',$newtime);
    //         if ($Res->payment['payment_method'] == 'Bkash') {
    //             $payment = ($Res->payment['payment_method']);
    //         } else {
    //             if($Res->payment['payment_method'] === 'cod'){
    //                 $payment = 'Cash On Delivery';
    //             }
    //             else{
    //                 $payment = $Res->payment['payment_method'];
    //             }
    //         }
    //         if ($Res->status === 'confirmed') {
    //             $status = '<button type="button" class="btn btn-sm btn-primary">Confirmed</button>';
    //         } elseif($Res->status === 'canceled') {
    //             $status = '<button type="button" class="btn btn-sm btn-danger">Canceled</button>';
    //         }elseif($Res->status === 'packaging') {
    //             $status = '<button type="button" class="btn btn-sm btn-secondary">Packaging</button>';
    //         }elseif($Res->status === 'delivered') {
    //             $status = '<button type="button" class="btn btn-sm btn-success">Delivered</button>';
    //         }elseif($Res->status === 'return') {
    //             $status = '<button type="button" class="btn btn-sm btn-warning">Return</button>';
    //         }else{
    //             $status = '<button type="button" class="btn btn-sm btn-info">Pending</button>';
    //         }
    //         $Data[] = array(
    //             'sn' => $sn,
    //             'order_no' => $order_no,
    //             'order_total' => $order_total,
    //             'payment_id' => $payment,
    //             'order_date' => $order_date,
    //             'status' => $status,
    //             'action' => $action
    //         );
    //         $sn++;
    //     }
    //     $res = array(
    //         "draw" => $draw,
    //         "iTotalRecords" => Order::countResult($columns),
    //         "iTotalDisplayRecords" => Order::countResult($columns),
    //         "aaData" => $Data
    //     );

    //     return response()->json($res);
    // }
    public function deliveryList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Order::getDeliveredResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $DeleteRoute = route('orders.delete', $Res->id);
            // $action = "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            $action = "N/A";
            $order_no = 'ODR-#' . ($Res->order_no);
            $order_total = ($Res->order_total);
            $newtime = strtotime($Res->created_at);
            $order_date = date('d-m-Y', $newtime);

            if ($Res->payment['payment_method'] == 'Bkash') {
                $payment = ($Res->payment['payment_method']);
            } else {
                if ($Res->payment['payment_method'] === 'cod') {
                    $payment = 'Cash On Delivery';
                } else {
                    $payment = $Res->payment['payment_method'];
                }
            }
            if ($Res->status === 'confirmed') {
                $status = '<button type="button" class="btn btn-sm btn-primary">Confirmed</button>';
            } elseif ($Res->status === 'canceled') {
                $status = '<button type="button" class="btn btn-sm btn-danger">Canceled</button>';
            } elseif ($Res->status === 'packaging') {
                $status = '<button type="button" class="btn btn-sm btn-secondary">Packaging</button>';
            } elseif ($Res->status === 'shipment') {
                $status = '<button type="button" class="btn btn-sm btn-info">Shipment</button>';
            } elseif ($Res->status === 'delivered') {
                $status = '<button type="button" class="btn btn-sm btn-success">Delivered</button>';
            } elseif ($Res->status === 'return') {
                $status = '<button type="button" class="btn btn-sm btn-warning">Return</button>';
            } else {
                $status = '<button type="button" class="btn btn-sm btn-info">Pending</button>';
            }

            $Data[] = array(
                'sn' => $sn,
                'order_no' => $order_no,
                'order_total' => $order_total,
                'payment_id' => $payment,
                'order_date' => $order_date,
                'status' => $status,
                'action' => $action
            );
            $sn++;
        }
        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Order::countResult($columns),
            "iTotalDisplayRecords" => Order::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }
    public function deliveredList()
    {
        return view('backend.order.approved-list');
    }

    public function list(Request $request, $status = null)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];


        $query = Order::with('payment');

        // Apply route parameter status if provided
        if ($status) {
            $query->where('status', $status);
        }

        // Apply custom filters from DataTables AJAX
        if ($request->has('customFilter')) {
            $customFilter = $request->input('customFilter');
            
            if (!empty($customFilter['status'])) {
                $query->where('status', $customFilter['status']);
            }
            
            if (!empty($customFilter['src_from'])) {
                $query->whereDate('created_at', '>=', $customFilter['src_from']);
            }
            
            if (!empty($customFilter['src_to'])) {
                $query->whereDate('created_at', '<=', $customFilter['src_to']);
            }
        }

        $totalRecords = $query->count();
        $Result = $query->offset($start)->limit($length)->latest()->get();

        $sn = $start + 1;

        foreach ($Result as $Res) {
            $DetailsRoute = route('orders.details', $Res->id);
            $action = "<a title='Details' class='btn btn-sm btn-primary' href='$DetailsRoute'><i class='fas fa-eye'></i> Details</a>";

            $order_no = 'ODR-#' . ($Res->order_no);
            $order_total = $Res->order_total;
            $order_date = $Res->created_at->format('d-m-Y');

            // Payment method
            if ($Res->payment && $Res->payment->payment_method == 'Bkash') {
                $payment = 'Bkash';
            } elseif ($Res->payment && $Res->payment->payment_method == 'cod') {
                $payment = 'Cash On Delivery';
            } else {
                $payment = $Res->payment->payment_method ?? 'N/A';
            }

            // Status button
            switch ($Res->status) {
                case 'confirmed':
                    $statusBtn = '<button type="button" class="btn btn-sm btn-primary">Confirmed</button>';
                    break;
                case 'canceled':
                    $statusBtn = '<button type="button" class="btn btn-sm btn-danger">Canceled</button>';
                    break;
                case 'packaging':
                    $statusBtn = '<button type="button" class="btn btn-sm btn-secondary">Packaging</button>';
                    break;
                case 'shipment':
                    $statusBtn = '<button type="button" class="btn btn-sm btn-info">Shipment</button>';
                    break;
                case 'delivered':
                    $statusBtn = '<button type="button" class="btn btn-sm btn-success">Delivered</button>';
                    break;
                case 'return':
                    $statusBtn = '<button type="button" class="btn btn-sm btn-warning">Return</button>';
                    break;
                default:
                    $statusBtn = '<button type="button" class="btn btn-sm btn-info">Pending</button>';
                    break;
            }

            // Checkbox
            if ($Res->status != 'return') {
                $check_box = '<input type="checkbox" name="oder_id" class="checkedOrds" value="' . $Res->order_no . '" style="width:17px;height:17px;">';
            } else {
                $check_box = '<input type="checkbox" disabled="disabled" checked="checked" style="width:17px;height:17px;">';
            }

            $Data[] = [
                'check_box' => $check_box,
                'sn' => $sn,
                'order_no' => $order_no,
                'order_total' => $order_total,
                'payment_id' => $payment,
                'order_date' => $order_date,
                'status' => $statusBtn,
                'action' => $action
            ];

            $sn++;
        }

        $res = [
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $Data
        ];

        return response()->json($res);
    }

    public function vendorOrSellerOrderlist(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];
        $Result = Order::getSellerPendingResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $DetailsRoute = route('orders.details', $Res->id);
            $action = "<a title='Deatails' class='btn btn-sm btn-primary' href='$DetailsRoute'><i class='fas fa-eye'></i>
                Details</a>";
            $order_no = 'ODR-#' . ($Res->id);
            $order_total = ($Res->order_total);
            $newtime = strtotime($Res->created_at);
            $order_date = date('d-m-Y', $newtime);

            // Safe payment method access
            $payment = 'N/A';
            if ($Res->payment) {
                if ($Res->payment->payment_method == 'Bkash') {
                    $payment = 'Bkash';
                } elseif ($Res->payment->payment_method === 'cod') {
                    $payment = 'Cash On Delivery';
                } else {
                    $payment = $Res->payment->payment_method;
                }
            }

            // Status buttons
            if ($Res->status === 'confirmed') {
                $status = '<button type="button" class="btn btn-sm btn-primary">Confirmed</button>';
            } elseif ($Res->status === 'canceled') {
                $status = '<button type="button" class="btn btn-sm btn-danger">Canceled</button>';
            } elseif ($Res->status === 'packaging') {
                $status = '<button type="button" class="btn btn-sm btn-secondary">Packaging</button>';
            } elseif ($Res->status === 'shipment') {
                $status = '<button type="button" class="btn btn-sm btn-info">Shipment</button>';
            } elseif ($Res->status === 'delivered') {
                $status = '<button type="button" class="btn btn-sm btn-success">Delivered</button>';
            } elseif ($Res->status === 'return') {
                $status = '<button type="button" class="btn btn-sm btn-warning">Return</button>';
            } else {
                $status = '<button type="button" class="btn btn-sm btn-info">Pending</button>';
            }

            // Checkbox logic
            if ($Res->status != 'return') {
                $check_box = '<input type="checkbox" name="oder_id" class="checkedOrds" value="' . $Res->id . '" style="width:17px;height:17px;">';
            } else {
                $check_box = '<input type="checkbox" disabled="disabled" checked="checked" style="width:17px;height:17px;">';
            }

            // Safe shop name access
            $shop_name = "Own Shop";
            $commission = "0%";
            if (!empty($Res->shop_id)) {
                $shop = User::find($Res->shop_id);
                if ($shop) {
                    $shop_name = $shop->shop_name ?? 'Unknown Shop';
                    $commission = isset($shop->commission) ? $shop->commission . '%' : '0%';
                }
            }

            $Data[] = array(
                'check_box' => $check_box,
                'sn' => $sn,
                'order_no' => $order_no,
                'order_total' => $order_total,
                'payment_id' => $payment,
                'order_date' => $order_date,
                'shop' => $shop_name,
                'commission' => $commission,
                'status' => $status,
                'action' => $action
            );
            $sn++;
        }
        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Order::countResultTotal($columns),
            "iTotalDisplayRecords" => Order::countResultTotal($columns),
            "aaData" => $Data
        );
        return response()->json($res);
    }

    public function pendingDetails($id)
    {
         $data['logo'] = Logo::first();
        $data['order'] = Order::with([
            'order_details',
            'order_details.product',
            'order_details.product_color.color',
            'order_details.product_size.size'
        ])->find($id);
        return view('backend.order.pending-order-details', $data);
    }
    public function printOrder($id)
    {
         $data['logo'] = Logo::first();
        $data['order'] = Order::with([
            'order_details',
            'order_details.product',
            'order_details.product_color.color',
            'order_details.product_size.size'
        ])->find($id);
        $pdf = Pdf::loadView('backend.order.print-pending-order-details', $data);
        return $pdf->stream('pending-order.pdf');
        // this returns a proper PDF response
    }

    public function details($id)
    {
        $data['logo'] = Logo::first();
        $data['order'] = Order::with([
            'order_details',
            'order_details.product',
            'order_details.product_color.color',
            'order_details.product_size.size'
        ])->find($id);

        return view('backend.order.order-details', $data);
    }



    public function approve(Request $request)
    {
        $order = Order::find($request->id);
        $order->update(['status' => 'delivered']);
        return redirect()->route('orders.pending.list')->with('success', 'Data approved successfully');
    }


    // Status Update here............
    public function statusUpdate(Request $request)
    {
        $delivery_status = $request->status;
        $selectedODRs = $request->selectedODRs;

        if ($delivery_status == "" || $selectedODRs == "" || count($selectedODRs) == 0) {
            $res = ['message' => "Select Order Status and Order IDs !!!"];
            return response($res, 203)->header('Content-Type', 'application/json');
        }

        DB::beginTransaction();

        try {
            // Get all orders by order_no
            $orders = Order::whereIn('order_no', $selectedODRs)->get();

            if ($orders->isEmpty()) {
                DB::rollBack();
                $res = ['message' => "No orders found with the selected IDs!"];
                return response($res, 203)->header('Content-Type', 'application/json');
            }

            // Check if timestamp columns exist in the orders table
            $hasTimestampColumns = \Schema::hasColumns('orders', [
                'confirmed_at', 'packaging_at', 'shipment_at', 
                'delivered_at', 'returned_at', 'canceled_at'
            ]);

            foreach ($orders as $order) {
                $order->status = $delivery_status;
                
                // Set status timestamp based on the new status (only if columns exist)
                if ($hasTimestampColumns) {
                    try {
                        switch ($delivery_status) {
                            case 'confirmed':
                                if (!$order->confirmed_at) {
                                    $order->confirmed_at = now();
                                }
                                break;
                            case 'packaging':
                                if (!$order->packaging_at) {
                                    $order->packaging_at = now();
                                }
                                break;
                            case 'shipment':
                                if (!$order->shipment_at) {
                                    $order->shipment_at = now();
                                }
                                break;
                            case 'delivered':
                                if (!$order->delivered_at) {
                                    $order->delivered_at = now();
                                }
                                break;
                            case 'return':
                                if (!$order->returned_at) {
                                    $order->returned_at = now();
                                }
                                break;
                            case 'canceled':
                                if (!$order->canceled_at) {
                                    $order->canceled_at = now();
                                }
                                break;
                        }
                    } catch (\Exception $e) {
                        // Log the error but continue with status update
                        Log::warning('Failed to update timestamp for order', [
                            'order_id' => $order->id,
                            'status' => $delivery_status,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
                
                $order->save();
                
                // Send SMS notifications based on status change
                try {
                    if ($delivery_status === 'canceled') {
                        $this->sendOrderCancelledSms($order);
                    } elseif ($delivery_status === 'confirmed') {
                        $this->sendOrderConfirmedSms($order);
                    } elseif ($delivery_status === 'packaging' || $delivery_status === 'processing') {
                        $this->sendOrderProcessingSms($order);
                    } elseif ($delivery_status === 'shipment') {
                        $this->sendOrderShipmentSms($order);
                    } elseif ($delivery_status === 'delivered') {
                        $this->sendOrderDeliveredSms($order);
                    } elseif ($delivery_status === 'return') {
                        $this->sendOrderReturnSms($order);
                    }
                } catch (\Exception $e) {
                    Log::error('Failed to send order status SMS', [
                        'order_id' => $order->id,
                        'status' => $delivery_status,
                        'error' => $e->getMessage()
                    ]);

                // ── Admin WhatsApp notify on delivery/cancel ──────────────
                try {
                    if (in_array($delivery_status, ['delivered', 'canceled', 'return'])) {
                        $wa = new \App\Services\WhatsAppService();
                        $wa->sendOrderStatusNotification($order, $delivery_status);
                    }
                } catch (\Exception $waEx) {
                    Log::warning('Admin WhatsApp order status notify failed: ' . $waEx->getMessage());
                }
                }

                // ── DELIVERED: distribute all commissions ──────────────────
                if ($delivery_status === 'delivered') {
                    try {
                        // Vendor gets 80%, Seller gets their % from admin's 20%
                        $this->order_amount_distribution($order);
                    } catch (\Exception $e) {
                        Log::error('Failed to distribute order amount', [
                            'order_id' => $order->id,
                            'error' => $e->getMessage()
                        ]);
                    }

                    // ── Seller Share Link Commission ──────────────────────────
                    // If order came via seller's share link → give 10% commission
                    if (!empty($order->seller_ref_id) && $order->seller_ref_paid == 0) {
                        try {
                            $this->distributeSellerRefCommission($order);
                        } catch (\Exception $e) {
                            Log::error('Seller ref commission failed', [
                                'order_id' => $order->id,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }

                    // Dropshipper profit — add on delivered (not at order time)
                    if ($order->dropshipper_id && $order->dropshipper_profit > 0) {
                        try {
                            $this->distributeDropshipperProfit($order);
                        } catch (\Exception $e) {
                            Log::error('Failed to distribute dropshipper profit', [
                                'order_id' => $order->id,
                                'error' => $e->getMessage()
                            ]);
                        }
                    }
                }

                // ── CANCELED or RETURN: reverse all commissions ────────────
                if ($delivery_status === 'canceled' || $delivery_status === 'return') {
                    // Reverse seller ref commission if paid
                    if (!empty($order->seller_ref_id) && $order->seller_ref_paid == 1) {
                        try {
                            $this->reverseSellerRefCommission($order);
                        } catch (\Exception $e) {
                            Log::error('Seller ref commission reversal failed', ['order_id' => $order->id, 'error' => $e->getMessage()]);
                        }
                    }
                    try {
                        $this->reverseOrderCommissions($order);
                    } catch (\Exception $e) {
                        Log::error('Failed to reverse commissions', [
                            'order_id' => $order->id,
                            'status' => $delivery_status,
                            'error' => $e->getMessage()
                        ]);
                    }
                }
            }

            DB::commit();

            $res = ['message' => "Order status updated successfully! Total orders updated: " . $orders->count()];
            return response($res, 202)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order status update failed', [
                'status' => $delivery_status,
                'orders' => $selectedODRs,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            $res = ['message' => "Failed to update status: " . $e->getMessage()];
            return response($res, 500)->header('Content-Type', 'application/json');
        }
    }

    // Commission distribution is handled by OrderAmountDistributionTrait::order_amount_distribution()
    // Admin keeps 20%, Vendor gets 80%, Seller gets their % from admin's 20% share

    /**
     * Add dropshipper profit to their balance when order is delivered.
     */
    private function distributeDropshipperProfit(Order $order): void
    {
        // Prevent duplicate
        $alreadyPaid = \App\Models\DropshipperProfit::where('order_id', $order->id)
            ->where('status', 'paid')
            ->exists();

        if ($alreadyPaid) {
            Log::info('Dropshipper profit already paid', ['order_id' => $order->id]);
            return;
        }

        $dropshipper = User::find($order->dropshipper_id);
        if (!$dropshipper) return;

        $profit = floatval($order->dropshipper_profit);
        if ($profit <= 0) return;

        // Add to dropshipper balance
        $dropshipper->increment('balance', $profit);

        // ── Transaction log for dropshipper profit ─────────────────
        \App\Models\Transaction::create([
            'user_id'      => $order->dropshipper_id,
            'from_user_id' => $order->user_id,
            'wallet_type'  => 1, // balance wallet
            'tnx_type'     => 7, // dropshipper profit (add to constants if needed)
            'credit'       => $profit,
            'debit'        => 0,
            'note'         => 'Dropshipper Profit — Order: ' . ($order->order_no ?? $order->id),
            'description'  => json_encode(['order_id' => (string)$order->id]),
            'status'       => 1,
            'in_status'    => 1,
            'date'         => time(),
        ]);

        // Record in DropshipperProfit
        \App\Models\DropshipperProfit::updateOrCreate(
            ['order_id' => $order->id],
            [
                'dropshipper_id' => $order->dropshipper_id,
                'total_profit'   => $profit,
                'status'         => 'paid',
                'paid_at'        => now(),
            ]
        );

        // Transaction record
        Transaction::create([
            'user_id'      => $order->dropshipper_id,
            'from_user_id' => $order->user_id,
            'wallet_type'  => \App\Utilities\Constant::WALLET_TYPE['balance_wallet'],
            'tnx_type'     => \App\Utilities\Constant::TRANSACTION_TYPE['product_seles'],
            'credit'       => $profit,
            'debit'        => 0,
            'note'         => 'Dropshipper profit from Order No: ' . $order->order_no,
            'description'  => json_encode(['order_id' => $order->id, 'order_no' => $order->order_no]),
            'status'       => \App\Utilities\Constant::STATUS['approved'],
            'in_status'    => \App\Utilities\Constant::IN_STATUS['active'],
            'date'         => time(),
        ]);

        Log::info('Dropshipper profit added on delivery', [
            'order_id'       => $order->id,
            'dropshipper_id' => $order->dropshipper_id,
            'profit'         => $profit,
        ]);
    }

    /**
     * Reverse all commissions when order is canceled or returned.
     * Deducts from: vendor balance, seller (reseller) balance, dropshipper balance.
     * Only reverses if commission was already paid (transaction exists).
     */
    private function reverseOrderCommissions(Order $order): void
    {
        $orderNo = $order->order_no;
        $note    = 'Commission reversed — Order ' . $orderNo . ' (' . ucfirst($order->status) . ')';

        // ── 1. Find all credit transactions for this order ─────────────
        $paid = Transaction::where('description', 'LIKE', '%"order_id":"' . $order->id . '"%')
            ->whereIn('tnx_type', [
                \App\Utilities::Constant::TRANSACTION_TYPE['product_seles'],
                \App\Utilities::Constant::TRANSACTION_TYPE['reseller_seles_commission'],
            ])
            ->where('credit', '>', 0)
            ->get();

        foreach ($paid as $txn) {
            $user = User::find($txn->user_id);
            if (!$user) continue;

            $amount = floatval($txn->credit);
            if ($amount <= 0) continue;

            // Deduct from user balance (don't go below 0)
            $deductable = min($amount, floatval($user->balance));
            if ($deductable > 0) {
                $user->decrement('balance', $deductable);
            }

            // Also reverse sales_amount / reseller_commission_amount counters
            if ($txn->tnx_type == \App\Utilities::Constant::TRANSACTION_TYPE['product_seles']) {
                $user->decrement('sales_amount', min($amount, floatval($user->sales_amount)));
            }
            if ($txn->tnx_type == \App\Utilities::Constant::TRANSACTION_TYPE['reseller_seles_commission']) {
                $user->decrement('reseller_commission_amount', min($amount, floatval($user->reseller_commission_amount)));
            }

            // Create reversal debit transaction
            Transaction::create([
                'user_id'      => $txn->user_id,
                'from_user_id' => $order->user_id,
                'wallet_type'  => \App\Utilities::Constant::WALLET_TYPE['balance_wallet'],
                'tnx_type'     => $txn->tnx_type,
                'credit'       => 0,
                'debit'        => $deductable,
                'note'         => $note,
                'description'  => json_encode(['order_id' => $order->id, 'order_no' => $orderNo, 'reversed_txn_id' => $txn->id]),
                'status'       => \App\Utilities::Constant::STATUS['approved'],
                'in_status'    => \App\Utilities::Constant::IN_STATUS['active'],
                'date'         => time(),
            ]);

            Log::info('Commission reversed for user', [
                'order_id' => $order->id,
                'user_id'  => $txn->user_id,
                'amount'   => $deductable,
            ]);
        }

        // ── 2. Reverse dropshipper profit if paid ──────────────────────
        $dropProfit = \App\Models\DropshipperProfit::where('order_id', $order->id)
            ->where('status', 'paid')
            ->first();

        if ($dropProfit && $order->dropshipper_id) {
            $dropshipper = User::find($order->dropshipper_id);
            if ($dropshipper) {
                $profit     = floatval($dropProfit->total_profit);
                $deductable = min($profit, floatval($dropshipper->balance));

                if ($deductable > 0) {
                    $dropshipper->decrement('balance', $deductable);
                }

                // Mark profit as reversed
                $dropProfit->update(['status' => 'reversed']);

                // Reversal transaction
                Transaction::create([
                    'user_id'      => $order->dropshipper_id,
                    'from_user_id' => $order->user_id,
                    'wallet_type'  => \App\Utilities::Constant::WALLET_TYPE['balance_wallet'],
                    'tnx_type'     => \App\Utilities::Constant::TRANSACTION_TYPE['product_seles'],
                    'credit'       => 0,
                    'debit'        => $deductable,
                    'note'         => 'Dropshipper profit reversed — Order ' . $orderNo . ' (' . ucfirst($order->status) . ')',
                    'description'  => json_encode(['order_id' => $order->id, 'order_no' => $orderNo]),
                    'status'       => \App\Utilities::Constant::STATUS['approved'],
                    'in_status'    => \App\Utilities::Constant::IN_STATUS['active'],
                    'date'         => time(),
                ]);

                Log::info('Dropshipper profit reversed', [
                    'order_id'       => $order->id,
                    'dropshipper_id' => $order->dropshipper_id,
                    'amount'         => $deductable,
                ]);
            }
        }

        // ── 3. Mark DropshipperProfit as reversed even if balance was 0 ─
        \App\Models\DropshipperProfit::where('order_id', $order->id)
            ->where('status', 'paid')
            ->update(['status' => 'reversed']);
    }


    public function VendorOrSellerstatusUpdate(Request $request)
    {
        $delivery_status = $request->status;
        $selectedODRs = $request->selectedODRs;

        if ($delivery_status == "" || $selectedODRs == "" || count($selectedODRs) == 0) {
            $res = ['message' => "Select Order Status and Order IDs !!!"];
            return response($res, 203)->header('Content-Type', 'application/json');
        }

        DB::beginTransaction();

        try {
            $order = Order::whereIn('order_no', $selectedODRs)->first();

            if (!$order) {
                DB::rollBack();
                $res = ['message' => "Something wrong !"];
                return response($res, 203)->header('Content-Type', 'application/json');
            }

            $order->status = $delivery_status;
            $order->save();

            if ($delivery_status === 'delivered') {
                $this->order_amount_distribution($order);
            }

            DB::commit();

            $res = ['message' => "Order status updated successfully !"];
            return response($res, 202)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            DB::rollBack();

            $res = ['message' => "Failed to update status. Please try again."];
            return response($res, 500)->header('Content-Type', 'application/json');
        }
    }

    // Order Commission cose here............
    public function orderCommission()
    {
        return view('backend.order.order_commission_list');
    }

    public function orderCommissionList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = CommissionLedger::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $order_id = "ORD-" . ($Res->order_id);

            $newtime = strtotime($Res->entry_date);
            $comm_date = date('d-m-Y', $newtime);

            $reseller_id = ($Res->reseller_id);
            $debit_balance = ($Res->debit_balance);
            $credit_balance = ($Res->credit_balance);
            $payment_mood = ($Res->payment_mood);
            $reference = ($Res->reference);
            if ($reseller_id) {
                $shop = User::where('id', $reseller_id)->first();
                $shop_name = !empty($Res->shop) ? ($Res->shop->shop_name ?? 'Unknown Shop') : 'Unknown Shop';
            } else {
                $shop = "Own Shop";
            }


            $Data[] = array(
                'sn' => $sn,
                'order_id' => $order_id,
                'reseller_id' => $reseller_id,
                'debit_balance' => $debit_balance,
                'credit_balance' => $credit_balance,
                'payment_mood' => $payment_mood,
                'reference' => $reference,
                'comm_date' => $comm_date
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => CommissionLedger::count(),
            "iTotalDisplayRecords" => CommissionLedger::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    ///Seller wise commission code here.....
    public function sellerWiseCommission()
    {
        return view('backend.order.seller_wise_commission_list');
    }

    public function sellerWiseCommissionList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = CommissionLedger::getSellerWiseResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            //$DetailsRoute = route('orders.details', $Res->id);
            /* $DeleteRoute = route('orders.delete'); */

            $action = "<a href='#' title='Seller Commission' class='btn btn-sm btn-primary' onclick='openCommissionModal(" . $Res->reseller_id . ")' data=''><i class='fas fa-check'></i> Seller Commission</a>";

            $order_id = "ORD-" . ($Res->order_id);

            $newtime = strtotime($Res->entry_date);
            $comm_date = date('d-m-Y', $newtime);

            $reseller_id = ($Res->reseller_id);
            $total_debit = ($Res->total_debit);
            $total_credit = ($Res->total_credit);
            if ($reseller_id) {
                $shop = isset($Res->shop) && isset($Res->shop['name']) ? $Res->shop['name'] : 'Unknown Shop';
            } else {
                $shop = "Own Shop";
            }


            $Data[] = array(
                'sn' => $sn,
                'reseller_id' => $shop,
                'debit_balance' => $total_debit,
                'credit_balance' => $total_credit,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => CommissionLedger::count(),
            "iTotalDisplayRecords" => CommissionLedger::countSellerWiseResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function addSellerPayment(Request $request)
    {

        $seller_id = $request->seller_id;
        $amount = $request->amount;
        $payment_mood = $request->payment_mood;
        $reference_no = $request->reference_no;
        $account_no = $request->account_no;
        $comments = $request->comments;


        if ($seller_id == "" || $amount == "") {
            $res = ['message' => "Please enter amount !!!"];
            return response($res, 203)->header('Content-Type', 'application/json');
        }

        if ($amount == 0) {
            $res = ['message' => "Please enter amount is greater than 0 !"];
            return response($res, 203)->header('Content-Type', 'application/json');
        }

        $data = array(
            'reseller_id' => $seller_id,
            'entry_date' => now(),
            'order_id' => 11,
            'debit_balance' => $amount,
            'payment_mood' => $payment_mood,
            'reference' => $reference_no,
            'created_at' => now(),
        );

        $dataInsert = CommissionLedger::insert($data);

        if ($dataInsert) {
            $seller_info = User::find($seller_id);
            $commission_balance = $seller_info->balance - $amount;
            $updateBalance = User::where('id', $seller_id)->update(['balance' => $commission_balance]);
            if ($updateBalance) {
                $res = ['message' => "Payment submitted successfully !"];
                return response($res, 202)->header('Content-Type', 'application/json');
            } else {
                $res = ['message' => "Something wrong !"];
                return response($res, 203)->header('Content-Type', 'application/json');
            }
        }
    }
    public function delete($id)
    {
        $orders = Order::find($id);
        $orders->delete();
        return redirect()->route('orders.all.list')->with('success', 'Data deleted successfully !');
    }
    /**
     * Assign single order to courier
     */
    public function assignCourier(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'courier_id' => 'required|string',
            'priority' => 'nullable|string',
            'notes' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $order = Order::where('order_no', $request->order_id)->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            if (!in_array($order->status, ['pending', 'confirmed'])) {
                return response()->json(['message' => 'Only pending or confirmed orders can be assigned to courier'], 400);
            }

            // Send to courier API
            $courierResult = $this->courierService->sendToCourier(
                $order,
                $request->courier_id,
                $request->priority ?? 'normal',
                $request->notes
            );

            if (!$courierResult['success']) {
                throw new \Exception($courierResult['message']);
            }

            // Update order with courier information
            $order->update([
                'courier_id' => $request->courier_id,
                'courier_priority' => $request->priority ?? 'normal',
                'courier_notes' => $request->notes,
                'courier_tracking_id' => $courierResult['tracking_id'] ?? null,
                'courier_response' => json_encode($courierResult['response'] ?? []),
                'status' => 'packaging', // Change status to packaging when sent to courier
                'courier_assigned_at' => now(),
                'courier_assigned_by' => Auth::id()
            ]);

            // Log the courier assignment
            Log::info('Order assigned to courier via API', [
                'order_no' => $order->order_no,
                'courier_id' => $request->courier_id,
                'tracking_id' => $courierResult['tracking_id'] ?? null,
                'assigned_by' => Auth::id(),
                'assigned_at' => now()
            ]);

            DB::commit();

            return response()->json([
                'message' => $courierResult['message'],
                'tracking_id' => $courierResult['tracking_id'] ?? null,
                'order' => $order
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Courier assignment failed', [
                'error' => $e->getMessage(),
                'order_id' => $request->order_id,
                'courier_id' => $request->courier_id
            ]);

            return response()->json([
                'message' => 'Failed to assign order to courier: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bulk assign orders to courier
     */
    public function bulkAssignCourier(Request $request)
    {
        $request->validate([
            'courier_id' => 'required|string',
            'orders' => 'required|array|min:1',
            'orders.*' => 'exists:orders,order_no',
            'priority' => 'nullable|string'
        ]);

        DB::beginTransaction();
        try {
            $orders = Order::whereIn('order_no', $request->orders)
                ->whereIn('status', ['pending', 'confirmed'])
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['message' => 'No eligible orders found'], 400);
            }

            // Send orders to courier API
            $courierResult = $this->courierService->bulkSendToCourier(
                $orders,
                $request->courier_id,
                $request->priority ?? 'normal'
            );

            // Update successful orders
            foreach ($orders as $order) {
                $orderResult = collect($courierResult['details'])->firstWhere('order_no', $order->order_no);

                if ($orderResult && $orderResult['result']['success']) {
                    $order->update([
                        'courier_id' => $request->courier_id,
                        'courier_priority' => $request->priority ?? 'normal',
                        'courier_tracking_id' => $orderResult['result']['tracking_id'] ?? null,
                        'courier_response' => json_encode($orderResult['result']['response'] ?? []),
                        'status' => 'packaging',
                        'courier_assigned_at' => now(),
                        'courier_assigned_by' => Auth::id()
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'message' => $courierResult['message'],
                'details' => $courierResult['details']
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Bulk courier assignment failed', [
                'error' => $e->getMessage(),
                'courier_id' => $request->courier_id,
                'orders_count' => count($request->orders)
            ]);

            return response()->json([
                'message' => 'Failed to assign orders to courier: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Track courier order
     */
    public function trackCourierOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required'
        ]);

        $order = Order::where('order_no', $request->order_id)->first();

        if (!$order || !$order->courier_id || !$order->courier_tracking_id) {
            return response()->json(['message' => 'Order not found or not assigned to courier'], 404);
        }

        $trackingResult = $this->courierService->trackOrder(
            $order->courier_id,
            $order->courier_tracking_id
        );

        if ($trackingResult['success']) {
            return response()->json([
                'message' => 'Tracking information retrieved',
                'tracking_data' => $trackingResult['data'],
                'order' => $order
            ], 200);
        }

        return response()->json([
            'message' => $trackingResult['message']
        ], 400);
    }

    /**
     * Get courier cities (for Pathao)
     */
    public function getCourierCities(Request $request)
    {
        $courierId = $request->get('courier_id');

        if ($courierId === 'pathao') {
            $cities = $this->courierService->getPathaoCities();
            return response()->json(['cities' => $cities]);
        }

        return response()->json(['cities' => []], 404);
    }

    /**
     * Get courier zones (for Pathao)
     */
    public function getCourierZones(Request $request)
    {
        $courierId = $request->get('courier_id');
        $cityId = $request->get('city_id');

        if ($courierId === 'pathao' && $cityId) {
            $zones = $this->courierService->getPathaoZones($cityId);
            return response()->json(['zones' => $zones]);
        }

        return response()->json(['zones' => []], 404);
    }
    /**
     * Update pList method to include checkbox column
     */
    public function pList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];
        $Result = Order::getPendingResult($start, $length, $columns);
        $sn = $start + 1;

        foreach ($Result as $key => $Res) {
            $DetailsRoute = route('orders.details', $Res->id);
            $DeleteRoute = route('orders.delete', $Res->id);

            // Updated action buttons with courier assignment
            $action = "<a title='Details' class='btn btn-sm btn-info mr-1' href='$DetailsRoute'><i class='fas fa-eye'></i> Details</a>";

            if ($Res->courier_id) {
                // Show courier info if already assigned
                $courierName = ucfirst(str_replace('_', ' ', $Res->courier_id));
                $action .= "<span class='badge badge-success' title='Assigned to {$courierName}'><i class='fas fa-shipping-fast'></i> {$courierName}</span>";
            } else {
                // Show courier assignment button if not assigned
                $action .= "<button title='Send to Courier' class='btn btn-sm btn-success courier-btn ml-1' onclick='openCourierModal(" . json_encode($Res) . ")'>";
                $action .= "<i class='fas fa-shipping-fast'></i> Courier</button>";
            }

            $order_no = 'ODR-#' . ($Res->order_no);
            $order_total = ($Res->order_total);
            $newtime = strtotime($Res->created_at);
            $order_date = date('d-m-Y', $newtime);

            if ($Res->payment['payment_method'] == 'Bkash') {
                $payment = ($Res->payment['payment_method']);
            } else {
                if ($Res->payment['payment_method'] === 'cod') {
                    $payment = 'Cash On Delivery';
                } else {
                    $payment = $Res->payment['payment_method'];
                }
            }

            if ($Res->status === 'confirmed') {
                $status = '<button type="button" class="btn btn-sm btn-primary">Confirmed</button>';
            } elseif ($Res->status === 'canceled') {
                $status = '<button type="button" class="btn btn-sm btn-danger">Canceled</button>';
            } elseif ($Res->status === 'packaging') {
                $status = '<button type="button" class="btn btn-sm btn-secondary">Packaging</button>';
            } elseif ($Res->status === 'shipment') {
                $status = '<button type="button" class="btn btn-sm btn-info">Shipment</button>';
            } elseif ($Res->status === 'delivered') {
                $status = '<button type="button" class="btn btn-sm btn-success">Delivered</button>';
            } elseif ($Res->status === 'return') {
                $status = '<button type="button" class="btn btn-sm btn-warning">Return</button>';
            } else {
                $status = '<button type="button" class="btn btn-sm btn-info">Pending</button>';
            }

            // Add checkbox for bulk selection
            $checkbox = '<input type="checkbox" class="order-checkbox" value="' . $Res->order_no . '" data-order=\'' . json_encode([
                'order_no' => $order_no,
                'order_total' => $order_total,
                'payment_id' => $payment,
                'order_date' => $order_date
            ]) . '\'>';

            $Data[] = array(
                'checkbox' => $checkbox,
                'sn' => $sn,
                'order_no' => $order_no,
                'order_total' => $order_total,
                'payment_id' => $payment,
                'order_date' => $order_date,
                'status' => $status,
                'action' => $action
            );
            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Order::countResult($columns),
            "iTotalDisplayRecords" => Order::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function courierOrders()
    {
        return view('backend.order.courier_orders');
    }

    public function courierOrdersData(Request $request)
    {
        $orders = Order::whereNotNull('courier_id')
            ->whereIn('status', ['confirmed', 'packaging', 'shipment', 'delivered'])
            ->latest();

        return datatables()->of($orders)
            ->addIndexColumn()
            ->addColumn('checkbox', function ($row) {
                return '<input type="checkbox" class="checkedOrds order-checkbox" value="' . $row->order_no . '">';
            })
            ->editColumn('order_no', function($row){
                return 'ODR-#' . $row->order_no;
            })
            ->editColumn('order_total', fn($row) => '৳' . number_format($row->order_total, 2))
            ->addColumn('payment_id', function ($row) {
                 if ($row->payment['payment_method'] == 'Bkash') {
                    return $row->payment['payment_method'];
                } else {
                    return $row->payment['payment_method'] === 'cod' ? 'Cash On Delivery' : ($row->payment['payment_method'] ?? 'N/A');
                }
            })
            ->editColumn('order_date', fn($row) => $row->created_at->format('d-m-Y'))
            ->editColumn('status', function($row){
                if ($row->status === 'confirmed') {
                    return '<button type="button" class="btn btn-sm btn-primary">Confirmed</button>';
                } elseif ($row->status === 'packaging') {
                    return '<button type="button" class="btn btn-sm btn-secondary">Packaging</button>';
                } elseif ($row->status === 'shipment') {
                    return '<button type="button" class="btn btn-sm btn-info">Shipment</button>';
                } elseif ($row->status === 'delivered') {
                    return '<button type="button" class="btn btn-sm btn-success">Delivered</button>';
                } elseif ($row->status === 'return') {
                    return '<button type="button" class="btn btn-sm btn-warning">Return</button>';
                } else {
                    return '<button type="button" class="btn btn-sm btn-info">Pending</button>';
                }
            })
            ->addColumn('action', function ($row) {
                return '<a href="' . route('orders.details', $row->id) . '" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Details</a>';
            })
            ->rawColumns(['checkbox', 'status', 'action'])
            ->make(true);
    }




    /**
     * Seller share link commission — 10% of order total on delivery
     */
    private function distributeSellerRefCommission(Order $order): void
    {
        if (empty($order->seller_ref_id)) return;

        // Prevent double payment
        if ($order->seller_ref_paid == 1) return;

        $seller = User::find($order->seller_ref_id);
        if (!$seller || $seller->status != 1 || $seller->payment_status != 1) return;

        $commissionRate = 10; // 10% of order total
        $commissionAmt  = round((float)$order->order_total * $commissionRate / 100, 2);
        if ($commissionAmt <= 0) return;

        $seller->increment('balance', $commissionAmt);
        $seller->increment('refer_commission', $commissionAmt);

        \App\Models\Transaction::create([
            'user_id'      => $seller->id,
            'from_user_id' => $order->user_id,
            'wallet_type'  => 1,
            'tnx_type'     => \App\Utilities::Constant::TRANSACTION_TYPE['refer_commission'],
            'credit'       => $commissionAmt,
            'debit'        => 0,
            'note'         => "Share Link Commission (10%) — Order: " . ($order->order_no ?? $order->id),
            'description'  => json_encode(['order_id' => (string)$order->id, 'type' => 'seller_share_link']),
            'status'       => \App\Utilities::Constant::STATUS['approved'],
            'in_status'    => \App\Utilities::Constant::IN_STATUS['active'],
            'date'         => time(),
        ]);

        // Mark as paid
        $order->update(['seller_ref_commission' => $commissionAmt, 'seller_ref_paid' => 1]);

        Log::info('Seller share link commission paid', [
            'seller_id'  => $seller->id,
            'order_id'   => $order->id,
            'commission' => $commissionAmt,
        ]);
    }

    /**
     * Reverse seller share link commission on cancel/return
     */
    private function reverseSellerRefCommission(Order $order): void
    {
        if (empty($order->seller_ref_id) || $order->seller_ref_paid != 1) return;

        $seller = User::find($order->seller_ref_id);
        if (!$seller) return;

        $commissionAmt = (float)$order->seller_ref_commission;
        if ($commissionAmt <= 0) return;

        $newBalance = max(0, ($seller->balance ?? 0) - $commissionAmt);
        $newRefer   = max(0, ($seller->refer_commission ?? 0) - $commissionAmt);
        $seller->update(['balance' => $newBalance, 'refer_commission' => $newRefer]);

        \App\Models\Transaction::create([
            'user_id'      => $seller->id,
            'from_user_id' => $order->user_id,
            'wallet_type'  => 1,
            'tnx_type'     => \App\Utilities\Constant::TRANSACTION_TYPE['refer_commission'],
            'credit'       => 0,
            'debit'        => $commissionAmt,
            'note'         => "Share Link Commission Reversed — Order Cancelled: " . ($order->order_no ?? $order->id),
            'description'  => json_encode(['order_id' => (string)$order->id, 'type' => 'seller_share_link_reverse']),
            'status'       => \App\Utilities\Constant::STATUS['approved'],
            'in_status'    => \App\Utilities\Constant::IN_STATUS['active'],
            'date'         => time(),
        ]);

        $order->update(['seller_ref_paid' => 0]);

        Log::info('Seller share link commission reversed', [
            'seller_id' => $seller->id,
            'order_id'  => $order->id,
            'reversed'  => $commissionAmt,
        ]);
    }

}