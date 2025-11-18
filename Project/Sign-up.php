<?php
require_once 'config.php';

$registrationMessage = "";
$emailAlreadyExists = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Get & trim inputs//
    $name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $phone_number = trim($_POST['phone']);
    $country_code = $_POST['country-code'];
    /* ---------------- VALIDATION ---------------- */

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registrationMessage = "Invalid email format.";

    } elseif (strlen($password) < 12 || !preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/[0-9]/', $password)|| !preg_match('/[\W_]/', $password)) {
        $registrationMessage = "Password must be at least 12 characters, contain an uppercase letter, lowercase letter, number and include a symbol.";

    } elseif ($password !== $confirm_password) {
        $registrationMessage = "Passwords do not match.";

    } elseif (!preg_match('/^1\d{8,9}$/', $phone_number)) {
        // Malaysian phone number should start with 1 and be 9-10 digits long//
        $registrationMessage = "Invalid Malaysian phone number. (Should start with 1)";

    } else {

        /* -------- CHECK IF EMAIL EXISTS -------- */

        $emailCheckStmt = $conn->prepare(
            "SELECT id FROM customers WHERE email = ?"
        );
        $emailCheckStmt->bind_param("s", $email);
        $emailCheckStmt->execute();
        $emailCheckStmt->store_result();

        if ($emailCheckStmt->num_rows > 0) {
            $emailAlreadyExists = true;
            $registrationMessage = "Email already registered.";
            $emailCheckStmt->close();
        } else {
            $emailCheckStmt->close();

            /* -------- INSERT NEW CUSTOMER -------- */

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $full_phone = $country_code . $phone_number;

           $query = "INSERT INTO customers 
                      (name, email, password, phone) 
                      VALUES (?, ?, ?, ?)";

            $addCustomerStmt = $conn->prepare($query);
            $addCustomerStmt->bind_param(
                "ssss",
                $name,
                $email,
                $password,
                $full_phone
            );
            
            // Execute insertion and check success//
            if ($addCustomerStmt->execute()) {
                $newUserId = $conn->insert_id;

           // Open Session //
            if (session_status() === PHP_SESSION_NONE) {
               session_start();
            }

            // Store login status//
              $_SESSION['user_id'] = $newUserId;
              $_SESSION['user_name'] = $name;

              // Redirect to homepage//
               header("Location: homepage.php");
               exit();
            } else {
                header("Location: Sign-up.php?message=failed");
                exit();
            }

            $addCustomerStmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="header.css">
    <link rel="stylesheet" href="footer.css">
<style>
   /* --- Sign-up page layout --- */
.main-container {
    min-height: 80vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 60px 15px;
    background-color: #fafafa;
}

/* --- Form container --- */
.form-container {
    background: #ffffff;
    max-width: 550px;
    width: 100%;
    padding: 45px;
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
}

.form-header h2 {
    font-size: 28px;
    font-weight: 700;
    color: #333;
    margin-bottom: 30px;
    text-align: center;
}

/* --- Message hint display--- */
.error-message, .success-message {
    padding: 12px 15px;
    border-radius: 6px;
    margin-bottom: 25px;
    font-size: 14px;
    display: flex;
    align-items: center;
}

.error-message {
    background-color: #fff2f2;
    color: #d93025;
    border: 1px solid #ffcfcf;
}

.success-message {
    background-color: #f1f8e9;
    color: #388e3c;
    border: 1px solid #c8e6c9;
}

/* --- Form elements --- */
.register-form .form-group {
    margin-bottom: 20px;
}

.register-form .form-label {
    font-weight: bold;
    font-size: 14px;
    color: #444;
    margin-bottom: 8px;
    display: block;
}

/* input fields */
.register-form .form-control, 
.register-form .input-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px 15px;
    font-size: 15px;
    transition: all 0.2s ease;
}
/* focus effect */
.register-form .form-control:focus {
    border-color: var(--main-color);
    box-shadow: 0 0 0 3px rgba(255, 161, 0, 0.15);
    outline: none;
}

/* phone number group */
.phone-group {
    display: flex;
    gap: 8px;
}

.phone-group select {
    width: 140px;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 5px 10px;
    background-color: #fff;
}

.phone-group input {
    flex: 1;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px;
}

/* button register*/
.btn-register {
    width: 100%;
    background-color: var(--main-color);
    color: white;
    border: none;
    padding: 14px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;   /* smooth hover effect */
    margin-top: 10px;   /* space from other elements */
}

.btn-register:hover {
    background-color: #e08f00;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 161, 0, 0.3);
}

/* clear button */
.btn-clear {
    width: 100%;
    background-color: #777;
    color: white;
    border: none;
    padding: 14px;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;  /* smooth hover effect */
    margin-top: 10px; /* space from register button */
}

.btn-clear:hover {
    background-color: #555;
    transform: translateY(-1px);  /* lift effect */
    box-shadow: 0 4px 12px rgba(255, 161, 0, 0.3);   /* subtle shadow */
}

/* --- Social login area --- */
.social-signup {
    margin-top: 12px;  
}

.icon-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;  /* space between icon and text */
    padding: 10px;   /* button padding */
    border: 1px solid #eee;
    background: #fff;
    border-radius: 8px;
    font-size: 14px;
    color: #555;
    transition: 0.2s;   /* smooth hover effect */
}

