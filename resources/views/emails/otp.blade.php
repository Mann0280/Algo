<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Verification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #030008; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #030008; padding: 40px 20px;">
        <tr>
            <td align="center">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width: 500px; background-color: #0c0518; border: 1px solid rgba(147, 51, 234, 0.2); border-radius: 24px; overflow: hidden; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);">
                    <!-- Brand Header -->
                    <tr>
                        <td align="center" style="padding: 40px 40px 20px 40px;">
                            <div style="display: inline-block; padding: 12px; background: linear-gradient(135deg, #9333ea, #6366f1); border-radius: 12px; margin-bottom: 24px;">
                                <img src="https://img.icons8.com/ios-filled/50/ffffff/lightning-bolt.png" width="24" height="24" alt="Logo" style="display: block;">
                            </div>
                            <h2 style="margin: 0; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: 900; letter-spacing: 0.1em; text-transform: uppercase;">
                                EMPEROR <span style="color: #9333ea;">STOCK</span>
                            </h2>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td align="center" style="padding: 0 40px 40px 40px;">
                            <h1 style="color: #ffffff; font-size: 24px; font-weight: 800; margin: 0 0 12px 0; letter-spacing: -0.02em;">Security Verification</h1>
                            <p style="color: #94a3b8; font-size: 15px; line-height: 1.6; margin: 0 0 32px 0;">
                                Hello <strong>{{ $name }}</strong>,<br>
                                Use the following code to verify your account session.
                            </p>

                            <!-- OTP Code -->
                            <div style="background: rgba(255, 255, 255, 0.03); border: 1px dashed rgba(147, 51, 234, 0.4); border-radius: 16px; padding: 24px 0; margin-bottom: 32px;">
                                <span style="font-family: 'Courier New', Courier, monospace; font-size: 42px; font-weight: 900; letter-spacing: 12px; color: #ffffff; text-shadow: 0 0 20px rgba(147, 51, 234, 0.3);">{{ $otp }}</span>
                            </div>

                            <!-- Meta Info -->
                            <p style="color: #64748b; font-size: 13px; margin: 0 0 8px 0;">
                                This secure protocol expires in <span style="color: #a855f7; font-weight: bold;">5 minutes</span>.
                            </p>
                            <p style="color: #475569; font-size: 12px; margin: 0;">
                                If you did not request this code, please secure your account.
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding: 0 40px 32px 40px; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                            <p style="color: #334155; font-size: 11px; font-weight: 600; margin: 24px 0 0 0; text-transform: uppercase; letter-spacing: 0.1em;">
                                &copy; {{ date('Y') }} EMPEROR STOCK PREDICTOR &bull; SYSTEM TERMINAL
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
