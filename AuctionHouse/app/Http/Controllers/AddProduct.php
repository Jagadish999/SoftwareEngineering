<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Property;
use App\Models\Product;
use App\Models\ProductDetails;

class AddProduct extends Controller
{
    public function submitProduct(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'productCategory' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        // Get the product category from the form data
        $productCategory = $request->input('productCategory');
    
        // Find the category by name
        $category = Category::where('name', $productCategory)->first();
    
        if ($category) {
            // Get the category ID
            $categoryId = $category->id;
    
            // Create a new Product record
            $product = new Product();
            $product->category_id = $categoryId;
            $product->status = "Show";
    
            // Handle image upload and storage
            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('/product/images/'), $imageName);
                $product->imageName = $imageName;
            }
    
            $product->save();
    
            // Insert all the remaining fields received from form in product_details
            $productDetails = $request->all();
            unset($productDetails['_token'], $productDetails['productCategory'], $productDetails['image']);

            var_dump($productDetails);
    
            foreach ($productDetails as $fieldName => $fieldValue) {

                ProductDetails::create([
                    'product_id' => $product->id,
                    'heading' => $fieldName,
                    'description' => $fieldValue,
                ]);
            }
    
            return redirect()->route('addproductView');
        } else {
            return redirect()->route('addproductView');
        }
    }
    









    public function newProductDetails($productCategory){

        $category = Category::where('name', $productCategory)->first();

        if ($category) {

            //select all the property of category and return to blade
            $propertyDetails = Property::where('category_id', '=', $category->id)->select('name', 'datatype')->get();

            return view('mainLayout.addProductDetails', compact('propertyDetails'), compact('productCategory'));
        } else {

            return redirect()->route('addproductView'); // Replace 'notFound' with your actual route
        }
    }
}
