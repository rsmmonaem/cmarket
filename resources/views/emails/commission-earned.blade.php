<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 30px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background: #f9fafb;
            padding: 30px;
            border-radius: 0 0 8px 8px;
        }
        .commission-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: center;
        }
        .amount {
            font-size: 36px;
            font-weight: bold;
            color: #10b981;
            margin: 10px 0;
        }
        .button {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🎉 Commission Earned!</h1>
        </div>
        <div class="content">
            <p>Dear {{ $commission->user->name }},</p>
            <p>Congratulations! You've earned a commission from your referral network.</p>

            <div class="commission-box">
                <h2>Commission Details</h2>
                <div class="amount">৳{{ number_format($commission->amount, 2) }}</div>
                <p><strong>Level:</strong> {{ $commission->level }}</p>
                <p><strong>Percentage:</strong> {{ $commission->percentage }}%</p>
                <p><strong>From Order:</strong> #{{ $commission->order->order_number }}</p>
                <p><strong>Buyer:</strong> {{ $commission->fromUser->name }}</p>
                <p><strong>Date:</strong> {{ $commission->created_at->format('F d, Y') }}</p>
            </div>

            <p>The commission has been credited to your Commission Wallet.</p>

            <center>
                <a href="{{ route('wallet.index') }}" class="button">View Wallet</a>
            </center>

            <p>Keep building your network to earn more commissions!</p>
            <p>Thank you for being part of CMarket!</p>
        </div>
    </div>
</body>
</html>
