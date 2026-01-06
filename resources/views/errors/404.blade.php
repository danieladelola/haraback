{{-- resources/views/errors/500.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oops! Something Went Wrong</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <style>
        body {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            text-align: center;
        }
        h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: #f87171;
        }
        p {
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            color: #e2e8f0;
        }
        .redirect {
            font-size: 0.9rem;
            color: #94a3b8;
        }
        a {
            color: #38bdf8;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>

    <script>
        // Redirect after 3 seconds
        setTimeout(() => {
            window.location.href = "{{ url('/') }}";
        }, 3000);
    </script>
</head>
<body>
    <h1>500</h1>
    <p>Something’s broken on our side, but not your spirit.</p>
    <p class="redirect">You’ll be back home in 3 seconds... <br> Or <a href="{{ url('/') }}">go now</a>.</p>
</body>
</html>
