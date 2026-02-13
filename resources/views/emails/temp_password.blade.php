<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Temporary Password</title>
</head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f6f7fb;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center" style="padding:20px;">
                <table width="520" cellpadding="20" cellspacing="0"
                       style="background:#ffffff;border-radius:8px;">

                    <tr>
                        <td align="center">
                            <h2 style="color:#1e3a8a;margin-bottom:10px;">
                                Jharkhand State Housing Board
                            </h2>
                            <p style="color:#666;margin-top:0;">
                                Temporary Login Password
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Hello,</p>

                            <p>Your temporary password for login is:</p>

                            <p style="
                                font-size:24px;
                                font-weight:bold;
                                color:#f97316;
                                text-align:center;
                                letter-spacing:2px;">
                                {{ $randPass }}
                            </p>

                            <p>
                                Please use this password to log in and
                                <strong>change your password immediately</strong>
                                after login for security reasons.
                            </p>

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>EDMS Team</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center"
                            style="font-size:12px;color:#666;border-top:1px solid #eee;">
                            This is a system-generated email. Please do not reply.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
