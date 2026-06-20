<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - ODR-#{{ $order->order_no }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 30px;
            background: #f9f9f9;
            color: #333;
        }

        .invoice-container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header-row td {
            vertical-align: middle;
            border: none;
        }

        .logo img {
            max-height: 130px;
            width: auto;
        }

        .company-info h2 {
            margin: 0 0 12px 0;
            color: #2c3e50;
            font-size: 28px;
        }

        .company-info p {
            margin: 4px 0;
            font-size: 15px;
        }

        .order-info {
            font-size: 16px;
        }

        .order-no {
            font-size: 22px;
            color: #e74c3c;
            font-weight: bold;
        }

        hr {
            border: none;
            border-top: 2px solid #eee;
            margin: 30px 0;
        }

        .dashed-hr {
            border-top: 1px dashed #ccc;
        }

        .items-table th {
            background-color: #f8f9fa;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }

        .items-table td {
            border-bottom: 1px solid #eee;
        }

        .product-img {
            width: 70px;
            height: 55px;
            object-fit: cover;
            border: 1px solid #ddd;
            padding: 4px;
            background: #fff;
            margin-right: 12px;
            vertical-align: middle;
            border-radius: 4px;
        }

        .product-cell {
            display: flex;
            align-items: center;
        }

        .total-row {
            font-weight: bold;
            background-color: #f8f9fa !important;
        }

        .grand-total {
            font-size: 1.4em;
            background-color: #e8f5e9 !important;
            color: #27ae60;
            font-weight: bold;
        }

        .footer-note {
            text-align: center;
            margin-top: 50px;
            color: #7f8c8d;
            font-style: italic;
            font-size: 15px;
        }

        @media print {
            body {
                background: white;
                padding: 20px;
            }

            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 20px 30px;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Header Section -->
        <table class="header-row">
            <tr>
                <td width="30%" class="logo text-center">
                    <img src="{{ public_path('upload/logo_image/' . $logo->image) }}" alt="U Super Shop Logo">
                </td>
                <td width="40%" class="company-info text-center">
                    <p>
                        <strong>Whatsapp:</strong> 01894448136<br>
                        <strong>Email:</strong> example@gmail.com<br>
                        Dhaka, Bangladesh
                    </p>
                </td>
                <td width="30%" class="order-info text-center text-md-right">
                    @if (!empty($order->shop_id))
                        <p><strong>Shop ID:</strong> {{ $order->shop_id }}</p>
                    @endif
                    <p class="order-no">Order No: ODR-#{{ $order->order_no }}</p>
                    <p><strong>Invoice Date:</strong> {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                    </p>
                </td>
            </tr>
        </table>

        <hr>

        <!-- Customer Information -->
        <table>
            <tr>
                <td width="20%"><strong>Billing / Shipping Info:</strong></td>
                <td>
                    <strong>Name:</strong> {{ $order['shipping']['name'] ?? 'N/A' }}<br>
                    <strong>Mobile No:</strong> {{ $order['shipping']['mobile'] ?? 'N/A' }}<br>
                    <strong>Email:</strong> {{ $order['shipping']['email'] ?? 'N/A' }}<br>
                    <strong>Address:</strong> {{ $order['shipping']['address'] ?? 'N/A' }}<br>
                    <strong>Payment Method:</strong> {{ $order['payment']['payment_method'] ?? 'N/A' }}
                    @if (($order['payment']['payment_method'] ?? '') == 'Bkash')
                        &nbsp;&nbsp; [ <strong>Transaction ID:</strong>
                        {{ $order['payment']['transaction_no'] ?? 'N/A' }} ]
                    @endif
                </td>
            </tr>
        </table>

        <hr class="dashed-hr">

        <!-- Order Items -->
        <h3 style="text-align: center; margin: 25px 0 20px;">Order Details</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th class="text-center">Color / Size</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-right">Unit Price (Tk.)</th>
                    <th class="text-right">Total (Tk.)</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($order->order_details as $details)
                    @if ($details->product)
                        @php
                            $itemPrice = $details->product->price - $details->product->discount;
                            $sub_total = $details->quantity * $itemPrice;
                            $total += $sub_total;
                        @endphp
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <img src="{{ public_path('upload/product_images/' . $details->product->image) }}"
                                        class="product-img" alt="{{ $details->product->name }}">
                                    {{ $details->product->name }}
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $details->color_name ?? 'N/A' }} / {{ $details->size_name ?? 'N/A' }}
                            </td>
                            <td class="text-center">{{ $details->quantity }}</td>
                            <td class="text-right">{{ number_format($itemPrice, 2) }}</td>
                            <td class="text-right">{{ number_format($sub_total, 2) }}</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="5" class="text-center text-muted">No product information available</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                    <td class="text-right"><strong>{{ number_format($total, 2) }} Tk.</strong></td>
                </tr>
                @if ($order->coupon_discount ?? 0 > 0)
                    <tr class="total-row">
                        <td colspan="4" class="text-right">Coupon Discount:</td>
                        <td class="text-right">- {{ number_format($order->coupon_discount, 2) }} Tk.</td>
                    </tr>
                @endif
                <tr class="total-row">
                    <td colspan="4" class="text-right">Delivery Charge:</td>
                    <td class="text-right">{{ number_format($order->delivery_charge ?? 0, 2) }} Tk.</td>
                </tr>
                @php
                    $grand_total = round($total - ($order->coupon_discount ?? 0) + ($order->delivery_charge ?? 0));
                @endphp
                <tr class="grand-total">
                    <td colspan="4" class="text-right"><strong style="font-size:1.4em;">Grand Total:</strong></td>
                    <td class="text-right"><strong style="font-size:1.4em;">{{ number_format($grand_total, 2) }}
                            Tk.</strong></td>
                </tr>
            </tfoot>
        </table>

        <!-- Footer Note -->
        <div class="footer-note">
            <p>Thank you for shopping with <strong>U Super Shop</strong>!<br>
                For any inquiries, please contact us at 01894448136 or example@gmail.com</p>
        </div>
    </div>
</body>

</html>
