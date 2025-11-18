<?php
session_start();
require_once 'config.php';

$step = 1; 
$error = "";

// Handle authentication logic//
if (isset($_POST['verify'])) {
    $admin_id = $_POST['admin_id'];
    $email = $_POST['email'];
    
    // Check if the provided Admin ID and Email match an existing record//
    $stmt = $conn->prepare("SELECT admin_id FROM admins WHERE admin_id = ? AND email = ?");
    $stmt->bind_param("is", $admin_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $_SESSION['temp_admin_id'] = $admin_id;
        $step = 2; 
    } else {
        $error = "id_email_mismatch"; 
    }
}

// Handle Password Update logic//
if (isset($_POST['update_password'])) {
    $new_pass = $_POST['new_password'];
    $confirm_pass = $_POST['confirm_password'];
    $admin_id = $_SESSION['temp_admin_id'];

    if ($new_pass === $confirm_pass) {
        $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE admin_id = ?");
        $stmt->bind_param("si", $new_pass, $admin_id);
        
        if ($stmt->execute()) {
            unset($_SESSION['temp_admin_id']);
            echo "<script>alert('Password updated successfully!'); window.location='Admin Login.php';</script>";
            exit();
        }
    } else {
        $step = 2; 
        $error = "password_mismatch"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Book Time</title>
    
    <style>
        /* Base page layout and background */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(rgba(255, 140, 0, 0.2), rgba(255, 140, 0, 0.2)), 
                        url("img/background.png") center/cover no-repeat fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* white form container styling */
        .reset-container {
            background: white;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 400px;
            height: auto;
        }

        /*header section with logo and titles*/
        .form-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .logo {
            width: 180px;
            height: auto;
        }

        .form-header h1 {
            font-size: 32px;
            margin: 0;
            color: #333;
        }

        .form-header p {
            font-size: 16px;
            color: #666;
            margin-top: 5px;
        }

        /*Group spacing for form fields*/
        .form-group {
        margin-bottom: 25px;
        }

        .form-label {
        display: block;
        margin-bottom: 10px;
        font-weight: 600;
        color: #444;
        font-size: 16px;
    }

    /* Input field */
    .form-control {
        width: 100%;
        padding: 15px; /* Increased clickable area*/
        font-size: 16px;
        border: 1.5px solid #ddd;
        border-radius: 8px;
        box-sizing: border-box; /* Ensure padding doesn't break layout width */
        transition: border-color 0.3s ease;
    }

    /*Input field focus effect*/
    .form-control:focus {
        outline: none;
        border-color: #ff8c00;
        box-shadow: 0 0 8px rgba(255, 140, 0, 0.2);
    }

        /* Error message */
        .error-message {
            color: red;
            font-size: 15px;
            display: block;
            margin-top: 10px;
            text-align: center;
        }

        /* full width button styling */
        .full-width-btn {
            width: 100%;
            padding: 16px;
            background-color: #ff8c00;
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 18px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 1dvh0px;
        }

        .back-link {
            margin-top: 20px;
            text-align: center;
            display: block;
            text-decoration: none;
            color: #ff8c00;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .register-link {
            margin-top: 30px;
            text-align: center;
            font-size: 15px;
            color: #666;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .register-link a {
            color: #ff8c00;
            text-decoration: none;
            font-weight: 600;
        }

        .register-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <section class="form">
        <div class="reset-container">
            
            <div class="form-header">
                <img src="img/logoyellow.png" alt="Book Time Logo" class="logo"/>
                <h1>Reset Password</h1>
                <p>Follow the steps to recover your account</p>
                
                <?php if ($error == "id_email_mismatch"): ?>
                    <span class="error-message">Incorrect Admin ID or Email Address!</span>
                <?php elseif ($error == "password_mismatch"): ?>
                    <span class="error-message">Passwords do not match!</span>
                <?php endif; ?>
            </div>

            <?php if ($step == 1): ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="admin_id" class="form-label">Admin ID:</label>
                        <input type="number" id="admin_id" name="admin_id" class="form-control" placeholder="Enter your ID" required/>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email Address:</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email" required/>
                    </div>
                    <button type="submit" name="verify" class="login-submit full-width-btn">Verify Identity</button>
                    <div class="register-link">
                        Remembered your password? <a href="Login.php">Back to Login</a>
                    </div>
                </form>

            <?php else: ?>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" required/>
                    </div>
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm your password" required/>
                    </div>
                    <button type="submit" name="update_password" class="login-submit full-width-btn">Update Password Now</button>
                </form>
            <?php endif; ?>

        </div>
    </section>

    <script>
        // trigger browser alerts if error flag is set//
        const errorType = "<?php echo $error; ?>";
        if (errorType === "id_email_mismatch") {
            alert("Verification failed!\nThe Admin ID or Email Address you entered is incorrect.");
        } else if (errorType === "password_mismatch") {
            alert("Update failed!\nThe passwords do not match. Please re-enter.");
        }
    </script>

</body>
</html>