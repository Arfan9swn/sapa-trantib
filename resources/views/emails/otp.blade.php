<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP Anda - SapaTrantib</title>
    <style>
        div {
            margin: 0;
            padding: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #2d3b2c;
            color: #ffffff;
        }
        .container {
            padding: 40px 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgb(255,255,255);
            display: inline-block;
            padding-bottom: 8px;
        }
        .title {
            font-size: 40px;
            font-weight: 600;
            color: #ffffff;
            margin: 40px 0 20px 0;
            letter-spacing: 1px;
        }
        .otp-code {
            font-size: 40px;
            font-weight: 600;
            color: #ffffff;
            letter-spacing: 12px;
            margin: 0 0 8px 0;
            border-bottom: 2px solid #ffffff;
            display: inline-block;
            padding-bottom: 6px;
        }
        .footer {
            font-size: 13px;
            color: #c9d4c7;
            margin-top: 40px;
            line-height: 1.6;
        }
    </style>
</head>
    <div class="container">
        <div class="logo">Sapa-Trantib</div>
        <div class="title">KODE OTP ANDA</div>
        <div class="otp-code">{{ $otpCode }}</div>
        <div class="footer">
            Jika anda merasa tidak pernah membuat akun untuk Sapa-Trantib, mohon abaikan pesan ini.
        </div>
    </div>
</html>