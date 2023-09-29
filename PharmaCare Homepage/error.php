<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Error</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="error-container">
        <h1>Error</h1>
        <p><?php echo isset($_SESSION['login_error_message']) ? $_SESSION['login_error_message'] : 'Incorrect details'; ?></p>
        <a href="login.html">Back to Login</a>
    </div>
</body>
</html>