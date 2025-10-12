<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank you for contacting GiftGenie</title>
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
            background: linear-gradient(135deg, #00D1A1 0%, #FF2DCE 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .content {
            background: #f9f9f9;
            padding: 30px;
            border-radius: 0 0 8px 8px;
            border: 1px solid #e0e0e0;
            border-top: none;
        }
        .greeting {
            font-size: 18px;
            color: #555;
            margin-bottom: 20px;
        }
        .message-summary {
            background: white;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin: 20px 0;
        }
        .summary-field {
            margin-bottom: 10px;
        }
        .summary-label {
            font-weight: bold;
            color: #666;
        }
        .next-steps {
            background: #e8f4f8;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #00D1A1;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .contact-info {
            background: #fff;
            padding: 15px;
            border-radius: 5px;
            border: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">🎁 GiftGenie</div>
        <h1>Thank You for Reaching Out!</h1>
        <p>We've received your message and appreciate you taking the time to contact us.</p>
    </div>
    
    <div class="content">
        <div class="greeting">
            Hello <strong>{{ $contactData['name'] }}</strong>,
        </div>

        <p>Thank you for contacting GiftGenie! We have successfully received your message and our team will review it shortly.</p>

        <div class="message-summary">
            <h3>📝 Your Message Summary</h3>
            <div class="summary-field">
                <span class="summary-label">Subject:</span> {{ $contactData['subject'] }}
            </div>
            <div class="summary-field">
                <span class="summary-label">Submitted on:</span> {{ \Carbon\Carbon::now()->format('F j, Y \a\t g:i A') }}
            </div>
            <div class="summary-field">
                <span class="summary-label">Reference ID:</span> #{{ strtoupper(substr(md5($contactData['email'] . $contactData['timestamp']), 0, 8)) }}
            </div>
        </div>

        <div class="next-steps">
            <h3>⏰ What Happens Next?</h3>
            <ul>
                <li><strong>Response Time:</strong> We typically respond within 24 hours during business days</li>
                <li><strong>Our Team:</strong> A member of our support team will review your inquiry</li>
                <li><strong>Follow-up:</strong> We'll send our response to this email address: {{ $contactData['email'] }}</li>
            </ul>
        </div>

        <p>In the meantime, feel free to explore our platform and discover amazing gift ideas tailored to your needs!</p>

        <div class="contact-info">
            <h3>📞 Need Immediate Assistance?</h3>
            <p>If your inquiry is urgent, you can also reach us through:</p>
            <ul>
                <li>Visit our Help Center for frequently asked questions</li>
                <li>Browse our gift guides for inspiration</li>
                <li>Check out our latest features on the dashboard</li>
            </ul>
        </div>
    </div>

    <div class="footer">
        <p><strong>GiftGenie Team</strong></p>
        <p>Making gift-giving effortless and memorable</p>
        <p style="font-size: 12px; color: #999;">
            This is an automated message. Please do not reply directly to this email.
            If you have additional questions, please submit another contact form.
        </p>
    </div>
</body>
</html>