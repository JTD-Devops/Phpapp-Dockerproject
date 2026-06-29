<?php
require_once 'config/database.php';
include 'includes/header.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $conn = getDBConnection();
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header('Location: /index.php');
            exit();
        } else {
            $error = 'Invalid password!';
        }
    } else {
        $error = 'User not found!';
    }
}
?>
<div class="auth-container">
    <div class="auth-box">
        <h2>Login to WatchStore</h2>
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Username or Email</label>
                <input type="text" name="username" required />
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required />
            </div>
            <button type="submit" class="btn-primary">Login</button>
        </form>
        <p class="auth-link">Don't have an account? <a href="/register.php">Register here</a></p>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
