<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="0;url={{ $url }}">
    <title>Redirecting...</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            color: white;
        }
        .redirect-container {
            text-align: center;
        }
        .spinner {
            width: 50px;
            height: 50px;
            margin: 0 auto 20px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        h1 {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }
        p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="redirect-container">
        <div class="spinner"></div>
        <h1>Login Successful!</h1>
        <p>Redirecting to your dashboard...</p>
    </div>
    
    <script>
        // Force full page redirect - multiple methods to ensure it works
        (function() {
            // Remove any Inertia state
            if (window.history && window.history.replaceState) {
                window.history.replaceState(null, null, '{{ $url }}');
            }
            
            // Set timeout as backup
            setTimeout(function() {
                window.location.href = '{{ $url }}';
            }, 100);
            
            // Immediate redirect
            window.location.replace('{{ $url }}');
        })();
    </script>
</body>
</html>
