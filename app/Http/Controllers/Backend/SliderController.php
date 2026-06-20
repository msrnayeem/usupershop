<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Utilities\FileUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function view()
    {
        //$data['allData'] = Slider::select('id', 'name', 'image')->orderBy('id', 'DESC')->get();
        return view('backend.slider.view-slider');
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Slider::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            $image = "<img style='width:60px; height:40px' src='" . url('upload/slider_images/' . $Res->image) . "'>";

            $EditRoute = route('sliders.edit', $Res->id);
            $DeleteRoute = route('sliders.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";

            /* if ($Res->status == 1) {
                $status = '<span style="background:#1BA160;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Active</span>';
            } else {
                $status = '<span style="background:#DD4F42;color: #fff;padding:2px 8px 6px 8px;border-radius:3px;">Inactive</span>';
            } */

            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'image' => $image,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Slider::count(),
            "iTotalDisplayRecords" => Slider::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function add()
    {
        return view('backend.slider.add-slider');
    }

    public function store(Request $request)
    {
        DB::transaction(function () use ($request) {
            $this->validate($request, [
                'name' => 'required|unique:sliders,name',
            ]);

            $data = new Slider();
            $data->name = $request->name;
            $data->created_by = Auth::user()->id;
            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move('upload/slider_images/', $imgName);
                $data['image'] = $imgName;
            }
            $data->save();
        });
        return redirect()->route('sliders.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $data['editData'] = Slider::find($id);
        return view('backend.slider.add-slider', $data);
    }

    public function update(SliderRequest $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $data = Slider::find($id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->id;
            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move('upload/slider_images/', $imgName);
                if (!empty($data->image)) {
                    $imagePath = 'upload/slider_images/' . $data->image;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $data['image'] = $imgName;
            }
            $data->save();
        });
        return redirect()->route('sliders.view')->with('success', 'Data updated successfully');
    }

    public function delete($id)
    {
        $slider = Slider::find($id);
        if (!$slider) {
            return redirect()->route('sliders.view')->with('error', 'Slider not found!');
        }
        if (!empty($slider->image)) {
            $imagePath = 'upload/slider_images/' . $slider->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $slider->delete();
        return redirect()->route('sliders.view')->with('success', 'Data deleted successfully !!!');
    }

}
