<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttrProduct;
use App\Models\SKUProduct;
use App\Models\VariantProduct;
use Illuminate\Http\Request;
use DB;
use Session;
use Illuminate\Database\Eloquent\Builder;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Attribute[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        return Attribute::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request, $id)
    {
        $product_id = $request->input('product_id');
        $attributes = $request->input('attributes');
        foreach ($attributes as $key => $attribute) {
                if(empty($attribute['value'])){
                    continue;
                }
            // Thực hiện các lệnh khác nếu cần
            if (isset($attribute['value'])) {
                $attr_value = new AttrProduct();
                $attr_value->product_id = $product_id;
                $attr_value->attr_id = $attribute['attr_id'];
                $attr_value->value = $attribute['value'];
                $attr_value->save();
            }
        }
        return response()->json(['success' => true]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function createVariant(Request $request, $id)
    {
        //create Array for data
        $attributes = $request->input('attributes');
        $product_id = $request->input('product_id');
        $price = $request->input('price');
        $stock = $request->input('stock');
        $data_skuProduct = array();
        $data_skuProduct['product_id'] = $product_id;
        $data_skuProduct['price'] = $price;
        $data_skuProduct['stock'] = $stock;
        $sku_id = DB::table('sku_products')->insertGetId($data_skuProduct);
        foreach ($attributes as $key => $attribute) {
            if (isset($attribute['attr_id'])) {
                $data_variant = new VariantProduct();
                $data_variant['product_id'] = $product_id;
                $data_variant['sku_id'] = $sku_id;
                $data_variant['attr_id'] = $attribute['attr_id'];
                $data_variant['attr_value_id'] = $attribute['attr_value_id'];
                $data_variant->save();
            }
        }

        return response()->json(['success' => true]);

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
     *
     * @param  int  $id
     * @return Attribute[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function showAttrValue()
    {
        $id = request()->query('product_id');
        $attr_id = request()->query('attr_id');
        $all_attrValue = AttrProduct::where('product_id', $id)->where('attr_id', $attr_id)->get();
        return $all_attrValue;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Attribute[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function showVariantPros()
    {
        $id = request()->query('product_id');
//        $attr_id = request()->query('attr_id');
        $all_variant = SKUProduct::where('product_id',$id)->with('variants')->get();
        return $all_variant;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
//        $timber_value = Attr_value::where('product_id',$product_id)->where('attr_value',1)->get();
//        $size_value = Attr_value::where('product_id',$product_id)->where('attr_value',2)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroy($id)
    {
        return AttrProduct::destroy($id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int
     */
    public function destroySKU($id)
    {
        return SKUProduct::destroy($id);
    }
}
