<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Verification Code</title>
</head>
<body style="margin: 0; padding: 40px; background-color: #0c0518; color: #ffffff; font-family: Arial, Helvetica, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 560px; margin: 0 auto;">
        <tr>
            <td style="background-color: #1a0f2e; border: 1px solid #581c87; border-radius: 12px; padding: 40px; text-align: center;">
                
                <!-- Header -->
                <h2 style="color: #a855f7; margin: 0 0 24px 0; font-size: 22px; font-weight: bold;">
                    Verification Secure Protocol
                </h2>
                
                <!-- Greeting -->
                <p style="font-size: 16px; color: #e5e7eb; margin: 0 0 16px 0;">
                    Hello {{ $name }},
                </p>
                <p style="font-size: 16px; color: #d1d5db; margin: 0 0 28px 0;">
                    Your verification code is:
                </p>
                
                <!-- OTP Box -->
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center">
                            <div style="display: inline-block; background-color: #0c0518; border: 2px solid #9333ea; border-radius: 8px; padding: 18px 32px; margin-bottom: 28px;">
                                <span style="font-size: 36px; font-weight: bold; letter-spacing: 10px; color: #ffffff; font-family: 'Courier New', Courier, monospace;">{{ $otp }}</span>
                            </div>
                        </td>
                    </tr>
                </table>
                
                <!-- Expiry Notice -->
                <p style="font-size: 14px; color: #9ca3af; margin: 0 0 8px 0;">
                    This code will expire in <strong style="color: #c084fc;">5 minutes</strong>.
                </p>
                <p style="font-size: 13px; color: #6b7280; margin: 0 0 24px 0;">
                    If you did not request this verification, please ignore this message.
                </p>

                <!-- Divider -->
                <hr style="border: none; border-top: 1px solid #581c87; margin: 20px 0;">

                <!-- Footer -->
                <p style="font-size: 12px; color: #4b5563; margin: 0;">
                    &copy; {{ date('Y') }} Emperor Stock Predictor. All rights reserved.
                </p>

            </td>
        </tr>
    </table>
</body>
</html>
