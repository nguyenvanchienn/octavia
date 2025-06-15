<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $title = "Sản phẩm";
        $product = Product::all();

        return view('/product/index', compact("title", "product"));
    }

    public function getProductData($id)
    {
        $product = Product::find($id);

        return $product;
    }

    public function addProductGet()
    {
        $title = "Thêm sản phẩm";

        return view('/product/add_product', compact("title"));
    }

    public function addProductPost(Request $request)
    {
        $validatedData = $request->validate([
            "product_name" => "required|max:25",
            "stock" => "required|numeric|gt:0",
            "price" => "required|numeric|gt:0",
            "discount" => "required|numeric|gt:0|lt:100",
            "orientation" => "required",
            "description" => "required",
            "image" => "image|max:2048"
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $filePath = 'product/' . $fileName;

            $file->storeAs('product', $fileName);
            $validatedData["image"] = $filePath;
        } else {
            $validatedData["image"] = env("IMAGE_PRODUCT");
        }

        try {
            Product::create($validatedData);
            $message = "Sản phẩm đã được thêm thành công!";

            myFlasherBuilder(message: $message, success: true);

            return redirect('/product');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }

    public function editProductGet(Product $product)
    {
        $data["title"] = "Chỉnh sửa sản phẩm";
        $data["product"] = $product;

        return view("/product/edit_product", $data);
    }

    public function editProductPost(Request $request, Product $product)
    {
        $rules = [
            'orientation' => 'required',
            'description' => 'required',
            'price' => 'required|numeric|gt:0',
            'stock' => 'required|numeric|gt:0',
            'discount' => 'required|numeric|gt:0|lt:100',
            'image' => 'image|file|max:2048'
        ];

        if ($product->product_name != $request->product_name) {
            $rules['product_name'] = 'required|max:25|unique:products,product_name';
        } else {
            $rules['product_name'] = 'required|max:25';
        }

        $validatedData = $request->validate($rules);

        try {
            if ($request->hasFile("image")) {
                if ($product->image && $product->image != env("IMAGE_PRODUCT")) {
                    Storage::delete($product->image);
                }

                $file = $request->file("image");
                $fileName = $file->getClientOriginalName();
                $filePath = 'product/' . $fileName;

                $file->storeAs('product', $fileName);
                $validatedData["image"] = $filePath;
            }

            $product->fill($validatedData);

            if ($product->isDirty()) {
                $product->save();

                $message = "Sản phẩm đã được cập nhật thành công!";

                myFlasherBuilder(message: $message, success: true);
                return redirect("/product");
            } else {
                $message = "Thao tác <strong>thất bại</strong>, không có thay đổi nào!";

                myFlasherBuilder(message: $message, failed: true);
                return back();
            }
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }

    public function deleteProduct(Product $product)
    {
        try {
            if ($product->image && $product->image != env("IMAGE_PRODUCT")) {
                Storage::delete($product->image);
            }

            $product->delete();

            $message = "Sản phẩm đã được xóa thành công!";
            myFlasherBuilder(message: $message, success: true);

            return redirect('/product');
        } catch (\Illuminate\Database\QueryException $exception) {
            return abort(500);
        }
    }

}
