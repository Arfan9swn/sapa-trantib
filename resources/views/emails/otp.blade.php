<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Anda - SapaTrantib</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #1a3326;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
            text-align: center;
        }
        .logo {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 30px;
            letter-spacing: 0.5px;
        }
        .title {
            font-size: 36px;
            font-weight: 600;
            color: #ffffff;
            margin: 0 0 15px 0;
            letter-spacing: 1px;
        }
        .otp-code {
            font-size: 32px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 8px;
            margin: 0 0 10px 0;
            border-bottom: 2px solid #8fd89b;
            display: inline-block;
            padding-bottom: 8px;
        }
        .footer {
            font-size: 12px;
            color: #a6d189;
            margin-top: 30px;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">Sapa-Trantib</div>
        <div class="title">KODE OTP ANDA</div>
        <div class="otp-code">{{ $otpCode }}</div>
        <div class="footer">
            Jika anda merasa tidak pernah membuat akun untuk Sapa-Trantib, mohon abaikan pesan ini.
        </div>
    </div>
</body>
</html>