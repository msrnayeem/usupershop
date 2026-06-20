<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\BannerImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BannerImageController extends Controller
{
    public function view(){
        $data['countBanner'] = BannerImage::count();
        $data['allData'] = BannerImage::select('id','banner_small_image_one',
        'banner_small_image_two','category_banner_image','shop_page_banner')->orderBy('id','DESC')->get();
        return view('backend.banner.view-banner',$data);
    }

    public function edit($id){
        $data['editData'] = BannerImage::find($id);
        return view('backend.banner.add-banner', $data);
    }

    public function update(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $this->validate($request, [
                'banner_small_image_one' => 'nullable','image','mimes:png,jpg','1048',
                'banner_small_image_two' => 'nullable','image','mimes:png,jpg','1048',
                'category_banner_image' => 'nullable','image','mimes:png,jpg','2048',
                'shop_page_banner' => 'nullable','image','mimes:png,jpg','2048'
            ]);
            $data = BannerImage::find($id);
            // Define an array of banner fields and their respective input names
            $bannerFields = [
                'banner_small_image_one',
                'banner_small_image_two',
                'category_banner_image',
                'shop_page_banner'
            ];

            // Loop through each banner field to handle file upload and deletion
            foreach ($bannerFields as $field) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    // Generate a new file name
                    $fileName = date('YmdHi') . $file->getClientOriginalName();
                    // Move the file to the 'upload/banner/' directory
                    $file->move('upload/banner/', $fileName);
                    // Remove the old file if it exists
                    if (!empty($data->$field)) {
                        $bannerPath = 'upload/banner/'.$data->field;
                        if (file_exists($bannerPath)) {
                            // unlink($bannerPath);
                        }
                    }
                    // Update the field with the new file name
                    $data->$field = $fileName;
                }
            }
            // Save the updated data
            $data->save();
        });

        return redirect()->route('banners.view')->with('success', 'Banner data updated successfully');
    }

   
    
}
