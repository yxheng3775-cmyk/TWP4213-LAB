<?php
// Enable session management //
session_start();
require_once 'config.php';

// Check whether click the login button // 
if (isset($_POST['login'])) {
    $admin_id = $_POST['admin_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Based on ID fetch admin data //
    $stmt = $conn->prepare("SELECT * FROM admins WHERE admin_id = ? LIMIT 1");
    $stmt->bind_param("i", $admin_id);
    
    // Execute the query//
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        // ID not found //
        header("Location: Admin Login.php?error=id");
        exit();
    } else {
        $admin_data = $result->fetch_assoc();
        
        // Checck Email//
        if ($email !== $admin_data['email']) {
            header("Location: Admin Login.php?error=email");
            exit();
        }
        
        // Check Password//
        if ($password !== $admin_data['password']) {
            header("Location: Admin Login.php?error=password");
            exit();
        }
            // Login successfully//
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin_data['admin_id'];
            $_SESSION['admin_name'] = $admin_data['admin_name'];

            // Update final login time//
            $update_stmt = $conn->prepare("UPDATE admins SET last_login = NOW() WHERE admin_id = ?");
            $update_stmt->bind_param("i", $admin_id);
            $update_stmt->execute();

            header("Location: admin_dashboard.php"); 
            exit(); 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <link rel="stylesheet" href="form.css" />
<style>

        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Background image optimization: use linear-gradient overlay to ensure text clarity */
            background: linear-gradient(rgba(255, 140, 0, 0.2), rgba(255, 140, 0, 0.2)), 
                        url("img/background.png") center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ensure error message style exists, otherwise the page prompt won't be visible */
        .error-message {
            color: red;
            font-size: 14px;
            display: block;
            margin-top: 10px;
        }
 
</style>
</head>
<body>

    <section class="form">
      <div class="main-container">
        <div class="form-content">
          <div class="login-welcome">
            <h2>Welcome Back to Book Time</h2>
            <p>
              Access your account to explore a world of books and enjoy a smooth online shopping experience.
            </p>

            <ul>
              <li>Discover book across various genres</li>
              <li>Save your favorites books for quick access</li>
              <li>Enjoy easy and secure online purchases</li>
            </ul>
          </div>
        </div>

        <div class="form-container">
          <div class="form-header">
            <img src="img/logoyellow.png" alt="Book Time" class="logo"/>
            <h1>Admin Login</h1>
            <p>Login to access your account</p>

           <?php 
           $msg = "";
           if (isset($_GET['error'])) {
              if ($_GET['error'] == 'id') $msg = "Incorrect ID!";
              elseif ($_GET['error'] == 'email') $msg = "Incorrect Email!";
              elseif ($_GET['error'] == 'password') $msg = "Incorrect Password!";
           }
           ?>
          <?php if ($msg): ?>
                <span class="error-message"><?php echo $msg; ?></span>
          <?php endif; ?>

          <form class="login-form" action="" method="POST">

            <div class="form-group">
              <label for="admin_id" class="form-label">Admin ID:</label>
                <input type="text" id="admin_id" name="admin_id" class="form-control" placeholder="Enter your admin ID" required/>
            </div>

            <div class="form-group">
              <label for="email" class="form-label">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required/>
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required/>
            </div>

            <div class="forgot">
              <a class="forgot-password" href="Admin_ForgotPassword.php" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="login-submit" name="login">Log In</button>


          </form>
        </div>
      </div>
    </section>
   <script>
    const urlParams = new URLSearchParams(window.location.search);
    const errorType = urlParams.get('error');

    if (errorType) {
        let message = "";
        switch (errorType) {
            case 'id':
                message = "Login failed: Incorrect Admin ID!";
                break;
            case 'email':
                message = "Login failed: Incorrect Email!";
                break;
            case 'password':
                message = "Login failed: Incorrect Password!";
                break;
        }
        
        if (message) {
            alert(message);
            // clear parameters from URL to prevent repeated pop-ups when refresh//
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    }
</script>
</body>
</html>