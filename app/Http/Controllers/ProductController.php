<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
use Log;

class ProductController extends Controller
{
    /*
     * Function to create new products
     */
    public function create(Request $request) {
        
        $input_validation_results = Validator::make($request->all(),[
            'product_name' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required'
        ], [
            'product_name.required' => 'Product name is required',
            'quantity.required' => 'Quantity is required',
            'quantity.integer' => 'Quantity must be a whole number',
            'quantity.min' => 'Quantity must be minimum 1',
            'price.required' => 'Price is required'
        ]);
        
        if ($input_validation_results->fails()) {
            return response()->json(['status' => 'FAILURE', 'message' => $input_validation_results->errors()], 400);
        }
        
        $contents = json_decode(file_get_contents(storage_path('app/public/inventory.json')), true);
        foreach($contents as $product) {
            if ($request->product_name == $product["product_name"]) {
                return response()->json(['status' => 'FAILURE', 'message' => "Duplicate product name"], 400);
            }
        }
        
        $new_product['product_name'] = $request->product_name;
        $new_product['quantity'] = $request->quantity;
        $new_product['price'] = $request->price;
        $new_product['total_value'] = $request->quantity * $request->price;
        $new_product['date_time'] = date('Y-m-d H:i:s');
        //read the json file, append new product details and write it to json file
        $inventory = file_get_contents(storage_path('app/public/inventory.json'));
        $product_list = json_decode($inventory, true);
        array_push($product_list,$new_product);
        file_put_contents(storage_path('app/public/inventory.json'), json_encode($product_list));
        
        return response()->json(['status' => 'SUCCESS'], 200);
    }
    
    /*
     * This function reads the inventory.json file and responds with its contents
     */
    public function getInventoryList() {
        $contents = json_decode(file_get_contents(storage_path('app/public/inventory.json')), true);
        return response()->json(['status' => 'SUCCESS', 'inventory' => $contents], 200);
    }
}