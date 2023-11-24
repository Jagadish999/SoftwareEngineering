<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;

class SearchController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $filter = $request->input('filter');

        $products;
        //Find product Details
        if($filter == "all"){
            $products = Product::select('id', 'category_id', 'imageName')
            ->where('status', '=', 'Show')
            ->get();
        }
        else{

            $categoryFilter = Category::where('name', $filter)->first();

            $products = Product::select('id', 'category_id', 'imageName')
            ->where('status', '=', 'Show')
            ->where('category_id', '=', $categoryFilter->id)
            ->get();
        }

        $result = [];
        $productDetails = [];

        foreach ($products as $product) {

            $category = Category::find($product->category_id);

            if( $search != ""){

                $details = ProductDetails::where('product_id', $product->id)
                ->where('heading', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%')
                ->orderBy('id', 'asc')
                ->get(['heading', 'description']);

                if($details){
                    $result[] = [
                        'id' => $product->id,
                        'category_name' => $category->name,
                        'image_Name' => $product->imageName,
                    ];

                    $productDetails[] = [
                        'product_id' => $product->id,
                        'details' => $details,
                    ];
                }

            }
            else{
                //Get details 
                $details = ProductDetails::where('product_id', $product->id)
                ->orderBy('id', 'asc')
                ->get(['heading', 'description']);

                if($details){
                    $result[] = [
                        'id' => $product->id,
                        'category_name' => $category->name,
                        'image_Name' => $product->imageName,
                    ];

                    $productDetails[] = [
                        'product_id' => $product->id,
                        'details' => $details,
                    ];
                }
            }
        }

        $allCategory = Category::pluck('name');

        return view('mainlayout.customerProductView', compact('result', 'productDetails', 'allCategory'));
    }
}
