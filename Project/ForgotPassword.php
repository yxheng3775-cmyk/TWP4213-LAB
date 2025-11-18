<?php
session_start();
include_once 'config.php';

$message = "";
$status = "";

if (isset($_POST['reset_password'])) {
    $email = trim($_POST['email']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check two passwords match//
    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
        $status = "error";
    } else {
        // Check email exists//
        $stmt = $conn->prepare("SELECT id FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            // Update password//
            $update_stmt = $conn->prepare("UPDATE customers SET password = ? WHERE email = ?");
            $update_stmt->bind_param("ss", $new_password, $email);
            
            if ($update_stmt->execute()) {
                $message = "Password updated successfully! You can now login.";
                $status = "success";
            } else {
                $message = "Something went wrong. Please try again.";
                $status = "error";
            }
        } else {
            $message = "Email address not found!";
            $status = "error";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Book Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="form.css"> 
    <style>
   <style>
    /* */
    body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f7f6;
        }

        /* Layout Container*/
        .form-section {
            padding: 80px 20px;
            min-height: 85vh;
            display: flex;
            justify-content: center; 
            align-items: center;
        }

        /* Main form */
        .form-container {
            background: #ffffff;
            width: 100%;
            max-width: 520px; 
            padding: 50px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            box-sizing: border-box; /* prevent padding from breaking width*/
        }

        /*Header Section*/
        .form-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .form-header h1 {
            font-size: 30px;
            margin: 0 0 10px 0;
            color: #333;
        }

        /*Input fields*/
        .form-group {
            margin-bottom: 25px;
            text-align: left; 
        }

        .form-label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #444;
            font-size: 15px;
        }

        .form-input {
            width: 100%;
            padding: 15px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .login-submit {
            width: 100%;
            padding: 16px;
            background-color: #ff8c00;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-submit:hover {
            background-color: #e67e00;
        }

        .register-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #f0f0f0;
        }

        .register-link a {
            color: #ff8c00;
            text-decoration: none;
            font-weight: 600;
        }

        /* Alert message */
        .alert {
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
            text-align: center;
        }
        .alert-error { background: #fee2e2; color: #991b1b; }
        .alert-success { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>
    <?php include_once 'header.php'; ?>

    <section class="form-section">
        <div class="form-container">
            <div class="form-header">
                <h1>Reset Password</h1>
                <p>Enter your email and new password to reset.</p>
            </div>

            <?php if ($message): ?>
                <div class="alert alert-<?php echo ($status == 'error') ? 'error' : 'success'; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-input" placeholder="Enter your registered email" required>
                </div>

                <div class="form-group">
                    <label class="form-label">New Password</label>
                    <input type="password" name="new_password" class="form-input" placeholder="Enter new password" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-input" placeholder="Confirm new password" required>
                </div>

                <button type="submit" name="reset_password" class="login-submit">Reset Password</button>
                
                <div class="register-link">
                    Remembered your password? <a href="Login.php">Back to Login</a>
                </div>
            </form>
        </div>
    </section>

    <?php include_once 'footer.php'; ?>
</body>
</html>