<!DOCTYPE html>
<html>
<head>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #007bff;
            color: #fff;
            padding: 5px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }
        .content {
            padding: 20px;
        }
        .footer {
            background-color: #f5f5f5;
            padding: 10px 20px;
            text-align: center;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Login Alert</h1>
        </div>
        <div class="content">
            <p>Hello {{ $name }},</p>
            <p>We detected a login to your account from the following device:</p>
            <ul>
                <li>Device Model: {{ $model }}</li>
                <li>OS Info: {{ $osinfo }}</li>
                <li>Location: {{ $location }}</li>
                <li>Date: {{ $date }}</li>
            </ul>
            <p>If you did not perform this login, please take necessary actions to secure your account.</p>
            <p>Best regards,<br>{{ $name }}</p>
        </div>
        <div class="footer">
        Auto-generated Email Notification. Please do not reply to this email address.
        </div>
    </div>
</body>
</html>
