<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>OTP Verification</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f6f8;
        margin: 0;
        padding: 0;
      }
      .container {
        max-width: 600px;
        margin: 40px auto;
        background-color: #ffffff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      }
      .header {
        font-size: 24px;
        font-weight: bold;
        color: #333333;
        margin-bottom: 10px;
      }
      .message {
        font-size: 16px;
        color: #555555;
        margin-bottom: 30px;
      }
      .otp-code {
        font-size: 32px;
        font-weight: bold;
        color: #2f855a;
        text-align: center;
        padding: 15px;
        background-color: #f0fff4;
        border: 1px dashed #38a169;
        border-radius: 8px;
        letter-spacing: 4px;
        margin: 20px 0;
      }
      .footer {
        font-size: 13px;
        color: #888888;
        text-align: center;
        margin-top: 40px;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="message">
        Hello, <br/>
        To complete your action, please use the following One-Time Password (OTP):
      </div>
      <div class="otp-code">{{ $code }}</div>
      <div class="message">
        This code will expire in 10 minutes. If you did not request this, please ignore this email.
      </div>
      <div class="footer">
        &copy; {{ date('Y') }} {{ env('APP_NAME') }}. All rights reserved.
      </div>
    </div>
  </body>
</html>
