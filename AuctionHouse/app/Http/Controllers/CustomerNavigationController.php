<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetails;
use App\Models\CustomerBid;

class CustomerNavigationController extends Controller
{

    public function approvedProduct(){

        $userDetails = auth()->user();
    
        $allPendingProduct = CustomerBid::where('user_id', $userDetails->id)
        ->where('status', 'Approved')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get(['product_id', 'userBidAmt', 'status']);

        foreach ($allPendingProduct as $pendingProduct) {
            $product = Product::find($pendingProduct->product_id);
            if ($product) {
                $category = Category::find($product->category_id);
                $pendingProduct->image = $product->imageName;
                $pendingProduct->category_name = $category ? $category->name : 'N/A';
            } else {
                // Handle the case where the product is not found
                $pendingProduct->image = 'default_image.jpg'; // Provide a default image
                $pendingProduct->category_name = 'N/A';
            }
        }
    
        return view('mainlayout.approvedProductView', compact('allPendingProduct'));
    }

    public function pendingProduct(){

        $userDetails = auth()->user();
    
        $allPendingProduct = CustomerBid::where('user_id', $userDetails->id)
        ->where('status', 'Unapproved')
        ->orderBy('id', 'desc')
        ->limit(6)
        ->get(['id', 'product_id', 'userBidAmt', 'status']);

        foreach ($allPendingProduct as $pendingProduct) {
            $product = Product::find($pendingProduct->product_id);
            if ($product) {
                $category = Category::find($product->category_id);
                $pendingProduct->image = $product->imageName;
                $pendingProduct->category_name = $category ? $category->name : 'N/A';
            } else {
                // Handle the case where the product is not found
                $pendingProduct->image = 'default_image.jpg'; // Provide a default image
                $pendingProduct->category_name = 'N/A';
            }
        }
    
        return view('mainlayout.customerPendingProductView', compact('allPendingProduct'));
    }
    


    public function buyProductList(){
        $userDetails = auth()->user();
    
        if($userDetails->role == 'customer'){
            // Take list of all products from the product table
            $products = Product::select('id', 'category_id', 'imageName')
            ->where('status', '=', 'Show')
            ->get();

            $result = [];
            $productDetails = [];
    
            foreach ($products as $product) {
                $category = Category::find($product->category_id);
    
                if ($category) {
                    $result[] = [
                        'id' => $product->id,
                        'category_name' => $category->name,
                        'image_Name' => $product->imageName,
                    ];
                }
    
                // Retrieve product details for the current product
                $details = ProductDetails::where('product_id', $product->id)
                    ->orderBy('id', 'asc')
                    ->get(['heading', 'description']);
    
                // Add the product details to the productDetails array, including the product ID
                $productDetails[] = [
                    'product_id' => $product->id,
                    'details' => $details,
                ];
            }

            $allCategory = Category::pluck('name');
    
            // Pass both $result and $productDetails to the view
            return view('mainlayout.customerProductView', compact('result', 'productDetails', 'allCategory'));
        }
        else{
            return redirect()->route('dashboard');
        }
    }
    
}
