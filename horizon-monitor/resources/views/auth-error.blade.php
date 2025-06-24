<!DOCTYPE html>
<html>
<head>
    <title>Authentication Failed</title>
</head>
<body>
    <h1>Authentication Error</h1>
    
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <a href="{{ route('redirect') }}">Try again</a>
</body>
</html>
