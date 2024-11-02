<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inquriy Mail</title>
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
        <h1>{{$details['subject']}}</h1>

        <p>Hey, My Name is : {{ $details['f_name'] }}  {{ $details['l_name'] }},</p>

        <p>Email Address : {{ $details['email'] }} </p>

        <p>{{$details['message']}}</p>

        <p>Best regards<br>
        eshop.io TEAM.</p>
    </div>
</body>
</html>
