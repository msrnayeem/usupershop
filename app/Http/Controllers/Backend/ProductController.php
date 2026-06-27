<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Country;
use App\Models\Product;
use App\Models\ProductColor;
use App\Models\ProductSize;
use App\Models\ProductVariant;
use App\Models\ProductSubImage;
use App\Models\Size;
use App\Models\Subcategory;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use App\Utilities\FileUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class ProductController extends Controller
{
    public function view()
    {
        return view('backend.product.view-product');
    }
    public function pending_product_list()
    {
        return view('backend.product.pending-product');
    }
    public function inactive_product_list()
    {
        return view('backend.product.inactive-product');
    }
    public function get_pendinglist(Request $request)
    {
        $draw = $request->input('draw');
        $length = $request->input('length');
        $start = $request->input('start');
        $columns = $request->input('columns');

        $Data = [];
        $Result = Product::getPendingResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $img = "<img style='width:50px; height:30px' src='" . url('upload/product_images/' . $Res->image) . "'>";

            $ShowRoute = route('products.show', $Res->id);
            $statusRoute = route('products.status', $Res->id);
            $EditRoute = route('products.edit', $Res->id);
            $DeleteRoute = route('products.delete', $Res->id);

            $action = "<a title='Show' class='btn btn-sm btn-info' href='$ShowRoute'><i class='fas fa-eye'></i></a>";
            $action .= " <a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i></a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i></a>";
            $action .= " <a title='Approve' class='btn btn-sm btn-success' href='$statusRoute'><i class='fas fa-check'></i></a>";
            $action .= " <a title='Inactive' class='btn btn-sm btn-warning' href='" . route('products.unstatus', $Res->id) . "'><i class='fas fa-times'></i></a>";

            if ($Res->status == 1) {
                $status = '<span class="badge badge-success">Approved</span>';
            } elseif ($Res->status == 2) {
                $status = '<span class="badge badge-warning">Pending</span>';
            } else {
                $status = '<span class="badge badge-danger">Inactive</span>';
            }

            if ($Res->discount_type == null) {
                $discount = '0 %';
            } elseif ($Res->discount_type == 1) {
                $discount = $Res->discount . ' %';
            } else {
                $discount = $Res->discount . ' Tk.';
            }

            if ($Res->discount_type == 1) {
                $disValue = $Res->price - ($Res->price * $Res->discount) / 100;
            } else {
                $disValue = $Res->price - $Res->discount;
            }

            $Data[] = [
                'sn' => $sn,
                'category_id' => $Res->category['name'],
                'brand_name' => $Res->brand['name'],
                'name' => $Res->name,
                'sku' => $Res->sku ?? '123456',
                'country_id' => $Res->origin['country'] ?? 'N/A',
                'trade_price' => $Res->trade_price,
                'price' => $Res->price,
                'discount' => $discount,
                'disValue' => $disValue,
                'status' => $status,
                'image' => $img,
                'created_by' => $Res->user ? $Res->user->name . ' ( ' . $Res->user->role . ' )' : 'N/A',
                'action' => $action,
                'id' => $Res->id,
            ];


            $sn++;
        }

        $res = [
            'draw' => $draw,
            'iTotalRecords' => Product::where('status', 2)->count(),
            'iTotalDisplayRecords' => Product::countResult($columns, 2),
            'aaData' => $Data,
        ];

        return response()->json($res);
    }
    public function get_inactivelist(Request $request)
    {
        $draw = $request->input('draw');
        $length = $request->input('length');
        $start = $request->input('start');
        $columns = $request->input('columns');

        $Data = [];
        $Result = Product::getInactiveResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $img = "<img style='width:50px; height:30px' src='" . url('upload/product_images/' . $Res->image) . "'>";

            $ShowRoute = route('products.show', $Res->id);
            $statusRoute = route('products.status', $Res->id);
            $EditRoute = route('products.edit', $Res->id);
            $DeleteRoute = route('products.delete', $Res->id);

            $action = "<a title='Show' class='btn btn-sm btn-info' href='$ShowRoute'><i class='fas fa-eye'></i></a>";
            $action .= " <a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i></a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i></a>";
            $action .= " <a title='Approve' class='btn btn-sm btn-success' href='$statusRoute'><i class='fas fa-check'></i></a>";

            if ($Res->status == 1) {
                $status = '<span class="badge badge-success">Approved</span>';
            } elseif ($Res->status == 2) {
                $status = '<span class="badge badge-warning">Pending</span>';
            } else {
                $status = '<span class="badge badge-danger">Inactive</span>';
            }

            if ($Res->discount_type == null) {
                $discount = '0 %';
            } elseif ($Res->discount_type == 1) {
                $discount = $Res->discount . ' %';
            } else {
                $discount = $Res->discount . ' Tk.';
            }

            if ($Res->discount_type == 1) {
                $disValue = $Res->price - ($Res->price * $Res->discount) / 100;
            } else {
                $disValue = $Res->price - $Res->discount;
            }

            $Data[] = [
                'sn' => $sn,
                'category_id' => $Res->category['name'],
                'brand_name' => $Res->brand['name'],
                'name' => $Res->name,
                'sku' => $Res->sku ?? '123456',
                'country_id' => $Res->origin['country'] ?? 'N/A',
                'trade_price' => $Res->trade_price,
                'price' => $Res->price,
                'discount' => $discount,
                'disValue' => $disValue,
                'status' => $status,
                'image' => $img,
                'created_by' => $Res->user ? $Res->user->name . ' ( ' . $Res->user->role . ' )' : 'N/A',
                'action' => $action,
                'id' => $Res->id,
            ];

            $sn++;
        }

        $res = [
            'draw' => $draw,
            'iTotalRecords' => Product::where('status', 0)->count(),
            'iTotalDisplayRecords' => Product::countResult($columns, 0),
            'aaData' => $Data,
        ];

        return response()->json($res);
    }
    public function list(Request $request)
    {
        $draw = $request->input('draw');
        $length = $request->input('length');
        $start = $request->input('start');
        $columns = $request->input('columns');

        $Data = [];
        $Result = Product::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $img = "<img style='width:50px; height:30px' src='" . url('upload/product_images/' . $Res->image) . "'>";

            $ShowRoute = route('products.show', $Res->id);
            $statusRoute = route('products.unstatus', $Res->id);
            $EditRoute = route('products.edit', $Res->id);
            $DeleteRoute = route('products.delete', $Res->id);

            $action = "<a title='Show' class='btn btn-sm btn-info' href='$ShowRoute'><i class='fas fa-eye'></i></a>";
            $action .= " <a title='Edit' class='btn btn-sm btn-primary' href='$EditRoute'><i class='fas fa-edit'></i></a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i></a>";
            
            if ($Res->status == 1) {
                $action .= " <a title='Inactive' class='btn btn-sm btn-warning' href='" . route('products.unstatus', $Res->id) . "'><i class='fas fa-times'></i></a>";
            } else {
                $action .= " <a title='Approve' class='btn btn-sm btn-success' href='" . route('products.status', $Res->id) . "'><i class='fas fa-check'></i></a>";
            }

            if ($Res->status == 1) {
                $status = '<span class="badge badge-success">Approved</span>';
            } elseif ($Res->status == 2) {
                $status = '<span class="badge badge-warning">Pending</span>';
            } else {
                $status = '<span class="badge badge-danger">Inactive</span>';
            }

            if ($Res->discount_type == null) {
                $discount = '0 %';
            } elseif ($Res->discount_type == 1) {
                $discount = $Res->discount . ' %';
            } else {
                $discount = $Res->discount . ' Tk.';
            }

            if ($Res->discount_type == 1) {
                $disValue = $Res->price - ($Res->price * $Res->discount) / 100;
            } else {
                $disValue = $Res->price - $Res->discount;
            }

            $Data[] = [
                'sn' => $sn,
                'category_id' => $Res->category['name'],
                'brand_name' => $Res->brand['name'],
                'name' => $Res->name,
                'sku' => $Res->sku ?? '123456',
                'country_id' => $Res->origin['country'] ?? 'N/A',
                'trade_price' => $Res->trade_price,
                'price' => $Res->price,
                'discount' => $discount,
                'disValue' => $disValue,
                'status' => $status,
                'image' => $img,
                'created_by' => $Res->user ? $Res->user->name . ' ( ' . $Res->user->role . ' )' : 'N/A',
                'action' => $action,
                'id' => $Res->id,
            ];

            $sn++;
        }

        $res = [
            'draw' => $draw,
            'iTotalRecords' => Product::count(),
            'iTotalDisplayRecords' => Product::countResult($columns),
            'aaData' => $Data,
        ];

        return response()->json($res);
    }

    public function add()
    {
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        $data['brands'] = Brand::all();
        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['color_array'] = $data['colors']->pluck('id')->toArray();
        $data['size_array'] = $data['sizes']->pluck('id')->toArray();
        $data['countries'] = Country::all();
        return view('backend.product.add-product', $data);
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'name_bn' => 'required|string|max:100',
                'quantity' => 'required|integer',
                'category_id' => 'required',
                'short_desc' => 'nullable|max:100',
                'short_desc_bn' => 'nullable|max:100',
                'trade_price' => 'nullable|numeric|min:0',
                'image' => 'nullable|image|mimes:jpg,jpeg,png',
                'price' => 'nullable|numeric|min:0',
                'combinations' => 'required|array|min:1',
                'combinations.*.color_id' => 'required',
                'combinations.*.size_id' => 'required',
                'combinations.*.additional_price' => 'nullable|numeric|min:0',
                'combinations.*.stock_quantity' => 'required|integer|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|min:0|gte:min_price',

            ]);

            $value = $request->name;
            $p_name = str_replace('"', '', $value);

            // Create main product
            $data = new Product();
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->brand_id = $request->brand_id;
            $data->user_id = Auth::user()->id;
            $data->name = $p_name;
            $data->name_bn = $request->name_bn;
            $data->sku = $request->sku;
            $data->slug = Str::slug($p_name) . substr(Str::uuid()->toString(), 0, 30);
            $data->country_id = $request->country_id;
            $data->short_desc = $request->short_desc;
            $data->short_desc_bn = $request->short_desc_bn;
            $data->long_desc = $request->long_desc;
            $data->trade_price = $request->trade_price;
            $data->price = $request->price;
            $data->discount_type = $request->discount_type;
            $data->discount = $request->discount;
            $data->status = $request->status;
            $data->hot_deals = $request->hot_deals;
            $data->featured = $request->featured;
            $data->special_offer = $request->special_offer;
            $data->special_deals = $request->special_deals;
            $data->quantity = $request->quantity;
            $data->sale_price = $request->sale_price;
            $data->min_price = $request->min_price;
            $data->max_price = $request->max_price;

            // SEO fields
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keywords = $request->meta_keywords;

            // Handle main image upload
            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $destination = 'upload/product_images/';
                if (!$img->move($destination, $imgName)) {
                    throw new \Exception('Main image upload failed');
                }
                $data->image = $imgName;
            }

            if ($data->save()) {
                // Product sub images
                $files = $request->sub_image;
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $imgName = date('YmdHi') . $file->getClientOriginalName();
                        $destination = 'upload/product_images/product_sub_images/';
                        if (!$file->move($destination, $imgName)) {
                            throw new \Exception('Sub image upload failed');
                        }
                        $subimage = new ProductSubImage();
                        $subimage->product_id = $data->id;
                        $subimage->sub_image = $imgName;
                        $subimage->save();
                    }
                }

                // Store color-size combinations with pricing
                $combinations = $request->combinations;
                if (!empty($combinations)) {
                    foreach ($combinations as $combination) {
                        // Create product variant
                        $variant = new ProductVariant();
                        $variant->product_id = $data->id;
                        $variant->color_id = $combination['color_id'];
                        $variant->size_id = $combination['size_id'];
                        $variant->additional_price = !empty($combination['additional_price']) ? (float)$combination['additional_price'] : 0;
                        $variant->stock_quantity = $combination['stock_quantity'] ?? 0;
                        $variant->sku = $combination['sku'] ?? null;
                        $variant->status = 1; // Active by default
                        $variant->save();
                    }
                }

                // Store unique colors and sizes for backward compatibility
                $uniqueColors = collect($combinations)->pluck('color_id')->unique();
                foreach ($uniqueColors as $colorId) {
                    $mycolor = new ProductColor();
                    $mycolor->product_id = $data->id;
                    $mycolor->color_id = $colorId;
                    $mycolor->save();
                }

                $uniqueSizes = collect($combinations)->pluck('size_id')->unique();
                foreach ($uniqueSizes as $sizeId) {
                    $mysize = new ProductSize();
                    $mysize->product_id = $data->id;
                    $mysize->size_id = $sizeId;
                    $mysize->save();
                }

            } else {
                throw new \Exception('Data not saved to database');
            }
        });

        return redirect()->route('products.view')->with('success', 'Product with variants added successfully');
    }

    public function show($id)
    {
        $data['showData'] = Product::find($id);
        return view('backend.product.show-product', $data);
    }

    /**
     * Stock Out products list (quantity = 0)
     */
    public function stockOutList()
    {
        return view('backend.product.stockout-product');
    }

    public function getStockOutList(Request $request)
    {
        $start   = $request->start  ?? 0;
        $length  = $request->length ?? 10;
        $columns = ['id', 'name', 'quantity', 'status', 'user_id', 'image', 'price'];

        $query = Product::where('quantity', '<=', 0)->where('status', 1);
        $total = $query->count();

        $products = $query->select($columns)
            ->with(['user:id,name'])
            ->orderBy('updated_at', 'desc')
            ->skip($start)->take($length)->get();

        $data = [];
        foreach ($products as $p) {
            $data[] = [
                'id'     => $p->id,
                'image'  => '<img src="' . url('upload/product_images/' . $p->image) . '" width="45" height="45" style="border-radius:6px;object-fit:cover;">',
                'name'   => $p->name,
                'price'  => '৳' . number_format($p->price, 0),
                'qty'    => '<span class="badge badge-danger">Out of Stock (0)</span>',
                'vendor' => $p->user->name ?? 'Admin',
                'action' => '<a href="' . route('products.edit', $p->id) . '" class="btn btn-xs btn-primary"><i class="fas fa-edit"></i> Update Stock</a>',
            ];
        }

        return response()->json([
            'draw'            => $request->draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data,
        ]);
    }

    /**
     * Low Stock products list (quantity <= alert_label threshold, default ≤ 5)
     */
    public function lowStockList()
    {
        return view('backend.product.lowstock-product');
    }

    public function getLowStockList(Request $request)
    {
        $start     = $request->start  ?? 0;
        $length    = $request->length ?? 10;
        $threshold = 5; // alert when qty ≤ 5
        $columns   = ['id', 'name', 'quantity', 'alert_label', 'status', 'user_id', 'image', 'price'];

        $query = Product::where('quantity', '>', 0)
                        ->where('quantity', '<=', $threshold)
                        ->where('status', 1);
        $total = $query->count();

        $products = $query->select($columns)
            ->with(['user:id,name'])
            ->orderBy('quantity', 'asc')
            ->skip($start)->take($length)->get();

        $data = [];
        foreach ($products as $p) {
            $qtyColor = $p->quantity <= 2 ? 'danger' : 'warning';
            $data[] = [
                'id'     => $p->id,
                'image'  => '<img src="' . url('upload/product_images/' . $p->image) . '" width="45" height="45" style="border-radius:6px;object-fit:cover;">',
                'name'   => $p->name,
                'price'  => '৳' . number_format($p->price, 0),
                'qty'    => '<span class="badge badge-' . $qtyColor . '">Low: ' . $p->quantity . ' left</span>',
                'vendor' => $p->user->name ?? 'Admin',
                'action' => '<a href="' . route('products.edit', $p->id) . '" class="btn btn-xs btn-warning"><i class="fas fa-edit"></i> Restock</a>',
            ];
        }

        return response()->json([
            'draw'            => $request->draw,
            'recordsTotal'    => $total,
            'recordsFiltered' => $total,
            'data'            => $data,
        ]);
    }

    /**
     * Toggle product active/inactive (AJAX)
     */
    public function toggleStatus(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        if ($product->status === 1) {
            $product->status = 0; // active → inactive
            $msg = 'Product Inactive করা হয়েছে।';
        } else {
            $product->status = 1; // inactive/pending → active
            $msg = 'Product Active করা হয়েছে।';
        }
        $product->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $product->status, 'message' => $msg]);
        }
        return redirect()->back()->with('success', $msg);
    }

    public function productStatus($id)
    {
        $product = Product::find($id);
        $product->status = 1;
        $product->save();
        return redirect()->back()->with('success', 'Status changed successfully');
    }
    public function productUnStatus($id)
    {
        $product = Product::find($id);
        $product->status = 0; // 0 for Inactive
        $product->save();
        return redirect()->back()->with('success', 'Status changed successfully');
    }

    public function edit($id)
    {
        $data['editData'] = Product::with(['variants.color', 'variants.size'])->find($id);
        $data['categories'] = Category::all();
        $data['subcategories'] = Subcategory::all();
        $data['brands'] = Brand::all();
        $data['colors'] = Color::all();
        $data['sizes'] = Size::all();
        $data['countries'] = Country::all();
        $data['color_array'] = ProductColor::select('color_id')->where('product_id', $data['editData']->id)->orderBy('id', 'desc')->get()->toArray();
        $data['size_array'] = ProductSize::select('size_id')->where('product_id', $data['editData']->id)->orderBy('id', 'desc')->get()->toArray();

        return view('backend.product.edit-product', $data);
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $this->validate($request, [
                'name' => 'required|string|max:100',
                'name_bn' => 'required|string|max:100',
                'category_id' => 'required',
                'image' => 'nullable|mimes:jpg,jpeg,png',
                'quantity' => 'required|integer',
                'short_desc' => 'nullable|max:100',
                'short_desc_bn' => 'nullable|max:100',
                'trade_price' => 'nullable|numeric|min:0',
                'price' => 'nullable|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
                'min_price' => 'nullable|numeric|min:0',
                'max_price' => 'nullable|numeric|min:0|gte:min_price',
                'combinations' => 'nullable|array',
                'combinations.*.color_id' => 'required_with:combinations',
                'combinations.*.size_id' => 'required_with:combinations',
                'combinations.*.additional_price' => 'nullable|numeric|min:0',
                'combinations.*.stock_quantity' => 'required_with:combinations|integer|min:0',
            ]);

            $data = Product::find($id);
            $data->category_id = $request->category_id;
            $data->subcategory_id = $request->subcategory_id;
            $data->brand_id = $request->brand_id;
            $data->user_id = Auth::user()->id;
            $data->name = $request->name;
            $data->name_bn = $request->name_bn;
            $data->sku = $request->sku;
            $data->quantity = $request->quantity;
            $data->country_id = $request->country_id;
            $data->short_desc = $request->short_desc;
            $data->short_desc_bn = $request->short_desc_bn;
            $data->long_desc = $request->long_desc;
            $data->trade_price = $request->trade_price;
            $data->price = $request->price;
            $data->discount_type = $request->discount_type;
            $data->discount = $request->discount;
            $data->status = $request->status;
            $data->hot_deals = $request->hot_deals;
            $data->featured = $request->featured;
            $data->special_offer = $request->special_offer;
            $data->special_deals = $request->special_deals;
            $data->sale_price = $request->sale_price;
            $data->min_price = $request->min_price;
            $data->max_price = $request->max_price;

            // SEO fields
            $data->meta_title = $request->meta_title;
            $data->meta_description = $request->meta_description;
            $data->meta_keywords = $request->meta_keywords;

            // Handle main image upload
            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move('upload/product_images/', $imgName);
                if (file_exists('upload/product_images/' . $data->image) && !empty($data->image)) {
                    unlink('upload/product_images/' . $data->image);
                }
                $data->image = $imgName;
            }

            if ($data->update()) {
                // Product sub image table data update
                $files = $request->sub_image;
                if (!empty($files)) {
                    $subImage = ProductSubImage::where('product_id', $id)->get()->toArray();
                    foreach ($subImage as $value) {
                        $filePath = 'upload/product_images/product_sub_images/' . $value['sub_image'];
                        if (file_exists($filePath) && !empty($value['sub_image'])) {
                            unlink($filePath);
                        }
                    }
                    ProductSubImage::where('product_id', $id)->delete();
                }
                if (!empty($files)) {
                    foreach ($files as $file) {
                        $imgName = date('YmdHi') . $file->getClientOriginalName();
                        $file->move('upload/product_images/product_sub_images', $imgName);
                        $subimage = new ProductSubImage();
                        $subimage->product_id = $data->id;
                        $subimage->sub_image = $imgName;
                        $subimage->save();
                    }
                }

                // Update product variants (combinations)
                $combinations = $request->combinations;
                if (!empty($combinations)) {
                    // Delete existing variants
                    ProductVariant::where('product_id', $id)->delete();

                    // Create new variants
                    foreach ($combinations as $combination) {
                        $variant = new ProductVariant();
                        $variant->product_id = $data->id;
                        $variant->color_id = $combination['color_id'];
                        $variant->size_id = $combination['size_id'];
                        $variant->additional_price = !empty($combination['additional_price']) ? (float)$combination['additional_price'] : 0;
                        $variant->stock_quantity = $combination['stock_quantity'] ?? 0;
                        $variant->sku = $combination['sku'] ?? null;
                        $variant->status = 1;
                        $variant->save();
                    }

                    // Update unique colors and sizes for backward compatibility
                    ProductColor::where('product_id', $id)->delete();
                    $uniqueColors = collect($combinations)->pluck('color_id')->unique();
                    foreach ($uniqueColors as $colorId) {
                        $mycolor = new ProductColor();
                        $mycolor->product_id = $data->id;
                        $mycolor->color_id = $colorId;
                        $mycolor->save();
                    }

                    ProductSize::where('product_id', $id)->delete();
                    $uniqueSizes = collect($combinations)->pluck('size_id')->unique();
                    foreach ($uniqueSizes as $sizeId) {
                        $mysize = new ProductSize();
                        $mysize->product_id = $data->id;
                        $mysize->size_id = $sizeId;
                        $mysize->save();
                    }
                } else {
                    // If no combinations provided, just update colors and sizes
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
                }
            } else {
                throw new \Exception('Data not updated!');
            }
        });

        return redirect()->route('products.view')->with('success', 'Product updated successfully');
    }

    public function delete($id)
    {
        $product = Product::find($id);

        // Delete main product image
        $mainImagePath = 'upload/product_images/' . $product->image;
        if (file_exists($mainImagePath) && !empty($product->image)) {
            unlink($mainImagePath);
        }

        // Delete sub images safely
        $subImages = ProductSubImage::where('product_id', $product->id)->get()->toArray();
        foreach ($subImages as $value) {
            $subImagePath = 'upload/product_images/product_sub_images/' . $value['sub_image'];
            if (!empty($value['sub_image']) && file_exists($subImagePath)) {
                unlink($subImagePath);
            }
        }

        // Delete related records
        ProductSubImage::where('product_id', $product->id)->delete();
        ProductColor::where('product_id', $product->id)->delete();
        ProductSize::where('product_id', $product->id)->delete();

        // Finally delete the product
        $product->delete();

        return redirect()->back()->with('success', 'Data deleted successfully!');
    }


    public function getVariant($productId, $colorId, $sizeId)
    {
        try {
            $product = Product::findOrFail($productId);
            $variant = $product->variants()
                ->with(['color', 'size'])
                ->where('color_id', $colorId)
                ->where('size_id', $sizeId)
                ->first();

            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Variant not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'variant' => [
                    'id' => $variant->id,
                    'color_id' => $variant->color_id,
                    'size_id' => $variant->size_id,
                    'color_name' => $variant->color->name,
                    'size_name' => $variant->size->name,
                    'additional_price' => $variant->additional_price,
                    'stock_quantity' => $variant->stock_quantity,
                    'sku' => $variant->sku,
                    'final_price' => $variant->final_price,
                    'final_trade_price' => $variant->final_trade_price,
                    'is_in_stock' => $variant->isInStock()
                ]
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching variant details'
            ], 500);
        }
    }

    /**
     * Get all variants for a product
     */
    public function getProductVariants($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $variants = $product->variants()
                ->with(['color', 'size'])
                ->where('status', 1)
                ->get();

            $variantData = $variants->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'color_id' => $variant->color_id,
                    'size_id' => $variant->size_id,
                    'color_name' => $variant->color->name,
                    'size_name' => $variant->size->name,
                    'additional_price' => $variant->additional_price,
                    'stock_quantity' => $variant->stock_quantity,
                    'sku' => $variant->sku,
                    'final_price' => $variant->final_price,
                    'final_trade_price' => $variant->final_trade_price,
                    'is_in_stock' => $variant->isInStock()
                ];
            });

            return response()->json([
                'success' => true,
                'variants' => $variantData,
                'price_range' => [
                    'min' => $product->cheapest_variant_price,
                    'max' => $product->most_expensive_variant_price
                ],
                'total_stock' => $product->total_variant_stock
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching product variants'
            ], 500);
        }
    }

    /**
     * Update variant stock (useful for inventory management)
     */
    public function updateVariantStock(Request $request, $variantId)
    {
        try {
            $variant = ProductVariant::findOrFail($variantId);

            $this->validate($request, [
                'stock_quantity' => 'required|integer|min:0'
            ]);

            $variant->stock_quantity = $request->stock_quantity;
            $variant->save();

            return response()->json([
                'success' => true,
                'message' => 'Variant stock updated successfully',
                'variant' => $variant
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating variant stock'
            ], 500);
        }
    }

    /**
     * Get variants by color (for size dropdown population)
     */
    public function getVariantsByColor($productId, $colorId)
    {
        try {
            $product = Product::findOrFail($productId);
            $variants = $product->variants()
                ->with('size')
                ->where('color_id', $colorId)
                ->where('status', 1)
                ->get();

            $availableSizes = $variants->map(function ($variant) {
                return [
                    'size_id' => $variant->size_id,
                    'size_name' => $variant->size->name,
                    'additional_price' => $variant->additional_price,
                    'stock_quantity' => $variant->stock_quantity,
                    'is_in_stock' => $variant->isInStock()
                ];
            });

            return response()->json([
                'success' => true,
                'sizes' => $availableSizes
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching sizes for color'
            ], 500);
        }
    }

    /**
     * Get variants by size (for color dropdown population)
     */
    public function getVariantsBySize($productId, $sizeId)
    {
        try {
            $product = Product::findOrFail($productId);
            $variants = $product->variants()
                ->with('color')
                ->where('size_id', $sizeId)
                ->where('status', 1)
                ->get();

            $availableColors = $variants->map(function ($variant) {
                return [
                    'color_id' => $variant->color_id,
                    'color_name' => $variant->color->name,
                    'additional_price' => $variant->additional_price,
                    'stock_quantity' => $variant->stock_quantity,
                    'is_in_stock' => $variant->isInStock()
                ];
            });

            return response()->json([
                'success' => true,
                'colors' => $availableColors
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error fetching colors for size'
            ], 500);
        }
    }

    public function getVariantPrice(Request $request)
    {
        $productId = $request->product_id;
        $colorId = $request->color_id;
        $sizeId = $request->size_id;

        $variant = ProductVariant::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();

        if ($variant) {
            return response()->json([
                'success' => true,
                'variant' => $variant
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Variant not found'
        ]);
    }

}
