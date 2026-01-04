<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PALAPES LAUT UMS Selection Process Update</title>
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
                                PALAPES LAUT UMS
                            </h1>
                            <p style="margin: 8px 0 0 0; font-size: 12px; color: rgba(255, 255, 255, 0.9); letter-spacing: 2px; text-transform: uppercase; font-weight: 500;">
                                Pasukan Latihan Pegawai Simpanan
                            </p>
                        </td>
                    </tr>

                    <!-- Content Section -->
                    <tr>
                        <td style="padding: 30px 40px;">
                            <h2 style="margin: 0 0 20px 0; font-family: 'Playfair Display', Georgia, serif; font-size: 28px; font-weight: 700; color: #2e313c; text-align: center;">
                                Selection Process Update
                            </h2>

                            <p style="margin: 0 0 20px 0; font-size: 16px; color: #64748b; text-align: center;">
                                Hello <strong style="color: #2e313c;">{{ $name }}</strong>,
                            </p>

                            <p style="margin: 0 0 25px 0; font-size: 15px; color: #64748b; line-height: 1.7;">
                                The selection process for <strong style="color: #2e313c;">PALAPES LAUT UMS Intake {{ $intakeYear }}</strong> has been completed.
                            </p>

                            <p style="margin: 0 0 25px 0; font-size: 15px; color: #64748b; line-height: 1.7;">
                                You can view your final application status by visiting the link below:
                            </p>

                            <!-- Status Check Box -->
                            <table role="presentation" style="width: 100%; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border-radius: 12px; margin: 25px 0; border: 2px solid #3c92d9;">
                                <tr>
                                    <td style="padding: 25px; text-align: center;">
                                        <p style="margin: 0 0 15px 0; font-size: 15px; font-weight: 600; color: #2e313c;">
                                            📋 Check Your Application Status
                                        </p>
                                        <a href="{{ $statusUrl }}" style="display: inline-block; padding: 14px 32px; background: linear-gradient(135deg, #3c92d9, #2980b9); color: #ffffff; text-decoration: none; font-size: 15px; font-weight: 600; border-radius: 8px; box-shadow: 0 4px 15px rgba(60, 146, 217, 0.4); margin-top: 10px;">
                                            View Status
                                        </a>
                                    </td>
                                </tr>
                            </table>

                            <!-- Info Notice -->
                            <table role="presentation" style="width: 100%; background-color: #f0fdf4; border-left: 4px solid #3c92d9; border-radius: 8px; margin: 25px 0;">
                                <tr>
                                    <td style="padding: 20px;">
                                        <p style="margin: 0 0 10px 0; font-size: 14px; color: #166534; line-height: 1.6;">
                                            <strong>ℹ️ Important Information:</strong>
                                        </p>
                                        <p style="margin: 0; font-size: 14px; color: #166534; line-height: 1.6;">
                                            Successful candidates will receive a separate welcome email with their account credentials. If you do not receive a welcome email, please check your application status using the link above.
                                        </p>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 25px 0 0 0; font-size: 15px; color: #64748b; line-height: 1.7;">
                                Thank you for your interest in joining PALAPES LAUT UMS. We wish you all the best in your future endeavors.
                            </p>

                            <p style="margin: 20px 0 0 0; font-size: 14px; color: #64748b; line-height: 1.6;">
                                Sincerely,<br>
                                <strong style="color: #2e313c;">PALAPES LAUT UMS Selection Committee</strong>
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
                                © {{ date('Y') }} PALAPES LAUT UMS. All rights reserved.
                            </p>
                            <p style="margin: 15px 0 0 0; font-size: 12px; color: #94a3b8; text-align: center;">
                                Universiti Malaysia Sabah
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
