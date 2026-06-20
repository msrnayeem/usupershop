<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Logo;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    //search product
    public function searchProduct(Request $request)
    {
        $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get();

        $request->validate([
            'search' => 'required'
        ]);

        $data['products'] = Product::where("name", "LIKE", "%" . $request->search . "%")
            ->orWhere('short_desc', "LIKE", "%" . $request->search . "%")
            ->orWhere('sku', "LIKE", "%" . $request->search . "%")
            ->paginate(20);

        return view('frontend.search.search-result', $data);
    }

    //findProducts with ajax
    public function findProducts(Request $request)
    {
        /* $data['logo'] = Logo::first();
        $data['contact'] = Contact::first();
        $data['categories'] = Product::select('category_id')->groupBy('category_id')->get(); */

        $request->validate([
            'search' => 'required'
        ]);

        $products = Product::where("name", "LIKE", "%" . $request->search . "%")
            ->orWhere('short_desc', "LIKE", "%" . $request->search . "%")
            ->orWhere('sku', "LIKE", "%" . $request->search . "%")
            ->take(10)->get();
        // return view('frontend.search.search-product', $data);
        return response()->json($products);
    }
}
