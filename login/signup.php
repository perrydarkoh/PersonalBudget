<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - Personal Budget Manager</title>
<link rel="stylesheet" href="../css/signup.css"> 
</head>
<body>
    <div class="signup-container">
        <header>
            <div class="logo">PB</div>
            <nav>
                <a href="login.php">Login</a> 
            </nav>
        </header>
        <main class="signup-content">
            <h1>Let's go!</h1>
            <form id="signupForm" action="action/register_action.php" method="POST"> 
                <div class="form-group">
                    <label for="fullname">Full Name</label>
                    <input type="text" id="fullname" name="fullname" placeholder="Kojo Darkoh" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="example@site.com" required>
                </div>
                <div class="form-group">
                    <label for="password">Choose Password</label>
                    <input type="password" id="password" name="password" placeholder="Minimum 8 characters" required>
                </div>
                <button type="submit">Sign Up</button>
            </form>
            <div class="terms">
                By clicking the button above, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
            </div>
        </main>
    </div>
    <script src="../js/signup.js"></script> 
</body>
</html>
