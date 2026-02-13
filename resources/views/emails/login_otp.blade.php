<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login OTP</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f7fb; padding:20px;">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">
                <table width="520" cellpadding="20" cellspacing="0" style="background:#ffffff;border-radius:8px;">
                    
                    <tr>
                        <td align="center">
                            <h2 style="color:#1e3a8a;margin-bottom:10px;">
                                EDMS Login Verification
                            </h2>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p>Hello Sir/Madam,</p>

                            <p>
                                Your One-Time Password (OTP) for login is:
                            </p>

                            <p style="
                                font-size:26px;
                                font-weight:bold;
                                color:#f97316;
                                text-align:center;
                                letter-spacing:3px;">
                                {{ $otp }}
                            </p>

                            <p>
                                This OTP is valid for <strong>5 minutes</strong>.
                                Please do not share it with anyone.
                            </p>

                            <p style="margin-top:30px;">
                                Regards,<br>
                                <strong>EDMS Team</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="font-size:12px;color:#666;border-top:1px solid #eee;">
                            This is a system-generated email. Please do not reply.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
