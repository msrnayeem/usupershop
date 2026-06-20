<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Communication;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function view()
    {
        $data['countContact'] = Contact::count();
        $data['allData'] = Contact::all();
        return view('backend.contact.view-contact', $data);
    }

    public function add()
    {
        return view('backend.contact.add-contact');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'address' => 'required',
            'mobile' => 'required',
            'email' => 'required'
        ]);

        $data = new Contact();
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->facebook = $request->facebook;
        $data->youtube = $request->youtube;
        $data->twitter = $request->twitter;
        $data->google_plus = $request->google_plus;
        $data->created_by = Auth::user()->id;
        $data->save();

        return redirect()->route('contacts.view')->with('success', 'Data inserted successfully');
    }

    public function edit($id)
    {
        $editData = Contact::find($id);
        return view('backend.contact.add-contact', compact('editData'));
    }

    public function update(Request $request, $id)
    {
        $data = Contact::find($id);
        $data->address = $request->address;
        $data->mobile = $request->mobile;
        $data->email = $request->email;
        $data->facebook = $request->facebook;
        $img = $request->file('facebook_icon');
        if($img){
            $facebook_iconImg = date('YmdHi').$img->getClientOriginalName();
            $img->move('upload/contact/', $facebook_iconImg);
            $data['facebook_icon'] = $facebook_iconImg;
        }
        $data->youtube = $request->youtube;
        $youtube_iconImgFile = $request->file('youtube_icon');
        if($youtube_iconImgFile){
            $youtube_iconImg = date('YmdHi').$youtube_iconImgFile->getClientOriginalName();
            $youtube_iconImgFile->move('upload/contact/', $youtube_iconImg);
            $data['youtube_icon'] = $youtube_iconImg;
        }
        $data->twitter = $request->twitter;
        $twitter_iconImgFile = $request->file('twitter_icon');
        if($twitter_iconImgFile){
            $twitter_iconImg = date('YmdHi').$twitter_iconImgFile->getClientOriginalName();
            $twitter_iconImgFile->move('upload/contact/', $twitter_iconImg);
            $data['twitter_icon'] = $twitter_iconImg;
        }
        $data->instagram = $request->instagram;
        $instagram_iconImgFile = $request->file('instagram_icon');
        if($instagram_iconImgFile){
            $instagram_iconImg = date('YmdHi').$instagram_iconImgFile->getClientOriginalName();
            $instagram_iconImgFile->move('upload/contact/', $instagram_iconImg);
            $data['instagram_icon'] = $instagram_iconImg;
        }
        $data->telegram = $request->telegram;
        $telegram_iconImgFile = $request->file('telegram_icon');
        if($telegram_iconImgFile){
            $telegram_iconImg = date('YmdHi').$telegram_iconImgFile->getClientOriginalName();
            $telegram_iconImgFile->move('upload/contact/', $telegram_iconImg);
            $data['telegram_icon'] = $telegram_iconImg;
        }
        $data->whatsapp = $request->whatsapp;
        $whatsapp_iconImgFile = $request->file('whatsapp_icon');
        if($whatsapp_iconImgFile){
            $whatsapp_iconImg = date('YmdHi').$whatsapp_iconImgFile->getClientOriginalName();
            $whatsapp_iconImgFile->move('upload/contact/', $whatsapp_iconImg);
            $data['whatsapp_icon'] = $whatsapp_iconImg;
        }
        $data->updated_by = Auth::user()->id;
        $data->save();

        return redirect()->route('contacts.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete(Request $request)
    {
        $data = Contact::find($request->id);
        $data->delete();

        return redirect()->route('contacts.view')->with('success', 'Data deleted successfully !!!');
    }


    public function viewCommunicate()
    {
        $data['allData'] = Communication::orderBy('id', 'desc')->get();
        return view('backend.contact.view-communicate', $data);
    }

    public function communicateList(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');
        $Data = [];
        $Result = Communication::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {
            $DeleteRoute = route('contacts.communicate.delete', $Res->id);
            $action = " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i class='fas fa-trash'></i> Delete</a>";
            $created = new Carbon($Res->created_at);
            $now = Carbon::now();
            $difference = $created->diff($now)->days < 1 ? 'today' : $created->diffForHumans($now);
            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'email' => $Res->email,
                'mobile' => $Res->mobile,
                'message' => $Res->message,
                'difference' => $difference,
                'action' => $action
            );
            $sn++;
        }
        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Communication::count(),
            "iTotalDisplayRecords" => Communication::countResult($columns),
            "aaData" => $Data
        );
        return response()->json($res);
    }

    public function deleteCommunicate(Request $request, $id)
    {
        $data = Communication::find($id);
        $data->delete();
        return redirect()->route('contacts.communicate')->with('success', 'Data deleted successfully !!!');
    }
}
