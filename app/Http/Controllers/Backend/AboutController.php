<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AboutController extends Controller
{
    public function view(){
        $data['countAbout'] = About::count();
        $data['allData'] = About::all();
        return view('backend.about.view-about',$data);
    }

    public function add(){
        return view('backend.about.add-about');
    }

    public function store(Request $request){
        $this->validate($request,[
            'title' => 'required',
            'description' => 'required'
        ]);

        $data = new About();
        $data->title = $request->title;
        $data->description = $request->description;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('abouts.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id){
        $editData = About::find($id);
        return view('backend.about.add-about', compact('editData'));
    }

    public function update(Request $request, $id){
        $data = About::find($id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()->route('abouts.view')->with('success','Data updated successfully !!!');
    }

    public function delete(Request $request){
        $data = About::find($request->id);
        $data->delete();

        return redirect()->route('abouts.view')->with('success', 'Data deleted successfully !!!');
    }
}
