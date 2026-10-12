<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Redirecting to payment...</title>
</head>
<body>
    <p>Redirecting to payment page...</p>

    <form id="authorizeNetRedirect" method="post" action="{{ $actionUrl }}">
        <input type="hidden" name="token" value="{{ $token }}">
        <noscript>
            <button type="submit">Continue</button>
        </noscript>
    </form>

    <script>
        document.getElementById('authorizeNetRedirect').submit();
    </script>
</body>
</html>

