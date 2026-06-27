<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function view()
    {
        return view('backend.slider.view-slider');
    }

    public function list(Request $request)
    {
        $draw    = $request->input('draw');
        $length  = $request->input('length');
        $start   = $request->input('start');
        $columns = $request->input('columns');

        $Result = Slider::getResult($start, $length, $columns);
        $sn = $start + 1;
        $Data = [];

        foreach ($Result as $Res) {
            $image = "<img style='width:80px;height:50px;object-fit:cover;border-radius:6px' src='" . url('upload/slider_images/' . $Res->image) . "'>";

            // Show link if exists
            $linkBadge = '';
            if (!empty($Res->slider_link)) {
                $linkBadge = "<br><a href='" . $Res->slider_link . "' target='_blank' style='font-size:11px;color:#1e25fa'><i class='fas fa-link'></i> Link আছে</a>";
            } else {
                $linkBadge = "<br><span style='font-size:11px;color:#aaa'>Link নেই</span>";
            }

            $EditRoute   = route('sliders.edit', $Res->id);
            $DeleteRoute = route('sliders.delete', $Res->id);
            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";

            $Data[] = [
                'sn'     => $sn,
                'name'   => $Res->name . $linkBadge,
                'image'  => $image,
                'action' => $action,
            ];
            $sn++;
        }

        return response()->json([
            'draw'                  => $draw,
            'iTotalRecords'         => Slider::count(),
            'iTotalDisplayRecords'  => Slider::countResult($columns),
            'aaData'                => $Data,
        ]);
    }

    public function add()
    {
        return view('backend.slider.add-slider');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'        => 'required',
            'image'       => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'slider_link' => 'nullable|url',
        ], [
            'slider_link.url' => 'Link সঠিক URL হতে হবে (http:// বা https:// দিয়ে শুরু করুন)',
        ]);

        DB::transaction(function () use ($request) {
            $data              = new Slider();
            $data->name        = $request->name;
            $data->slider_link = $request->slider_link ?? null;
            $data->link_target = $request->link_target ?? '_self';
            $data->created_by  = Auth::user()->id;

            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move('upload/slider_images/', $imgName);
                $data->image = $imgName;
            }
            $data->save();
        });

        return redirect()->route('sliders.view')->with('success', 'Slider সফলভাবে যোগ হয়েছে!');
    }

    public function edit($id)
    {
        $editData = Slider::findOrFail($id);
        return view('backend.slider.add-slider', compact('editData'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'        => 'required',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'slider_link' => 'nullable|url',
        ], [
            'slider_link.url' => 'Link সঠিক URL হতে হবে (http:// বা https:// দিয়ে শুরু করুন)',
        ]);

        DB::transaction(function () use ($request, $id) {
            $data              = Slider::findOrFail($id);
            $data->name        = $request->name;
            $data->slider_link = $request->slider_link ?? null;
            $data->link_target = $request->link_target ?? '_self';
            $data->updated_by  = Auth::user()->id;

            $img = $request->file('image');
            if ($img) {
                $imgName = date('YmdHi') . $img->getClientOriginalName();
                $img->move('upload/slider_images/', $imgName);
                if (!empty($data->image)) {
                    $imagePath = 'upload/slider_images/' . $data->image;
                    if (file_exists($imagePath)) unlink($imagePath);
                }
                $data->image = $imgName;
            }
            $data->save();
        });

        return redirect()->route('sliders.view')->with('success', 'Slider সফলভাবে আপডেট হয়েছে!');
    }

    public function delete($id)
    {
        $slider = Slider::findOrFail($id);
        if (!empty($slider->image)) {
            $imagePath = 'upload/slider_images/' . $slider->image;
            if (file_exists($imagePath)) unlink($imagePath);
        }
        $slider->delete();
        return redirect()->route('sliders.view')->with('success', 'Slider মুছে ফেলা হয়েছে!');
    }
}
