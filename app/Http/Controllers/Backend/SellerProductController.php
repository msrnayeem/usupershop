<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\MyShop;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductSubImage;
use App\Models\Size;
use App\Models\Subcategory;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Utilities\FileUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class SellerProductController extends Controller
{
    public function shopkeeper_product(){
        $data['products']= Product::all();
        return view('backend.seller.product.shopkeeper_product', $data);
    }
    public function SearchProducts(Request $request){
        $keyword =  $request->product_search;
        $data['products'] = Product::where('name', 'LIKE', '%' . $keyword . '%')
        ->orWhere('sku', 'LIKE', '%' . $keyword . '%')
        ->orWhere('short_desc', 'LIKE', '%' . $keyword . '%')
        ->get();
        return view('backend.seller.product.shopkeeper_product', $data);
    }
    public function MyWallets(){
        $profile = \App\Models\User::select(
            'users.id as user_id',
            'users.name',
            'users.balance',
            'wallets.id',
            'wallets.mobile_no',
            'wallets.payment_type',
            'wallets.transaction_status',
            'profile_verifies.nid_no',
            'profile_verifies.front_image'
        )
        ->leftJoin('wallets', 'wallets.user_id', '=', 'users.id')
        ->leftJoin('profile_verifies', 'profile_verifies.user_id', '=', 'users.id')
        ->where('users.id', auth()->user()->id)
        ->first();
     
        return view('backend.seller.user.wallets',compact('profile'));
    }
    public function MyWalletsVerified(){
        $profile = \App\Models\User::select(
            'users.id as user_id',
            'users.name',
            'users.balance',
            'wallets.id',
            'wallets.mobile_no',
            'wallets.payment_type',
            'wallets.transaction_status',
            'profile_verifies.nid_no',
            'profile_verifies.front_image'
        )
        ->leftJoin('wallets', 'wallets.user_id', '=', 'users.id')
        ->leftJoin('profile_verifies', 'profile_verifies.user_id', '=', 'users.id')
        ->where('users.id', auth()->user()->id)
        ->first();
     
        return view('backend.seller.user.wallets_verify',compact('profile'));
    }
    public function TransactionHistory(){
       $transaction = Wallet::select(
            'wallets.id',
            'users.id as user_id',
            'wallets.user_id',
            'wallets.transaction_date',
            'wallets.transaction_balance',
            'wallets.mobile_no',
            'wallets.payment_type',
            'wallets.transaction_status',
            'users.name'
        )
        ->leftJoin('users', 'wallets.user_id', '=', 'users.id')
        ->where('users.id', auth()->user()->id)
        ->get();
        return view('backend.seller.user.transaction',compact('transaction'));
    }
    public function add_to_my_shop( Request $request, $product_id){
        $exists = MyShop::where('user_id',Auth::id())->where('product_id',$product_id)->first();
        if (!$exists) {
            MyShop::insert([
                'user_id' => Auth::id(),
                'product_id' => $product_id,
                'created_at' => Carbon::now(),
            ]);
            return response()->json(['success' => 'Sucessfully Added On Your Product']);
        }else {
            return response()->json(['error' => 'The Product Has Already On Your Product']);
        }

    }

    public function seller_product(){
        return view('backend.seller.product.seller_product');
    }


    public function myproductlist(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];
        $Result = MyShop::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            if($Res->product){
                $img = "<img style='width:50px; height:30px' src='" . asset('upload/product_images/' . $Res->product->image) . "'>";
            }
            else{
                $img = 'N/A';
            }
            $DeleteRoute = route('sellers.products.delete',$Res->id);
            $action = "<a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i></a>";
            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->product ? $Res->product->name : 'N/A',
                'image' => $img,
                'action' => $action
            );
            $sn++;
        }
        $res = array(
            "draw" => $draw,
            "iTotalRecords" => MyShop::count(),
            "iTotalDisplayRecords" => MyShop::countResult($columns),
            "aaData" => $Data
        );
        return response()->json($res);
    }

    public function myProductDelete($id){
        $data = MyShop::find($id);
        $data->delete();
        return redirect()->back()->with('success', 'Data deleted successfully !!!');
    } 
    public function vendorProductView(){
        return view('backend.seller.product.vendor_product');
    }
    public function vendorProductList(Request $request){
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Product::getvendorResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $img = "<img style='width:50px; height:30px' src='" . url('upload/product_images/' . $Res->image) . "'>";

           // $ShowRoute = route('products.show', $Res->id);
            $EditRoute = route('vendor.editproduct', $Res->id);
          //  $DeleteRoute = route('vendor.deleteproduct', $Res->id);

           // $action = "<a title='Show' class='btn btn-sm btn-info' href='$ShowRoute'><i class='fas fa-eye'></i></a>";
            $action = " <a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i></a>";
         //   $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i></a>";

            if ($Res->discount_type == NULL) {
                $discount = '0 %';
            } elseif ($Res->discount_type == 1) {
                $discount = ($Res->discount . ' %');
            } else {
                $discount = ($Res->discount . ' Tk.');
            }

            if ($Res->discount_type == 1) {
                $disValue = $Res->price - ($Res->price * $Res->discount) / 100;
            } else {
                $disValue = ($Res->price) - ($Res->discount);
            }

            if ($Res->status == 1) {
                $status = '<span class="badge badge-success">Approved</span>';
            } elseif ($Res->status == 2) {
                $status = '<span class="badge badge-warning">Pending</span>';
            } else {
                $status = '<span class="badge badge-danger">Inactive</span>';
            }

            $Data[] = array(
                'sn' => $sn,
                'category_id' => $Res->category['name'],
                'brand_name' => $Res->brand['name'],
                'name' => $Res->name,
                'sku' => $Res->sku ?? '123456',
                'tp' => $Res->trade_price,
                'price' => $Res->price,
                'discount' => $discount,
                'disValue' => $disValue,
                'status' => $status,
                'image' => $img,
                'action' => $action,
                'id' => $Res->id,
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Product::count(),
            "iTotalDisplayRecords" => Product::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }
    public function addVendorProduct(){
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        $data['brands'] = Brand::all();
        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['color_array'] = $data['colors']->pluck('id')->toArray(); 
        $data['size_array'] = $data['sizes']->pluck('id')->toArray(); 
        $data['countries'] = Country::all();
        return view('backend.seller.product.add_vendor_product', $data);
    }
    public function storeVendorProduct(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_bn' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'color_id' => 'required|array',
            'size_id' => 'required|array',
            'quantity' => 'required|integer|min:0',
            'trade_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $p_name = str_replace('"', '', $request->name);
            $data = new Product();
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->brand_id = $request->brand_id;
            $data->user_id = Auth::user()->id;
            $data->name = $p_name;
            $data->name_bn = $request->name_bn;
            $data->sku = $request->sku;
            $data->slug = Str::slug($p_name) . '-' . Str::random(5);
            $data->country_id = $request->country_id;
            $data->short_desc = $request->short_desc;
            $data->short_desc_bn = $request->short_desc_bn;
            $data->long_desc = $request->long_desc;
            $data->trade_price = $request->trade_price;
            $data->price = $request->price;
            $data->sale_price = $request->sale_price;
            $data->min_price = $request->min_price;
            $data->max_price = $request->max_price;
            $data->discount_type = $request->discount_type;
            $data->discount = $request->discount;
            $data->hot_deals = $request->hot_deals;
            $data->featured = $request->featured;
            $data->special_offer = $request->special_offer;
            $data->special_deals = $request->special_deals;
            $data->quantity = $request->quantity;
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keywords = $request->meta_keywords;
            $data->status = 2; // Set as pending (status = 2) for admin approval

            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move(public_path('upload/product_images/'), $imgName);
                $data->image = $imgName;
            }

            if ($data->save()) {
                // Product sub image table data insert
                $files = $request->sub_image;
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $subImgName = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('upload/product_images/product_sub_images'), $subImgName);

                        $subimage = new ProductSubImage();
                        $subimage->product_id = $data->id;
                        $subimage->sub_image = $subImgName;
                        $subimage->save();
                    }
                }

                // Product color table data insert
                $colors = $request->color_id;
                if (!empty($colors)) {
                    foreach ($colors as $color) {
                        $mycolor = new ProductColor();
                        $mycolor->product_id = $data->id;
                        $mycolor->color_id = $color;
                        $mycolor->save();
                    }
                }

                // Product size table data insert
                $sizes = $request->size_id;
                if (!empty($sizes)) {
                    foreach ($sizes as $size) {
                        $mysize = new ProductSize();
                        $mysize->product_id = $data->id;
                        $mysize->size_id = $size;
                        $mysize->save();
                    }
                }
                
                DB::commit();
                return redirect()->route('vendor.productview')->with('success', 'Product added successfully and waiting for admin approval.');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Sorry! Data not saved !!!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function editVendorProduct($id){
        $data['editData'] = Product::find($id);
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        $data['brands'] = Brand::all();
        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['countries'] = Country::all();
        $data['color_array'] = ProductColor::select('color_id')->where('product_id', $data['editData']->id)->orderBy('id', 'desc')->get()->toArray();
        $data['size_array'] = ProductSize::select('size_id')->where('product_id', $data['editData']->id)->orderBy('id', 'desc')->get()->toArray();
        return view('backend.seller.product.add_vendor_product', $data);
    }
    public function VendorProductUpdate(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'name_bn' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'color_id' => 'required|array',
            'size_id' => 'required|array',
            'quantity' => 'required|integer|min:0',
            'trade_price' => 'nullable|numeric|min:0',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'min_price' => 'nullable|numeric|min:0',
            'max_price' => 'nullable|numeric|min:0|gte:min_price',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            DB::beginTransaction();
            $data = Product::find($id);
            if (!$data) {
                return redirect()->back()->with('error', 'Product not found');
            }

            $p_name = str_replace('"', '', $request->name);
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->brand_id = $request->brand_id;
            $data->user_id = Auth::user()->id;
            $data->name = $p_name;
            $data->sku = $request->sku;
            $data->name_bn = $request->name_bn;
            $data->slug = Str::slug($p_name) . '-' . Str::random(5);
            $data->country_id = $request->country_id;
            $data->short_desc = $request->short_desc;
            $data->short_desc_bn = $request->short_desc_bn;
            $data->long_desc = $request->long_desc;
            $data->trade_price = $request->trade_price;
            $data->price = $request->price;
            $data->sale_price = $request->sale_price;
            $data->min_price = $request->min_price;
            $data->max_price = $request->max_price;
            $data->discount_type = $request->discount_type;
            $data->discount = $request->discount;
            $data->status = 2; // Keep as pending on update or reset to pending? Usually reset to pending for re-approval
            $data->hot_deals = $request->hot_deals;
            $data->featured = $request->featured;
            $data->special_offer = $request->special_offer;
            $data->special_deals = $request->special_deals;
            $data->quantity = $request->quantity;
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keywords = $request->meta_keywords;

            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move(public_path('upload/product_images/'), $imgName);
                if (file_exists(public_path('upload/product_images/' . $data->image)) && !empty($data->image)) {
                    unlink(public_path('upload/product_images/' . $data->image));
                }
                $data->image = $imgName;
            }
           
            if ($data->save()) {
                // Product sub image table data update
                $files = $request->sub_image;
                if (!empty($files)) {
                    $subImage = ProductSubImage::where('product_id', $id)->get();
                    foreach ($subImage as $value) {
                        if (file_exists(public_path('upload/product_images/product_sub_images/' . $value->sub_image)) && !empty($value->sub_image)) {
                            unlink(public_path('upload/product_images/product_sub_images/' . $value->sub_image));
                        }
                    }
                    ProductSubImage::where('product_id', $id)->delete();

                    foreach ($files as $file) {
                        $subImgName = date('YmdHi') . $file->getClientOriginalName();
                        $file->move(public_path('upload/product_images/product_sub_images'), $subImgName);
                        $subimage = new ProductSubImage();
                        $subimage->product_id = $data->id;
                        $subimage->sub_image = $subImgName;
                        $subimage->save();
                    }
                }

                // Product color table data update
                $colors = $request->color_id;
                if (!empty($colors)) {
                    ProductColor::where('product_id', $id)->delete();
                    foreach ($colors as $color) {
                        $mycolor = new ProductColor();
                        $mycolor->product_id = $data->id;
                        $mycolor->color_id = $color;
                        $mycolor->save();
                    }
                }

                // Product size table data update
                $sizes = $request->size_id;
                if (!empty($sizes)) {
                    ProductSize::where('product_id', $id)->delete();
                    foreach ($sizes as $size) {
                        $mysize = new ProductSize();
                        $mysize->product_id = $data->id;
                        $mysize->size_id = $size;
                        $mysize->save();
                    }
                }
                
                DB::commit();
                return redirect()->route('vendor.productview')->with('success', 'Product updated successfully and waiting for admin approval.');
            } else {
                DB::rollBack();
                return redirect()->back()->with('error', 'Sorry! Data not update !!!');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function deleteVendorProduct(Request $request, $id)
    {

        $product = Product::find($id);
        if (file_exists('upload/product_images/' . $product->image) && !empty($product->image)) {
            unlink('upload/product_images/' . $product->image);
        }
        $subImage = ProductSubImage::where('product_id', $product->id)->get()->toArray();
        foreach ($subImage as $value) {
            if (!empty($value)) {
                unlink('upload/product_images/product_sub_images/' . $value['sub_image']);
            }
        }
        ProductSubImage::where('product_id', $product->id)->delete();
        ProductColor::where('product_id', $product->id)->delete();
        ProductSize::where('product_id', $product->id)->delete();
        $product->delete();
        return redirect()->route('vendor.productview')->with('success', 'Data deleted successfully !');
    }
}
