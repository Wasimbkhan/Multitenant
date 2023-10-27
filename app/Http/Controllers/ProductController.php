<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
use Stancl\Tenancy\Database\Models\Domain;

class ProductController extends Controller
{
    private $rootDir = "/tenant_images";

    public function getTenant(Request $request)
    {
        $tenant = Domain::where('tenant_id', tenancy()->tenant->id)->first();
        return response()->json([
            'tenant' => $tenant
        ], 200);
    }

    public function getAllProduct(Request $request)
    {
        $products = Product::all();
        return response()->json([
            'products' => $products
        ], 200);
    }

    public function addProduct(Request $request)
    {
        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        if ($request->photo != '') {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $dirname = $this->rootDir.'/tenant' . tenancy()->tenant->id . '/product_image/';
            $upload_path = public_path() . $dirname;
            if (!File::exists($upload_path)) {
                File::makeDirectory($upload_path, 0755, true);
            }
            $img->save($upload_path . $name);
            $imgpath = $dirname . $name;
            $product->photo = $imgpath;
        } else {
            $product->photo = "image.png";
        }

        $product->photo = $imgpath;
        $product->type = $request->type;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
    }

    public function getSingleProduct($id)
    {
        $product = Product::find($id);

        return response()->json([
            'product' => $product
        ], 200);
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        if ($product->photo != $request->photo) {
            $strpos = strpos($request->photo, ';');
            $sub = substr($request->photo, 0, $strpos);
            $ex = explode('/', $sub)[1];
            $name = time() . "." . $ex;
            $img = Image::make($request->photo)->resize(200, 200);
            $dirname = $this->rootDir.'/tenant' . tenancy()->tenant->id . '/product_image/';
            $upload_path = public_path() . $dirname;
            if (!File::exists($upload_path)) {
                File::makeDirectory($upload_path, 0755, true);
            }
            $image = public_path() . $product->photo;
            $img->save($upload_path . $name);
            $imgpath = $dirname . $name;
            if (file_exists($image)) {
                @unlink($image);
            }
        } else {
            $imgpath = $product->photo;
        }

        $product->photo = $imgpath;
        $product->type = $request->type;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrfail($id);
        $image = public_path() . $product->photo;
        if (file_exists($image)) {
            @unlink($image);
        }
        $product->delete();
    }
}
