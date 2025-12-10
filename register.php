<?php
require_once 'config.php';
require_once 'functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    
    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
        $error = 'All fields are required';
    } elseif ($password !== $password_confirm) {
        $error = 'Passwords do not match';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email address';
    } else {
        $result = registerUser($username, $email, $password);
        
        if ($result['success']) {
            $success = $result['message'];
            $username = '';
            $email = '';
            $password = '';
            $password_confirm = '';
        } else {
            $error = $result['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-background">
    <div class="auth-container">
        <div class="auth-card">
            <h1>📝 Task Manager</h1>
            <h2>Create Account</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php echo htmlspecialchars($success); ?>
                    <p style="margin-top: 10px;"><a href="login.php" class="link">Go to login</a></p>
                </div>
            <?php else: ?>
                <form action="register.php" method="POST" class="auth-form">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Choose a username" 
                               value="<?php echo htmlspecialchars($username ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" 
                               value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="At least 6 characters" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirm">Confirm Password</label>
                        <input type="password" id="password_confirm" name="password_confirm" placeholder="Confirm password" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">Register</button>
                </form>
                
                <p class="auth-link">Already have an account? <a href="login.php">Login here</a></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>