<?php
require_once 'config.php';
require_once 'functions.php';

$error = '';

if (isLoggedIn()) {
    header('Location: index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required';
    } else {
        $result = loginUser($username, $password);
        
        if ($result['success']) {
            header('Location: index.php');
            exit();
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
    <title>Login - Task Manager</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="auth-background">
    <div class="auth-container">
        <div class="auth-card">
            <h1>📝 Task Manager</h1>
            <h2>Login</h2>
            
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form action="login.php" method="POST" class="auth-form">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
            
            <p class="auth-link">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>