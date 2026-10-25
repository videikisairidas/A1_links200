<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; padding: 20px;">
    <table align="center" width="100%" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; padding: 30px; border-radius: 8px;">
        <tr>
            <td align="center" style="padding-bottom: 20px;">
                <h2 style="margin: 0; color: #333;">Reset Your Password</h2>
            </td>
        </tr>
        <tr>
            <td>
                <p style="color: #666;">Hello {{ $user->name ?? 'there' }},</p>
                <p style="color: #666;">
                    We received a request to reset your password. Click the button below to proceed:
                </p>
                <p style="text-align: center; padding: 20px 0;">
                    <a href="{{ $url }}"
                       style="background-color: #4a90e2; color: #fff; padding: 12px 24px; text-decoration: none; border-radius: 4px;">
                        Reset Password
                    </a>
                </p>
                <p style="color: #999; font-size: 12px;">
                    If you didn’t request this, you can safely ignore this email.
                </p>
                <p style="color: #999; font-size: 12px;">
                    This link will expire in 60 minutes.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
