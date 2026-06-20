<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LogoRequest;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LogoController extends Controller
{
    public function view(){
        $data['countLogo'] = Logo::count();
        $data['allData'] = Logo::select('id', 'name','image')->orderBy('id','DESC')->get();
        return view('backend.logo.view-logo',$data);
    }

    public function add(){
        return view('backend.logo.add-logo');
    }

    public function store(Request $request){

        DB::transaction(function() use($request){
            $this->validate($request,[
                'name' => 'required|unique:logos,name',
                'image' => 'required|mimes:png,jpg|max:1024'
            ]);

            $data = new Logo();
            $data->name = $request->name;
            $data->created_by = Auth::user()->id;
            $img = $request->file('image');
            if($img){
                $imgName = date('YmdHi').$img->getClientOriginalName();
                $img->move('upload/logo_image/', $imgName);
                $data['image'] = $imgName;
            }
            $data->save();
        });
        return redirect()->route('logos.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id){
        $data['editData'] = Logo::find($id);
        return view('backend.logo.add-logo', $data);
    }

    public function update(LogoRequest $request, $id){

        DB::transaction(function() use($request,$id){
            $data = Logo::find($id);
            $data->name = $request->name;
            $data->updated_by = Auth::user()->id;
            $img = $request->file('image');
            if($img){
                $imgName = date('YmdHi').$img->getClientOriginalName();
                $img->move('upload/logo_image/', $imgName);
                if (!empty($data->image)) {
                    $imagePath = 'upload/logo_image/' . $data->image;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }
                $data['image'] = $imgName;
            }
            $data->save();
        });
        return redirect()->route('logos.view')->with('success', 'Data updated successfully');
    }

    public function delete(Request $request){

        $logo = Logo::find($request->id);
        if(file_exists('upload/logo_image/'.$logo->image) and ! empty($logo->image)){
            unlink('upload/logo_image/'.$logo->image);
        }
        $logo->delete();
        return redirect()->route('logos.view')->with('success', 'Data deleted successfully');
    }
}
