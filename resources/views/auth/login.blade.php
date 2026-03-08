<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CMarket</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 450px;
            width: 100%;
            padding: 40px;
        }
        .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo h1 {
            color: #667eea;
            font-size: 2rem;
            margin-bottom: 5px;
        }
        .logo p {
            color: #666;
            font-size: 0.9rem;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s;
        }
        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .checkbox-group input[type="checkbox"] {
            width: auto;
        }
        .error {
            color: #e74c3c;
            font-size: 0.85rem;
            margin-top: 5px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border: 1px solid #c3e6cb;
        }
        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
        }
        .auth-footer a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="logo">
            <h1>🚀 CMarket</h1>
            <p>{{ $title ?? 'Welcome Back!' }}</p>
        </div>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form action="{{ $postRoute ?? route('login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="login">Email or Phone Number</label>
                <input type="text" id="login" name="login" value="{{ old('login') }}" placeholder="01XXXXXXXXX or email@example.com" required autofocus>
                @error('login')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group checkbox-group">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="margin-bottom: 0;">Remember me</label>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <!-- Auto Login Section -->
        <div style="margin-top: 25px; border-top: 1px solid #f0f0f0; padding-top: 20px;">
            <p style="text-align: center; font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 15px;">Fast Track Access</p>
            <div style="display: grid; grid-template-columns: 1fr; gap: 10px;">
                @if(isset($role) && $role === 'admin')
                <button type="button" onclick="autoLogin('admin@cmarket.com', 'password')" style="padding: 10px; background: #0f172a; color: white; border: none; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#1e293b'" onmouseout="this.style.background='#0f172a'">
                    🛡️ Login as Admin
                </button>
                @elseif(isset($role) && $role === 'merchant')
                <button type="button" onclick="autoLogin('merchant@cmarket.com', 'password')" style="padding: 10px; background: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    🏪 Login as Demo Merchant
                </button>
                @else
                <button type="button" onclick="autoLogin('vrkm55@gmail.com', 'password')" style="padding: 10px; background: #f8fafc; color: #1e293b; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.75rem; font-weight: 700; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#f1f5f9'" onmouseout="this.style.background='#f8fafc'">
                    👤 Login as Customer
                </button>
                @endif
            </div>
        </div>

        <script>
            function autoLogin(login, password) {
                document.getElementById('login').value = login;
                document.getElementById('password').value = password;
                
                // Visual feedback
                const btn = event.currentTarget;
                const originalText = btn.innerHTML;
                btn.innerHTML = 'Applied ✨';
                btn.style.borderColor = '#3b82f6';
                
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.style.borderColor = btn.style.background === '#0f172a' ? 'transparent' : '#e2e8f0';
                }, 1000);
            }
        </script>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Register here</a>
        </div>
    </div>
</body>
</html>
