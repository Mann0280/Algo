<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Verification Code</title>
</head>
<body style="background-color: #0c0518; color: #ffffff; font-family: Arial, sans-serif; padding: 40px;">
    <div style="max-w-xl mx-auto bg-[#1a0f2e] border border-purple-900 rounded-lg p-6 text-center">
        <h2 style="color: #a855f7; margin-bottom: 20px;">Verification Secure Protocol</h2>
        <p style="font-size: 16px; margin-bottom: 20px;">Hello {{ $name }},</p>
        <p style="font-size: 16px; margin-bottom: 30px;">Your verification code is:</p>
        
        <div style="background-color: #0c0518; border: 1px solid #9333ea; border-radius: 8px; padding: 20px; text-align: center; margin: 0 auto; width: fit-content; margin-bottom: 30px;">
            <span style="font-size: 32px; font-weight: bold; letter-spacing: 8px; color: #ffffff;">{{ $otp }}</span>
        </div>
        
        <p style="font-size: 14px; color: #9ca3af; margin-bottom: 10px;">This code will expire in 5 minutes.</p>
        <p style="font-size: 14px; color: #6b7280;">If you did not request this verification, please ignore this message.</p>
    </div>
</body>
</html>
