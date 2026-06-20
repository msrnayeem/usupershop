<!DOCTYPE html>
<html>
<head>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  padding: 5px;
}
</style>
</head>
<body>
<table  class="text-center myTable" border="1" width="100%">
    <tr>
        <td width="30%">
            <img src="{{ asset('frontend/assets/images/12345.png') }}"
                style="filter: invert(60%) !important;width:240px;" alt="{{ $logo->name }}">
        </td>
        <td width="40%">
            <span><strong>Mobile No : </strong> 01894448136</span><br>
            <span><strong>Email : </strong> examplr@gmail.com</span><br>
            <span>Dhaka, Bangladesh</span>
        </td>
        <td width="30%">
            <?php if(!empty($order->shop_id)){?>
            <strong>Shop ID : {{ $order->shop_id }}</strong> </br>
            <?php } ?>
            <strong>Order No : ODR-#{{ $order->order_no }}</strong>
        </td>
    </tr>
    <tr>
        <td><strong>Billing/Shipping Info :</strong></td>
        <td colspan="2">
            <strong>Name : </strong> {{ $order['shipping']['name'] }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Mobile No : </strong> {{ $order['shipping']['mobile'] }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Email : </strong> {{ $order['shipping']['email'] }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Address : </strong> {{ $order['shipping']['address'] }}
            &nbsp;&nbsp;&nbsp;&nbsp;
            <strong>Payment : </strong>
            {{ $order['payment']['payment_method'] }}
            @if ($order['payment']['payment_method'] == 'Bkash')
                [ Transaction ID : {{ $order['payment']['transaction_no'] }} ]
                &nbsp;&nbsp;&nbsp;&nbsp;
            @endif
        </td>
    </tr>
    <tr>
        <td colspan="3"><strong>Order Details</strong></td>
    </tr>
    <tr>
        <td><strong>Product name & Image</strong></td>
        <td><strong>Color & Size</strong></td>
        <td><strong>Quantity & Price</strong></td>
    </tr>
    @php
    $total = 0;
@endphp

@foreach ($order->order_details as $details)
    <tr>
        <td style="text-align: left;">
            @if ($details->product)
                <img style="width: 50px;height:30px; border: 1px solid #000;background: #fff;padding: 3px;margin: 3px;"
                    src="{{ url('upload/product_images/' . $details->product->image) }}">
                &nbsp;
                {{ $details->product->name }}
            @else
                No product information available
            @endif
        </td>
        <td>
            @if ($details->color_name && $details->size_name)
                {{ $details->color_name }} & {{ $details->size_name }}
            @else
                No color/size information
            @endif
        </td>
        <td>
            @if ($details->product)
                @php
                    $sub_total = $details->quantity * ($details->product->price - $details->product->discount);
                    $total += $sub_total;
                @endphp
                {{ $details->quantity }} X {{ $details->product->price - $details->product->discount }} =
                {{ $sub_total }} Tk.
            @else
                0 Tk.
            @endif
        </td>
    </tr>
@endforeach

<tr>
    <td colspan="2" style="text-align: right;"><strong>Sub Total : </strong></td>
    <td><strong>{{ $total }} Tk.</strong></td>
</tr>

@if ($order->coupon_discount != null)
    <tr>
        <td colspan="2" style="text-align: right;">Coupon Discount : </td>
        <td>{{ $order->coupon_discount }} Tk.</td>
    </tr>
@endif

<tr>
    <td colspan="2" style="text-align: right;">Delivery Charge : </td>
    <td>{{ $order->delivery_charge }} Tk.</td>
</tr>

@php
    $grand_total = round($total - ($order->coupon_discount ?? 0) + $order->delivery_charge);
@endphp

<tr>
    <td colspan="2" style="text-align: right;"><strong>Grand Total : </strong></td>
    <td><strong>{{ $grand_total }} Tk.</strong></td>
</tr>

</table>

</body>
</html>

