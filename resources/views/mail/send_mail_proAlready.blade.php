<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        *{
            color: rgb(32,32,32);
            font-size: 14px;
            font-weight: normal;
            font-family: Helvetica,Arial,sans-serif!important;
            line-height: 150%!important;
        }
        body{
            position: relative;

        }
        .content{
            margin: auto;
            max-width: 730px;
            background-color:  #f1f1f1;
        }
        .body-content{
            padding: 30px;
            background-color: #fff;
            border-bottom: 10px solid #f0f0f0;
        }
        header{
            text-align: center;
            margin: 20px 0;
        }
        header img{
            width: 20%;
            margin: 20px;
        }
        table{
            border-collapse: separate;
            -webkit-border-horizontal-spacing: 2px;
            -webkit-border-vertical-spacing: 2px;
            text-indent: initial;
        }
        tr{
            display: table-row;
            vertical-align: inherit;
            border-top-color: inherit;
            border-right-color: inherit;
            border-bottom-color: inherit;
            border-left-color: inherit;
        }
    </style>
</head>
<body>
<div class="content">
    <div class="body-content">
        <header>
            <img src="{{asset('public/FrontEnd/img/logo.png')}}">
            <h1>3JFurniture xử lý đơn hàng của bạn !</h1>
            <h2> Đơn hàng #{{$order_detail->order_code}}</h2>
        </header>
        <section class="info">
            <h1>Xin chào {{$customer->customer_name}},</h1>
            <div>3JFurniture đã xử lý và tiến hành vận chuyển đơn hàng của bạn.
                Bạn sẽ nhận được thông báo tiếp theo khi đơn hàng đã sẵn sàng được giao.</div>
        </section>
    </div>
    <div class="body-content">
        <div> Đơn hàng được giao đến </div>
        <table style="width: 100%;">
            <tr>
                <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">Name: </td>
                <td width="75%" valign="top">{{$customer->customer_name}}</td>
            </tr>
            <tr>
                <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">Address: </td>
                <td width="75%" valign="top">{{$shipping->shipping_address}}, {{$shipping->shipping_city}},{{ $shipping->shipping_state}},
                    {{$shipping->shipping_country}}</td>
            </tr>
            <tr>
                <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">Phone: </td>
                <td width="75%" valign="top">{{$customer->customer_phone}}</td>

            </tr>
            <tr>
                <td width="25%" valign="top" style="color:#0f146d;font-weight:bold">Email: </td>
                <td width="75%" valign="top">{{$customer->customer_email}}</td>
            </tr>
        </table>
    </div>
    <div class="body-content">
        <div> Kiện hàng #{{$order_detail->order_code}} </div>
        <table style="width: 100%;">
            @foreach($order_detail_pro as $key => $product)
                @php
                    $totalProduct = $product->product_name * $product->product_name;
                    $total = 0;
                    $total += $totalProduct;
                @endphp
                <tbody>
                <tr>
                    <td style="width:40%">
                        <div style="padding-right:10px">
                            <a href="https://c.lazada.vn/t/c.VkePT?sub_id1=Trade&amp;sub_id2=VN_VOYAGER_OrderConfirmation_nonCOD&amp;sub_id3=20230606&amp;sub_id4=main&amp;url=https%3A%2F%2Fwww.lazada.vn%2Fproducts%2Fi1712678197-s7627795634.html%3FurlFlag%3Dtrue%26mp%3D1" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://c.lazada.vn/t/c.VkePT?sub_id1%3DTrade%26sub_id2%3DVN_VOYAGER_OrderConfirmation_nonCOD%26sub_id3%3D20230606%26sub_id4%3Dmain%26url%3Dhttps%253A%252F%252Fwww.lazada.vn%252Fproducts%252Fi1712678197-s7627795634.html%253FurlFlag%253Dtrue%2526mp%253D1&amp;source=gmail&amp;ust=1687070595227000&amp;usg=AOvVaw3pggPOZC9Fn3DW55Zy2HKR"><img src="https://ci5.googleusercontent.com/proxy/V9_msI4Em8RVI_Pe6y2JnVOrihhm6bdF6mafp4lUJd23910AeXQFquwYPKuV3kzq7F1olChBo15CseRur9KJ1Qr-PKoacdSQ56bFOhIG_jAcne72Ff5H=s0-d-e1-ft#https://sg-live-01.slatic.net/p/d075c9da4437abd5b3dc1b0110ba89e1.png" style="width:100%;max-width:160px" class="CToWUd" data-bit="iit"></a>
                        </div>
                    <td style="width:60%">
                        <div class="infoName">{{$product->product_name}}</div>
                        <div class="infoAttr">{{$product->product_timber}}, {{$product->product_size}}</div>
                        <div class="infoPrice">Price: {{$product->product_price}}</div>
                        <div class="infoQty">Số lượng: {{$product->product_sales_qty}}</div>
                    </td>
                    </td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>
    <div class="body-content">
        <table style="width: 100%;">
            <tbody>
            <tr>
                <td valign="top" style="color:#585858;width:49%">Thành tiền:</td>
                <td align="right" valign="top">$</td>
                <td align="right" valign="top">{{$total}}</td>
            </tr>
            <tr>
                <td valign="top" style="color:#585858">Phí vận chuyển:</td>
                <td align="right" valign="top">$</td>
                <td align="right" valign="top">FREE</td>
            </tr>
            {{--            <tr>--}}
            {{--                <td valign="top" style="color:#585858">Giảm giá:</td>--}}
            {{--                <td align="right" valign="top">VND</td>--}}
            {{--                <td align="right" valign="top">(183.450)</td>--}}
            {{--            </tr>--}}
            <tr>
                <td valign="top" style="color:#585858">Tổng cộng:</td>
                <td align="right" valign="top"><div style="color:#f27c24;font-weight:bold">$</div></td>
                <td align="right" valign="top"><div style="color:#f27c24;font-weight:bold">{{$total}}</div></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>


</body>
</html>
