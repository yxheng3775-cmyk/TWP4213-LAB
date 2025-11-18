<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="template.css" />
    <link rel="stylesheet" href="form.css" />
    <title>Template Page - Lakeshow Grocer</title>
  </head>

<?php
if(isset($_POST['login'])){ 
  $users = [ 'suhaimi2.sarip@mmu.edu.my' => 'suhaimi@123', 'myyew@mmu.edu.my' => 'julie@456'];
  //获取email和password
$email=$_POST['email'];
$password=$_POST['password'];

//验证email 和 password
if (!array_key_exists($email, $users) || $users[$email] != $password) { 
//错误：跳回login页面并显示 error flag
header('Location: Lab 08 Q3 login.php?error=invalid'); 
exit; 
} else { 
  //成功：跳转到主页
header('Location: index.php'); 
exit; 
} 
}

?>

<body>
    <?php include_once 'includes/header.php'; ?>

    <section class="login">
      <div class="login-container">
        <div class="login-content">
          <div class="login-welcome">
            <h2>Welcome Back to Lakeshow Grocer</h2>
            <p>
              Access your account to enjoy a seamless shopping experience with
              fresh, organic groceries delivered to your doorstep.
            </p>

            <ul>
              <li>Fast & reliable delivery</li>
              <li>100% organic products</li>
              <li>Save your favorites for quick access</li>
            </ul>
          </div>
        </div>

        <div class="login-form-container">
          <div class="form-header">
            <img
              src="img/lakeshow-logo.png"
              alt="Lakeshow Grocer"
              class="logo"
            />
            <h1>Customer Login</h1>
            <p>Sign in to access your account</p>
            <span class="error-message">
            </span>
          </div>
          <form class="login-form" action="" method="POST">
            <div class="form-group">
              <label for="email" class="form-label">Email Address</label>
              <div class="input-with-icon">
                <input
                  type="email"
                  id="email"
                  name="email"
                  class="form-control"
                  placeholder="Enter your email"
                  required
                />
              </div>
            </div>

            <div class="form-group">
              <label for="password" class="form-label">Password</label>
              <div class="input-with-icon">
                <input
                  type="password"
                  id="password"
                  name="password"
                  class="form-control"
                  placeholder="Enter your password"
                  
                />
              </div>
            </div>

            <div class="forgot">
              <a
                class="forgot-password"
                href="C_Forgot.php"
                class="forgot-password"
                >Forgot password?</a
              >
            </div>

            <button type="submit" class="login-submit" name="login">Log In</button>

            <div class="divider">
              <span>or</span>
            </div>

            <div class="register-link">
              Don't have an account? <a href="C_Register.php">Register now</a>
            </div>
          </form>
        </div>
      </div>
    </section>
<?php include_once 'includes/footer.php'; ?>
  </body>
</html>