.icon-btn:hover {
    background-color: #f8f8f8;
    border-color: #ddd;
}

.icon-btn img {
    width: 18px;
    height: 18px;
}

/* --- Login link --- */
.login-link {
    text-align: center;
    margin-top: 25px;  /* space from form */
    color: #777;
    font-size: 14px;
}

.login-link a {
    color: var(--main-color);
    text-decoration: none;
    font-weight: 600;
}

.login-link a:hover {
    text-decoration: underline;
}

/* checkbox adjustments */
p input[type="checkbox"] {
    margin-right: 8px; /* space between checkbox and label */
    accent-color: var(--main-color);
}

</style>
</head>
<body>

<?php include_once 'header.php'; ?>

<section class="main-container">
    <div class="form-container"> <div class="form-header">
            <h2>Create Your Account</h2>
             <!-- Message display -->
            <?php if (!empty($registrationMessage)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($registrationMessage); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
                <div class="success-message">
                    Account created successfully.
                    <a href="login.php">Login here</a>.
                </div>
            <?php elseif (isset($_GET['message']) && $_GET['message'] === 'failed'): ?>
                <div class="error-message">
                    Error creating account. Please try again.
                </div>
            <?php endif; ?>
        </div>

        <form method="post" action="" class="register-form">
            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" placeholder="Full Name" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
            </div>
            
            <div class="form-group">
                <label for="phone">Phone number: </label><br> 
                <div class="phone-group">
                   <select id="country-code" name="country-code" required>
                      <option value="+60">+60 (Malaysia)</option>
                      <option value="+65">+65 (Singapore)</option>
                   </select>
        
                   <input type="text" id="phone" name="phone" maxlength="15" placeholder="123456789" required>
                </div>
            </div>

            <div class="form-group">
                <label for="birthday">Your Birthday: </label><br>
                <input type="date" id="birthday" name="birthday" min="1900-01-01" class="input-box">
            </div>

            <div class="form-group">
                <label>Gender:</label><br>
                <label><input type="radio" name="gender" value="male"> Male</label><br>
                <label><input type="radio" name="gender" value="female"> Female</label>
            </div>

            <p>
                <input type="checkbox" id="terms" name="terms" required>
                <label for="terms">I agree to the Terms & Conditions.</label>
            </p>

            <p>
                <button type="submit" class="btn-register">Register Now</button>
                <input type="reset" value="Clear" class="btn-clear"/>
            </p>
        </form>
        <hr>

        <div class="login-link">
            <p>Already have an account? <a href="login.php">Login here</a></p>
        </div>

         <div class="social-signup">
            <button type="button" class="icon-btn">
                <img src="img/Google.png" alt="Google"/> Sign up with Google
            </button>
            </div>

        <div class="social-signup">
            <button type="button" class="icon-btn">
                <img src="img/facebook.png" alt="Facebook"/> Sign up with Facebook
            </button>
            </div>

         <div class="social-signup">
            <button type="button" class="icon-btn">
                <img src="img/emaillogo.png" alt="Email"/> Sign up with Email
            </button>
            </div>
    </div> 
</section>

<?php include_once 'footer.php'; ?>
<script>
    //get the error message box//
    const errorBox = document.querySelector('.error-message');
    
    // hide error message on input//
    document.querySelector('.register-form').addEventListener('input', function() {
        if (errorBox) {
            // hide error-message when user starts typing//
            errorBox.style.display = 'none';
        }
    });
</script>
</body>
</html>