<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Temporary Password</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #667eea;
            margin-top: 0;
        }
        .password-box {
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 25px 0;
            border-radius: 5px;
        }
        .password-box .label {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }
        .password-box .password {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
        }
        .info-box {
            background: #fff3cd;
            border: 1px solid #ffc107;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .info-box strong {
            color: #856404;
        }
        .steps {
            background: #e7f3ff;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .steps ol {
            margin: 10px 0;
            padding-left: 20px;
        }
        .steps li {
            margin: 8px 0;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
        }
        .security-notice {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🔐 Password Reset</h1>
            <p style="margin: 10px 0 0 0; font-size: 16px;">Career Fair DCS Admin Portal</p>
        </div>

        <div class="email-body">
            <h2>Hello, {{ $userName }}!</h2>
            
            <p>You recently requested to reset your password for your admin account (<strong>{{ $userEmail }}</strong>).</p>

            <div class="password-box">
                <div class="label">Your Temporary Password:</div>
                <div class="password">{{ $temporaryPassword }}</div>
            </div>

            <div class="info-box">
                <strong>⚠️ Important:</strong> This is a temporary password. For security reasons, please change it immediately after logging in.
            </div>

            <div class="steps">
                <strong>Next Steps:</strong>
                <ol>
                    <li>Go to the <a href="{{ url('/login') }}">Login Page</a></li>
                    <li>Enter your email: <strong>{{ $userEmail }}</strong></li>
                    <li>Use the temporary password shown above</li>
                    <li>Once logged in, go to <strong>"Change Password"</strong> from the sidebar</li>
                    <li>Enter the temporary password as your current password</li>
                    <li>Set a new secure password</li>
                </ol>
            </div>

            <div style="text-align: center;">
                <a href="{{ url('/login') }}" class="btn">Login Now</a>
            </div>

            <div class="security-notice">
                <strong>Security Notice:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>This temporary password is valid until you change it</li>
                    <li>Never share this password with anyone</li>
                    <li>If you didn't request this password reset, please contact the system administrator immediately</li>
                </ul>
            </div>

            <p style="margin-top: 30px; color: #666;">
                Best regards,<br>
                <strong>Career Fair DCS Team</strong><br>
                Department of Computer Science<br>
                University of Ruhuna
            </p>
        </div>

        <div class="email-footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p style="margin-top: 10px; font-size: 12px;">
                © {{ date('Y') }} Career Fair DCS. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
