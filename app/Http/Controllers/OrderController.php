<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttrProduct;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Shipping;
use App\Models\SKUProduct;
use App\Models\VariantProduct;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all_order = DB::table('tbl_order')
            ->join('tbl_customer','tbl_order.customer_id','=','tbl_customer.customer_id')
            ->select('tbl_order.order_code','tbl_order.created_at','tbl_customer.customer_firstName','tbl_customer.customer_lastName','tbl_order.order_total','tbl_order.order_status')->get();
        return $all_order;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @return array
     */
    public function show($id)
    {
        $aa = DB::table('tbl_order')->where('order_code',$id)->first();
        $customer_id=$aa->customer_id;
        $shipping_id=$aa->shipping_id;
        $order_id = $aa->order_id;
        $order = DB::table('tbl_order')->where('order_code',$id)->get();
        $customer = Customer::where('customer_id',$customer_id)->get();
        $shipping = Shipping::where('shipping_id',$shipping_id)->get();
        $order_detail = OrderDetail::where('order_id',$order_id)->get();
        $data = array();
        foreach ($order_detail as $key => $detail){
            $data['variant'][] = SKUProduct::with('variants')->where('sku_id',$detail->sku_id)->get();
        }
        $attr = Attribute::with('attr_product')->get();

        $data['customer']= $customer;
        $data['shipping']= $shipping;
        $data['order']= $order;
        $data['order_detail']= $order_detail;
        $data['attrValue']= $attr;
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
     * @param  string  $id
     * @return int
     */
    public function destroy($id)
    {
        $order_id = Order::where('order_code', $id)->first()->order_id;

        return Order::destroy($order_id);
    }
}
