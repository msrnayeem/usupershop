<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\subcategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SubcategoryController extends Controller
{
    public function view()
    {
        $data['allData'] = Subcategory::select('id', 'name')->orderBy('id', 'DESC')->get();
        return view('backend.subcategory.view-subcategory', $data);
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Subcategory::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $count_subcategory = Product::where('subcategory_id', $Res->id)->count();

            $EditRoute = route('subcategories.edit', $Res->id);
            $DeleteRoute = route('subcategories.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            if ($count_subcategory < 1) {
                $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i
                class='fas fa-trash'></i> Delete</a>";
            }

            $Data[] = array(
                'sn' => $sn,
                'category' => $Res->category->name ?? 'N/A',
                'name' => $Res->name ?? 'N/A',
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Subcategory::count(),
            "iTotalDisplayRecords" => Subcategory::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function add()
    {
        $data['categories'] = Category::all();
        return view('backend.subcategory.add-subcategory', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:subcategories,name'
        ]);
        $value = $request->name;
        $name = str_replace('"', '', $value);
        $data = new Subcategory();
        $data->category_id = $request->category_id;
        $data->name = $name;
        $data->subcat_slug = Str::slug($name);
        $data->created_by = Auth::user()->id;
        $data->save();
        return redirect()->route('subcategories.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $data['editData'] = Subcategory::find($id);
        $data['categories'] = Category::all();
        return view('backend.subcategory.add-subcategory', $data);
    }

    public function update(subcategoryRequest $request, $id)
    {
        $data = Subcategory::find($id);
        $data->category_id = $request->category_id;
        $data->name = $request->name;
        $data->slug = Str::slug($request->name);
        $data->updated_by = Auth::user()->id;
        $data->save();
        return redirect()->route('subcategories.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete($id)
    {
        $data = Subcategory::find($id);
        $data->delete();
        return redirect()->route('subcategories.view')->with('success', 'Data deleted successfully !!!');
    }
}
