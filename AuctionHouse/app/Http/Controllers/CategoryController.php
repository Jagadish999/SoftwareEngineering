<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Property;
use App\Models\Product;
use App\Models\CustomerBid; 

class CategoryController extends Controller
{
    public function deleteSpecificCategory(Request $request){

        $postData = $request->json()->all();
    
        $categoryId = $postData['categoryId'];
    
        $specificCategory = Category::find($categoryId);
    
        if ($specificCategory) {

            $specificCategory->delete();
            return response()->json(['message' => 'Category deleted successfully']);

        } else {
            
            return response()->json(['message' => 'Category not found'], 404);
        }
    }


    public function deleteSpecificProduct(Request $request)
    {
        $productId = $request->input('id');
    
        $product = Product::find($productId);
    
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
    
        $product->delete();
    
        return response()->json(['message' => 'Product deleted successfully']);
    }

    public function deleteSpecificBid(Request $request){

        $customerBidId = $request->input('customerBidId');

        $customerBid = CustomerBid::find($customerBidId);
    
        if (!$customerBid) {
            return response()->json(['message' => 'Customer bid not found'], 404);
        }
    
        $customerBid->delete();
    
        return response()->json(['message' => 'Customer bid deleted successfully']);
    }
    //________________________________________________________________________________________

    public function store(Request $request)
    {
        $request->validate([
            'categoryName' => 'required|unique:categories,name'
        ]);
    
        // Create a new category
        $category = new Category();
        $category->name = $request->input('categoryName');
        $category->save();

        $propertyNames = $request->input('propertyNames', []);
        $datatypes = $request->input('datatypes', []);

        for ($i = 0; $i < count($propertyNames); $i++) {
            $property = new Property();

            $propertyName = $propertyNames[$i];
            $datatype = $datatypes[$i];
            
            $property->category_id = $category->id;
            $property->name = $propertyName;
            $property->datatype = $datatype;
            
            $property->save();
        }

        return redirect()->route('addproductView');
    }
}
