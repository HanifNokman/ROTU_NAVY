<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password - ROTU NAVY UMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', Arial, sans-serif; background-color: #f8fafc; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(60, 146, 217, 0.15); overflow: hidden;">

                    <!-- Header with Gradient -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #3c92d9, #2980b9); padding: 40px 30px; text-align: center;">
                            <h1 style="margin: 0; font-family: 'Playfair Display', Georgia, serif; font-size: 32px; font-weight: 700; color: #ffffff; text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                ROTU NAVY UMS
                            </h1>
                            <p style="margin: 8px 0 0 0; font-size: 12px; color: rgba(255, 255, 255, 0.9); letter-spacing: 2px; text-transform: uppercase; font-weight: 500;">
                                Reserve Officer Training Unit
                            </p>
                        </td>
                    </tr>

                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 30px 40px;">
                            <h2 style="margin: 0 0 20px 0; font-family: 'Playfair Display', Georgia, serif; font-size: 28px; font-weight: 700; color: #2e313c; text-align: center;">
                                Reset Your Password
                            </h2>

                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #64748b; text-align: center;">
                                Hello <strong style="color: #2e313c;">{{ $name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px 0; font-size: 15px; color: #64748b; line-height: 1.7;">
                                We received a request to reset your password for your ROTU NAVY UMS account. Click the button below to create a new password:
                            </p>

                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ $resetUrl }}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #3c92d9, #2980b9); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 15px rgba(60, 146, 217, 0.4); transition: all 0.3s ease;">
                                            Reset Password
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Security Info Box -->
                            <table role="presentation" style="width: 100%; background-color: #fff7ed; border-left: 4px solid #ec6c6c; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px 0; font-size: 14px; font-weight: 600; color: #c2410c;">
                                            ⚠️ Security Notice
                                        </p>
                                        <p style="margin: 0; font-size: 13px; color: #9a3412; line-height: 1.6;">
                                            This password reset link will expire in <strong>60 minutes</strong> for security purposes. If you didn't request a password reset, please ignore this email or contact your administrator if you have concerns.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- Alternative Link -->
                            <p style="margin: 25px 0 0 0; font-size: 13px; color: #94a3b8; line-height: 1.6;">
                                If the button doesn't work, copy and paste this link into your browser:
                            </p>
                            <p style="margin: 10px 0 0 0; padding: 12px; background-color: #f8fafc; border-radius: 6px; font-size: 12px; color: #3c92d9; word-break: break-all; font-family: monospace;">
                                {{ $resetUrl }}
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #64748b; text-align: center;">
                                This email was sent to <strong style="color: #2e313c;">{{ $email }}</strong>
                            </p>
                            <p style="margin: 0; font-size: 12px; color: #94a3b8; text-align: center;">
                                © {{ date('Y') }} ROTU NAVY UMS. All rights reserved.
                            </p>
                            <p style="margin: 15px 0 0 0; font-size: 12px; color: #94a3b8; text-align: center;">
                                Reserve Officer Training Unit Management System
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
