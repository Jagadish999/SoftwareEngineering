<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductUpdater extends Controller
{
    public function updateProductStatus(Request $request){


        $userDetails = auth()->user();
        $postData = $request->json()->all();
        
        $product = Product::find($postData['id']);

        if ($product) {

            if($product->status == "Show"){
                $product->status = "Hide";
            }
            else{
                $product->status = "Show";
            }
            $product->save();
    
            // Return a success response
            return response()->json(['message' => 'Product status updated successfully']);
        }
    }
}
