<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Accepted - ROTU NAVY UMS</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
</head>
<body style="margin: 0; padding: 0; font-family: 'Inter', Arial, sans-serif; background-color: #f8fafc; line-height: 1.6;">
    <table role="presentation" style="width: 100%; border-collapse: collapse; background-color: #f8fafc;">
        <tr>
            <td align="center" style="padding: 40px 20px;">
                <table role="presentation" style="width: 100%; max-width: 600px; border-collapse: collapse; background-color: #ffffff; border-radius: 16px; box-shadow: 0 10px 30px rgba(34, 197, 94, 0.15); overflow: hidden;">

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
                            <!-- Success Icon -->
                            <table role="presentation" style="width: 100%; margin: 0 0 20px 0;">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; width: 80px; height: 80px; background: linear-gradient(135deg, #22c55e, #16a34a); border-radius: 50%; text-align: center; line-height: 80px; font-size: 40px; box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);">
                                            ✓
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <h2 style="margin: 0 0 20px 0; font-family: 'Playfair Display', Georgia, serif; font-size: 28px; font-weight: 700; color: #2e313c; text-align: center;">
                                Congratulations!
                            </h2>

                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #64748b; text-align: center;">
                                Hello <strong style="color: #2e313c;">{{ $user->name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px 0; font-size: 15px; color: #64748b; line-height: 1.7; text-align: center;">
                                We are pleased to inform you that your <strong style="color: #22c55e;">{{ $role }}</strong> account has been accepted and is now active.
                            </p>

                            <!-- Account Details Card -->
                            <table role="presentation" style="width: 100%; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 12px; margin: 25px 0; border: 2px solid #22c55e; overflow: hidden;">
                                <tr>
                                    <td style="padding: 0;">
                                        <!-- Title Bar -->
                                        <table role="presentation" style="width: 100%; background: linear-gradient(135deg, #22c55e, #16a34a);">
                                            <tr>
                                                <td style="padding: 15px 25px;">
                                                    <p style="margin: 0; font-size: 18px; font-weight: 700; color: #ffffff; text-align: center;">
                                                        Account Details
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Details -->
                                        <table role="presentation" style="width: 100%;">
                                            <tr>
                                                <td style="padding: 20px 25px;">
                                                    <table role="presentation" style="width: 100%;">
                                                        <tr>
                                                            <td style="padding: 10px 0; vertical-align: top; width: 40px;">
                                                                <span style="font-size: 20px;">👤</span>
                                                            </td>
                                                            <td style="padding: 10px 0;">
                                                                <p style="margin: 0; font-size: 13px; color: #64748b; font-weight: 500;">NAME</p>
                                                                <p style="margin: 5px 0 0 0; font-size: 15px; color: #2e313c; font-weight: 600;">{{ $user->name }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0; vertical-align: top; border-top: 1px solid rgba(34, 197, 94, 0.2);">
                                                                <span style="font-size: 20px;">📧</span>
                                                            </td>
                                                            <td style="padding: 10px 0; border-top: 1px solid rgba(34, 197, 94, 0.2);">
                                                                <p style="margin: 0; font-size: 13px; color: #64748b; font-weight: 500;">EMAIL</p>
                                                                <p style="margin: 5px 0 0 0; font-size: 15px; color: #2e313c; font-weight: 600;">{{ $user->email }}</p>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="padding: 10px 0; vertical-align: top; border-top: 1px solid rgba(34, 197, 94, 0.2);">
                                                                <span style="font-size: 20px;">🎯</span>
                                                            </td>
                                                            <td style="padding: 10px 0; border-top: 1px solid rgba(34, 197, 94, 0.2);">
                                                                <p style="margin: 0; font-size: 13px; color: #64748b; font-weight: 500;">ROLE</p>
                                                                <p style="margin: 5px 0 0 0; font-size: 15px; color: #2e313c; font-weight: 600;">{{ $role }}</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <!-- Welcome Note -->
                            <table role="presentation" style="width: 100%; background-color: #dbeafe; border-left: 4px solid #3b82f6; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0; font-size: 14px; color: #1e40af; line-height: 1.6;">
                                            <strong>🎉 Welcome to ROTU NAVY UMS!</strong> You can now log in to your account and access all the features available to {{ strtolower($role) }}s.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <!-- CTA Button -->
                            <table role="presentation" style="width: 100%; margin: 30px 0;">
                                <tr>
                                    <td align="center">
                                        <a href="{{ route('login') }}" style="display: inline-block; padding: 16px 40px; background: linear-gradient(135deg, #3c92d9, #2980b9); color: #ffffff; text-decoration: none; font-size: 16px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 15px rgba(60, 146, 217, 0.4);">
                                            Login to Your Account
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 25px 0 0 0; font-size: 14px; color: #64748b; text-align: center; line-height: 1.6;">
                                If you have any questions or need assistance, please don't hesitate to contact our support team.
                            </p>

                            <!-- Button URL Fallback -->
                            <table role="presentation" style="width: 100%; background-color: #f8fafc; border-radius: 8px; margin: 20px 0; padding: 15px;">
                                <tr>
                                    <td style="padding: 5px 10px;">
                                        <p style="margin: 0 0 5px 0; font-size: 12px; color: #94a3b8; text-align: center;">
                                            If you're having trouble clicking the button, copy and paste this URL into your web browser:
                                        </p>
                                        <p style="margin: 0; font-size: 12px; color: #3b82f6; text-align: center; word-break: break-all;">
                                            <a href="{{ route('login') }}" style="color: #3b82f6; text-decoration: none;">{{ route('login') }}</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding: 30px 40px; background-color: #f8fafc; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0 0 10px 0; font-size: 13px; color: #64748b; text-align: center;">
                                This email was sent to <strong style="color: #2e313c;">{{ $user->email }}</strong>
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
