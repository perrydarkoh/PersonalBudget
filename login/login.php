<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Personal Budget Manager</title>
    <link rel="stylesheet" href="../css/login.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
    <div class="login-container">
        <header>
            <div class="logo">PB</div>
            <nav>
                <a href="signup.php" class="signup">Sign up</a>
            </nav>
        </header>
        <main class="login-content">
            <h1>Welcome back!</h1>
            <form id="loginForm" action="../actions/login_action.php" method="POST">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <a href="#" class="forgot-password">Forgot Password?</a>
                <button type="submit">Log In</button>
            </form>
            <div class="signup-prompt">
                <span>Don't have an account? <a href="signup.php">Sign up</a></span>
            </div>
        </main>
        <footer>
            <p>Help</p>
        </footer>
    </div>
</body>
</html>
