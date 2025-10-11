<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <title>Xác thực email - LilGoat</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }
        .header {
            text-align: center;
            padding: 15px 0;
        }
        .header img {
            max-width: 120px;
            border-radius: 50%;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content h1 {
            color: #333333;
            font-size: 22px;
        }
        .content p {
            color: #555555;
            font-size: 15px;
            line-height: 1.6;
        }
        .button {
            display: inline-block;
            padding: 12px 24px;
            font-size: 16px;
            color: #ffffff !important;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px auto;
            transition: background-color 0.2s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .footer {
            text-align: center;
            padding: 15px;
            color: #777777;
            font-size: 13px;
            border-top: 1px solid #eeeeee;
            margin-top: 30px;
        }
        .footer .contact {
            margin-top: 10px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://img.freepik.com/free-vector/hand-drawn-baphomet-illustration_23-2149833774.jpg?size=338&ext=jpg&ga=GA1.1.1700460183.1712620800&semt=ais" alt="Goat Logo">
        </div>

        <div class="content">
            <h1>Xác thực địa chỉ email</h1>
            <p>Kính chào <b>{{ $user->name }}</b>,</p>
            <p>Bạn vừa đăng ký thành công tài khoản trên hệ thống <strong>LilGoat</strong>.</p>
            <p><i>Nếu đây không phải là hành động của bạn, vui lòng bỏ qua email này.</i></p>

            <a href="{{ $url }}" class="button">Xác nhận Email</a>

            <p>Trân trọng cảm ơn Quý khách đã tin tưởng sử dụng dịch vụ!</p>
        </div>

        <div class="footer">
            <p>Vui lòng liên hệ bộ phận chăm sóc khách hàng để được hỗ trợ:</p>
            <div class="contact">
                <p>0395 419 293</p>
                <p>tranphongbackend@gmail.com</p>
            </div>
            <p>&copy; {{ date('Y') }} Pii Shop. Mọi quyền được bảo lưu.</p>
        </div>
    </div>
</body>
</html>
