<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    public function view()
    {
        //$data['allData'] = Brand::select('id', 'name')->orderBy('id', 'DESC')->get();
        return view('backend.brand.view-brand');
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Brand::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $count_brand = Product::where('brand_id', $Res->id)->count();

            $EditRoute = route('brands.edit', $Res->id);
            $DeleteRoute = route('brands.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            if ($count_brand < 1) {
                $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            }

            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Brand::count(),
            "iTotalDisplayRecords" => Brand::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function add()
    {
        return view('backend.brand.add-brand');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:categories,name'
        ]);

        $data = new Brand();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;


        // SEO fields
        $data->meta_title = $request->meta_title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords = $request->meta_keywords;


        $data->save();
        return redirect()->route('brands.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $editData = Brand::find($id);
        return view('backend.brand.add-brand', compact('editData'));
    }

    public function update(BrandRequest $request, $id)
    {
        $data = Brand::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;

        // SEO fields
        $data->meta_title = $request->meta_title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords = $request->meta_keywords;

        $data->save();
        return redirect()->route('brands.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete(Request $request, $id)
    {
        $data = Brand::find($id);
        $data->delete();
        return redirect()->route('brands.view')->with('success', 'Data deleted successfully !!!');
    }
}
