<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Utilities\FileUploadHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function view()
    {
        $data['allData'] = Category::select('id', 'name')->orderBy('id', 'DESC')->get();
        return view('backend.category.view-category', $data);
    }

    public function list(Request $request)
    {
        $draw = $request->input("draw");
        $length = $request->input("length");
        $start = $request->input("start");
        $columns = $request->input('columns');

        $Data = [];
        $Result = Category::getResult($start, $length, $columns);
        $sn = $start + 1;
        foreach ($Result as $key => $Res) {

            if ($Res->image != NULL) {
                $img = "<img style='width:60px; height:40px' src='" . url('upload/category_images/' . $Res->image) . "'>";
            } else {
                $img = "<img style='width:60px; height:40px' src='" . url('frontend/no-image-icon.jpg') . "'>";
            }
            $count_category = Product::where('category_id', $Res->id)->count();

            $EditRoute = route('categories.edit', $Res->id);
            $DeleteRoute = route('categories.delete', $Res->id);

            $action = "<a title='Edit' class='btn btn-sm btn-info' href='$EditRoute'><i class='fas fa-edit'></i> Edit</a>";
            if ($count_category < 1) {
                $action .= " <a title='Delete' class='btn btn-sm btn-danger' href='$DeleteRoute'><i
                class='fas fa-trash'></i> Delete</a>";
            }

            $Data[] = array(
                'sn' => $sn,
                'name' => $Res->name,
                'image' => $img,
                'action' => $action
            );

            $sn++;
        }

        $res = array(
            "draw" => $draw,
            "iTotalRecords" => Category::count(),
            "iTotalDisplayRecords" => Category::countResult($columns),
            "aaData" => $Data
        );

        return response()->json($res);
    }

    public function add()
    {
        return view('backend.category.add-category');
    }

 

    public function store(Request $request)
    {
        // Validation
        $this->validate($request, [
            'name' => 'required|unique:categories,name',
            'image' => 'required|mimes:jpg,png,jpeg|max:1024',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);

        // Prepare data
        $name = str_replace('"', '', $request->name);
        $category = new Category();
        $category->name = $name;
        $category->name_bn = $request->name_bn;
        $category->cat_slug = Str::slug($name);
        $category->created_by = Auth::id();

        // SEO fields
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->meta_keywords = $request->meta_keywords;

        // Image upload
        if ($request->hasFile('image')) {
            $img = $request->file('image');
            $imgName = date('YmdHi') . '_' . $img->getClientOriginalName();
            $img->move(public_path('upload/category_images'), $imgName);
            $category->image = $imgName;
        }

        // Save data
        $category->save();

        return redirect()->route('categories.view')->with('success', 'Category added successfully!');
    }


    public function edit($id)
    {
        $editData = Category::find($id);
        return view('backend.category.add-category', compact('editData'));
    }

    public function update(CategoryRequest $request, $id)
    {
        $data = Category::find($id);
        $data->name = $request->name;
        $data->name_bn = $request->name_bn;
        $data->updated_by = Auth::user()->id;
        /* $data->$request->is_show; */

 // SEO fields
        $data->meta_title = $request->meta_title;
        $data->meta_description = $request->meta_description;
        $data->meta_keywords = $request->meta_keywords;


        $img = $request->file('image');
        if ($img) {
            $imgName = date('YmdHi') . $img->getClientOriginalName();
            $img->move('upload/category_images/', $imgName);
            if (!empty($data->image)) {
                $categoryimagePath = 'upload/category_images/' . $data->image;
                if (file_exists($categoryimagePath)) {
                    unlink($categoryimagePath);
                }
            }
            $data['image'] = $imgName;
        }
        $data->save();
        return redirect()->route('categories.view')->with('success', 'Data updated successfully !!!');
    }

    public function delete($id)
    {
        $data = Category::find($id);
        // Delete image file if it exists
        if (!empty($data->image)) {
            $imagePath = 'upload/category_images/' . $data->image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        // Delete the category record
        $data->delete();
        return redirect()->route('categories.view')->with('success', 'Data deleted successfully !!!');
    }
}
