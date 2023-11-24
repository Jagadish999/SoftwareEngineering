<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Property;
use App\Models\Product;
use App\Models\CustomerBid;
use Illuminate\Support\Facades\DB;

class UserNavigationController extends Controller
{

    public function approveViewAdmin(){
        //Find CustomerBid for

        $highestBids = CustomerBid::where('status', 'Unapproved')->get();

        foreach ($highestBids as $bid) {

            // Retrieve product image
            $product = Product::find($bid->product_id);
            if ($product) {
                $bid->productImage = $product->imageName;
            } else {
                $bid->productImage = null;
            }
        }

        return view('mainlayout.adminApprovesProduct', compact('highestBids'));
    }


    public function allProductView(){

        $userDetails = auth()->user();

        if($userDetails->role == 'admin'){

            //Take list of all product from product table
            $products = Product::select('id', 'category_id', 'imageName', 'status')->get();
            $result = [];

            foreach ($products as $product) {
                $category = Category::find($product->category_id);
            
                if ($category) {
                    $result[] = [
                        'id' => $product->id,
                        'category_name' => $category->name,
                        'image_Name' => $product->imageName,
                        'status' => $product->status
                    ];
                }
            }

            return view('mainlayout.product', compact('result'));
        }
        else{
            return Redirect::route('dashboard');
        }
    }

    public function addProductView(){
        $userDetails = auth()->user();

        if($userDetails->role == 'admin'){
            $allCategoryNames = Category::pluck('name', 'id');
            return view('mainlayout.addProduct', compact('allCategoryNames'));
        }

        return view('mainlayout.dashboard');
    }

    public function dashboardView(){

        $userDetails = auth()->user();

        if($userDetails->role == 'admin'){
            return redirect()->route('addcategory');
        }

        return redirect()->route('customerBuyProduct');
    }

    public function addCategoryView(){

        $userDetails = auth()->user();

        if($userDetails->role == 'admin'){
            return view('mainlayout.addcategory');
        }

        return view('mainlayout.dashboard');
    }
}
