<?php
// Enable Session (usually required to log in to the system)//
session_start();
include_once 'config.php';

// Check if the login button was clicked
if (isset($_POST['login'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // find user by email//
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // If email matches, check username//
        if (trim($user['name']) !== $name) {
            header("Location: Login.php?error=name_wrong");
            exit();
        }
        // Check password//
        if ($password === $user['password']) {
            
            // Check if account is suspended//
            if ($user['status'] === 'Suspended') {
                // Account suspended//
                header("Location: Login.php?error=suspended"); 
                exit();
            }

            // Successful login//
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];

            header("Location: homepage.php"); 
            exit(); 
        } else {
           // Incorrect password//
            header("Location: Login.php?error=pass_wrong");
            exit();
        }
    } else {
        // No such user//
        header("Location: Login.php?error=no_user");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="form.css" />

</head>
<body>
    <?php include_once 'header.php'; ?>

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
            <h1>Customer Login</h1>
            <p>Login to access your account</p>

            <?php if (isset($_GET['error']) && $_GET['error'] == 'invalid'): ?>
                <span class="error-message">Invalid email or password. Please try again.</span>
            <?php endif; ?>
          </div>

          <form class="login-form" action="" method="POST">

            <div class="form-group">
              <label for="name" class="form-label">Username:</label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Enter your username" required/>
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
              <a class="forgot-password" href="ForgotPassword.php" class="forgot-password">Forgot password?</a>
            </div>

            <button type="submit" class="login-submit" name="login">Log In</button>
            <div class="register-link">
              Don't have an account? <a href="Sign-up.php">Register now</a>
            </div>

          </form>
        </div>
      </div>
    </section>
    <script>
    // Display alert if there is an error parameter in the URL//
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        let message = '';
        let showAlert = true; //Control alert message display//

        switch (error) {
            case 'no_user':
                showAlert = false;
               //Ask user to register if username does not exist//
                if (confirm('The email address is not registered!\nWould you like to register an account?')) {
                    window.location.href = 'Sign-up.php';
                }
                break;
            case 'pass_wrong':
                message = 'Incorrect password!\nPlease try again.';
                break;
            case 'name_wrong':
                message = 'Incorrect username!\nPlease try again.';
                break;  
            case 'invalid':
                message = 'Login failed!\nPlease enter the correct username or password.';
                break;
            case 'suspended':
                message = 'Your account has been suspended.\nPlease contact customer support for assistance.';
                break;
            // Add more cases as needed//
            default:
                message = 'Login failed. Please try again.';
        }
        if (showAlert && message !== '') {
        alert(message);
       }
        // Clear the error parameter from the URL to prevent repeated alerts on refresh//
        window.history.replaceState({}, document.title, window.location.pathname);
    }
</script>

    <?php include_once 'footer.php'; ?>
</body>
</html>