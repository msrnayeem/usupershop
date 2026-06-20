<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponRequest;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function view()
    {
        $data['allData'] = Coupon::select('id', 'name', 'promoCode', 'start_date', 'end_date', 'discount_type', 'discount_amount', 'min_amount', 'created_by', 'status')->orderBy('id', 'DESC')->get();
        return view('backend.coupon.view-coupon', $data);
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Coupon::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $EditRoute = route('coupons.edit', $Res->id);
            $DeleteRoute = route('coupons.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";

            if ($Res->discount_type == 1) {
                $discount_type = 'Percentage';
            } else {
                $discount_type = 'Fixed Amount';
            }

            if ($Res->discount_type == 1) {
                $discount_amount = ($Res->discount_amount . ' %');
            } else {
                $discount_amount = ($Res->discount_amount . ' Tk.');
            }

            if ($Res->status == 1) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active</span>';
            } else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Inactive</span>';
            }

            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'promoCode' => $Res->promoCode,
                'start_date' => $Res->start_date,
                'end_date' => $Res->end_date,
                'discount_type' => $discount_type,
                'discount_amount' => $discount_amount,
                'min_amount' => $Res->min_amount,
                'status' => $status,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Coupon::count(),
            "iTotalDisplayRecords" => Coupon::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    public function add()
    {
         $products = Product::where('status', 1)->get();
        return view('backend.coupon.add-coupon', compact('products'));
    }

      public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:coupons,name',
            'promoCode' => 'required|unique:coupons,promoCode',
            'canBeUsed' => 'required',
            'available' => 'required',
            'availableFor' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'discount_type' => 'required',
            'discount_amount' => 'required|integer',
            'min_amount' => 'required|integer',
            'status' => 'required',
        ]);

        $data = new Coupon();
        $data->name = $request->name;
        $data->promoCode = $request->promoCode;
        $data->canBeUsed = $request->canBeUsed;
        $data->available = $request->available;
        $data->availableFor = $request->availableFor;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->discount_type = $request->discount_type;
        $data->discount_amount = $request->discount_amount;
        $data->min_amount = $request->min_amount;
        $data->status = $request->status;
        $data->created_by = Auth::user()->id;
        $data->save();

        // Attach selected products if any
        if ($request->has('products')) {
            $data->products()->attach($request->products);
        }

        return redirect()->route('coupons.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $editData = Coupon::find($id);
        $products = Product::where('status', 1)->get();
        $selectedProducts = $editData->products->pluck('id')->toArray();
        
        return view('backend.coupon.create', compact('editData', 'products', 'selectedProducts'));
    }
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|unique:coupons,name,'.$id,
            'promoCode' => 'required|unique:coupons,promoCode,'.$id,
            'canBeUsed' => 'required',
            'available' => 'required',
            'availableFor' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'discount_type' => 'required',
            'discount_amount' => 'required|integer',
            'min_amount' => 'required|integer',
            'status' => 'required',
        ]);

        $data = Coupon::find($id);
        $data->name = $request->name;
        $data->promoCode = $request->promoCode;
        $data->canBeUsed = $request->canBeUsed;
        $data->available = $request->available;
        $data->availableFor = $request->availableFor;
        $data->start_date = $request->start_date;
        $data->end_date = $request->end_date;
        $data->discount_type = $request->discount_type;
        $data->discount_amount = $request->discount_amount;
        $data->min_amount = $request->min_amount;
        $data->status = $request->status;
        $data->updated_by = Auth::user()->id;
        $data->save();

        // Sync selected products
        if ($request->has('products')) {
            $data->products()->sync($request->products);
        } else {
            // If no products selected, remove all associations
            $data->products()->detach();
        }

        return redirect()->route('coupons.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete(Request $request, $id)
    {
        $data = Coupon::find($id);
        $data->delete();
        return redirect()->route('coupons.view')->with('success', 'Data deleted successfully !!!');
    }
}
