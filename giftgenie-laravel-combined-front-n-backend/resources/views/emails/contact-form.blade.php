<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .field {
            margin-bottom: 20px;
        }
        .field label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 5px;
        }
        .field-content {
            background: white;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .message-content {
            min-height: 100px;
            white-space: pre-wrap;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .timestamp {
            background: #e8f4f8;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            color: #666;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🎁 New Contact Form Submission</h1>
        <p>GiftGenie Contact Form</p>
    </div>
    
    <div class="content">
        <div class="timestamp">
            <strong>Received:</strong> {{ \Carbon\Carbon::now()->format('F j, Y \a\t g:i A') }}
        </div>

        <div class="field">
            <label>👤 Name:</label>
            <div class="field-content">{{ $contactData['name'] }}</div>
        </div>

        <div class="field">
            <label>📧 Email:</label>
            <div class="field-content">
                <a href="mailto:{{ $contactData['email'] }}">{{ $contactData['email'] }}</a>
            </div>
        </div>

        <div class="field">
            <label>📝 Subject:</label>
            <div class="field-content">{{ $contactData['subject'] }}</div>
        </div>

        <div class="field">
            <label>💬 Message:</label>
            <div class="field-content message-content">{{ $contactData['message'] }}</div>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent from the GiftGenie contact form.</p>
        <p>You can reply directly to this email to respond to <strong>{{ $contactData['name'] }}</strong>.</p>
    </div>
</body>
</html>