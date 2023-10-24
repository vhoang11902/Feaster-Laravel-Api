<?php

namespace App\Http\Controllers;

use App\Models\AttrProduct;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Prod_variant;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\SKUProduct;
use App\Models\VariantProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use DB;
use Session;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return array|false|string
     */
    public function store(Request $request)
    {
        $dataUser = $request->user;

        $data_customer = array();
        $data_shipping = array();
//        shipping
        foreach ($dataUser as $user){
        $data_shipping['shipping_country'] = $user['country'];
        $data_shipping['shipping_city'] = $user['city'];
        $data_shipping['shipping_address'] = $user['address'];
        $data_shipping['shipping_state'] = $user['state'];
        $data_shipping['shipping_postal_code'] = $user['postalCode'];
//        customer
        $data_customer['customer_firstName'] = $user['firstName'];
        $data_customer['customer_lastName'] = $user['lastName'];
        $data_customer['customer_phone'] = $user['phoneNumber'];
        $data_customer['customer_email'] = $user['email'];
        $customer_id = DB::table('tbl_customer')->insertGetId($data_customer);
        Session::put('customer_id',$customer_id);
        $data_shipping['customer_id'] = $customer_id;
        $shipping_id = DB::table('tbl_shipping')->insertGetId($data_shipping);
        Session::put('shipping_id',$shipping_id);
        }

        $order_data = array();
        $order_detail_data = array();

        $total = $request->total;
//        order_data
        $checkout_code = substr(md5(microtime()), rand(0, 26), 10);
        $order_data['customer_id'] = Session::get('customer_id');
        $order_data['shipping_id'] = Session::get('shipping_id');
        $order_data['order_total'] = $total;
        $order_data['order_status'] = $request['status'];
        $order_data['order_code'] = $checkout_code;
        $order_data['created_at'] = now();
        $order_id = DB::table('tbl_order')->insertGetId($order_data);
//        order_detail_data
        $dataCartItems = $request->cartItems;
        foreach ($dataCartItems as $item) {
            $sku_id = $item['id'];
            $sku = SKUProduct::find($sku_id)->first();
            $product = Product::find($sku['product_id'])->first();
            $order_detail_data['product_name'] = $product['product_name'];
            $order_detail_data['product_id'] = $sku['product_id'];
            $order_detail_data['sku_id'] = $sku_id;
            $order_detail_data['product_price'] = $item['price'];
            $order_detail_data['product_qty'] = $item['quantity'];
            SKUProduct::where('sku_id', $sku_id)->update(['stock' => $sku->stock - $item['quantity']]);
            $order_detail_data['order_id'] = $order_id;
            DB::table('tbl_order_detail')->insertGetId($order_detail_data);
        }
//sendMail
        $attrValue = array();
        $order = Order::where('order_id',$order_id)->first();
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = Shipping::where('shipping_id',$shipping_id)->first();
        $order_detail=OrderDetail::where('order_id',$order_id)->get();
        foreach ($order_detail as $attr){
            $sku_id = $attr['sku_id'];
            $variant = VariantProduct::where('sku_id',$sku_id)->get();
            $attr_value = AttrProduct::all();
            foreach ($variant as $v) {
                foreach ($attr_value as $a) {
                    if ($v['attr_value_id'] == $a['attr_value_id']) {
                        if (!isset($attrValue[$sku_id])) {
                            $attrValue[$sku_id] = array();
                        }
                        $attrValue[$sku_id][] = $a['value'];
                    }
                }
            }
        }
        $data = array("customer"=> $customer,
            "shipping"=> $shipping,
            "order_detail"=>$order,
            "order_detail_pro" => $order_detail,
            "attrValue"=>$attrValue); //body of mail.blade.php
        $mail = $customer->customer_email;
        $to_name = "3JFurniture VietNam";
        $to_email = $mail;//send to this email
        Mail::send('mail.send_mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Feaster xác nhận đơn hàng của bạn');
            $message->from($to_email, $to_name);
        });
        return $checkout_code;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
