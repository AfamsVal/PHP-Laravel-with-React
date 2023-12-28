<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    //
    function addProduct(Request $req)
    {
        $product = new Product;
        $product->name = $req->input('name');
        $product->price = $req->input('price');
        $product->description = $req->input('description');
        $product->file_path = $req->file('file')->store('uploads');
        $product->save();
        return $product;

        // for image upload, I created an uploads folder in this path storage/app
    }

    function list()
    {
        return Product::all();
    }

    function delete($id)
    {
        $result = Product::where('id', $id)->delete();
        if ($result) {
            return ['result' => 'product has been deleted'];
        }

        return ['resutl' => 'Request failed!'];
    }

    function getProduct($id)
    {
        $result = Product::find($id);

        if ($result) {

            return $result;
        }
        return null;
    }

    function updateProduct(Request $req, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ['result' => 'Product not found'];
        }

        $product->name = $req->input('name', $product->name);
        $product->price = $req->input('price', $product->price);
        $product->description = $req->input('description', $product->description);

        // Check if a new file is uploaded
        if ($req->hasFile('file')) {
            // Delete the old file
            if ($product->file_path) {
                Storage::delete($product->file_path);
            }

            // Upload the new file
            $product->file_path = $req->file('file')->store('uploads');
        }

        $product->save();

        return ['result' => 'Product has been updated', 'data' => $product];
    }

    function search($query)
    {
        return Product::where('name', 'Like', "%$query%")->get();
    }
}
