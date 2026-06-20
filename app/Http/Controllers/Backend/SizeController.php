<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SizeController extends Controller
{
    public function view()
    {
        $data['allData'] = Size::select('id', 'name')->orderBy('id', 'DESC')->get();
        return view('backend.size.view-size', $data);
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Size::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $count_size = ProductSize::where('size_id', $Res->id)->count();

            $EditRoute = route('sizes.edit', $Res->id);
            $DeleteRoute = route('sizes.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            if ($count_size < 1) {
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
            "iTotalRecords" => Size::count(),
            "iTotalDisplayRecords" => Size::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    public function add()
    {
        return view('backend.size.add-size');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:sizes,name'
        ]);

        $data = new Size();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('sizes.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $editData = Size::find($id);
        return view('backend.size.add-size', compact('editData'));
    }

    public function update(SizeRequest $request, $id)
    {
        $data = Size::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()->route('sizes.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete(Request $request, $id)
    {

        $data = Size::find($id);
        $data->delete();

        return redirect()->route('sizes.view')->with('success', 'Data deleted successfully !!!');
    }
}
