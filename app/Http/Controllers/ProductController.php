<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Product
     */
    public function create(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:tbl_product,product_name',
            'product_desc' => 'required',
            'product_image' => 'required',
            'product_images.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', //Thêm thuộc tính image vào để đảm bảo chỉ có hình ảnh mới được tải lên
            'product_price' => 'required',
            'category_id' => 'required',
            'product_status' => 'required',
        ]);
        $product = new Product($request->all());
        $get_image = $request->file('product_image');
        $image = new Image;
        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension();
            $get_image->storeAs('public/products', $new_image);
            $image->image_name = $new_image;
            $image->save();
        }
        $product -> product_image = $new_image;
        $product->save();
        return $product;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unactive_product($id)
    {
        $unactive=Product::find($id);
        $unactive->update(['product_status'=>0]);
        return $unactive;

    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function active_product($id)
    {
        $active=Product::find($id);
        $active->update(['product_status'=>1]);
        return $active;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.

     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::where('product_id',$id)->with('attr_value')->with(['skus' => function ($query) {
            $query->with('variants');
        }])->get();
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Product::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return string
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        // Lưu tệp tin vào thư mục public
        $get_image = $request->file('product_image');
        if ($get_image) {
            $original_name = $get_image->getClientOriginalName();
            $name = pathinfo($original_name, PATHINFO_FILENAME);
            $extension = $get_image->getClientOriginalExtension();
            $new_name =  $name.rand(0,999).'.'.$extension;
            $get_image->storeAs('public/products', $new_name);
            $product->product_image = $new_name;
        }

        // Cập nhật các thuộc tính khác
        $data = $request->only([
            'product_name',
            'category_id',
            'product_desc',
            'product_status',
        ]);
        $product->update($data);
        return $product;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}
