<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            background-color: #f7f7f7;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order Confirmation</h1>

        <p>Dear {{ $order->user->full_name }},</p>

        <p>Thank you for your order!</p>

        <p>We are pleased to confirm that we have received your order <strong>#{{ $order->order_number }}</strong> placed on <strong>{{ $order->created_at->format('F j, Y') }}</strong>.</p>

        <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
        <p><strong>Shipping:</strong> ${{ number_format($order->delivery_charge, 2) }}</p>
        <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>

        <h3>Shipping Address:</h3>
        <p>
            {{ $order->user->full_name }}<br>
            {{ $order->user->address }}<br>
            {{ $order->user->city }}, {{ $order->user->state }} {{ $order->user->postcode }}<br>
            {{ $order->user->country }}<br>
            <strong>Phone:</strong> {{ $order->user->phone }}
        </p>

        <p>Your order will be processed shortly, and you will receive another email with shipping information once your items are on their way.</p>

        <p>If you have any questions or need assistance, please don't hesitate to contact our customer support team at <strong>support@eshop.io</strong> or <strong>123-456-7890</strong>.</p>

        <p>Thank you for choosing us!</p>

        <p>Best regards,<br>
        Eshop<br>
        eshop.io</p>
    </div>
</body>
</html>
