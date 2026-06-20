<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use App\Models\Color;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ColorController extends Controller
{
    public function view()
    {
        $data['allData'] = Color::select('id', 'name')->orderBy('id', 'DESC')->get();
        return view('backend.color.view-color', $data);
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Color::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $count_color = ProductColor::where('color_id', $Res->id)->count();

            $EditRoute = route('colors.edit', $Res->id);
            $DeleteRoute = route('colors.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            if ($count_color < 1) {
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
            "iTotalRecords" => Color::count(),
            "iTotalDisplayRecords" => Color::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }


    public function add()
    {
        return view('backend.color.add-color');
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:colors,name'
        ]);

        $data = new Color();
        $data->name = $request->name;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('colors.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $editData = Color::find($id);
        return view('backend.color.add-color', compact('editData'));
    }

    public function update(ColorRequest $request, $id)
    {
        $data = Color::find($id);
        $data->name = $request->name;
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()->route('colors.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete(Request $request, $id)
    {

        $data = Color::find($id);
        $data->delete();

        return redirect()->route('colors.view')->with('success', 'Data deleted successfully !!!');
    }
}
