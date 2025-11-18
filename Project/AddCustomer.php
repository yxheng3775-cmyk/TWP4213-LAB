<?php
require_once 'config.php'; 

/* Initialize error message variable */
$errorMsg = ''; 

//Handle Form Submission (Only runs when the request method is POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['customer_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $status = $_POST['status'];
    // Set a default password '123456' if the password field is left empty//
    $rawPassword = !empty($_POST['password']) ? $_POST['password'] : '123456';
    
    // Logic Validation: Prevent the use of the reserved name "Admin"//
    if ($customerName === 'Admin') {
        $errorMsg = 'This name is reserved and cannot be used.';
    } else {
        $checkEmail = $conn->prepare("SELECT id FROM customers WHERE email = ?");
        $checkEmail->bind_param("s", $email);
        $checkEmail->execute();
        $checkEmail->store_result();

        if ($checkEmail->num_rows > 0) {
            $errorMsg = "This email is already registered.";
            $checkEmail->close();
        } else {
            $checkEmail->close();
            //Securely hash the password (never store plain text passwords)//
            $hashedPassword = password_hash($rawPassword, PASSWORD_DEFAULT); 
            //Insert the new customer into the database//
            $stmt = $conn->prepare("INSERT INTO customers (name, email, phone, password, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $customerName, $email, $phone, $hashedPassword, $status);

            if ($stmt->execute()) {
                header("Location: Manage Customer.php?message=success");
                exit();
            } else {
                $errorMsg = "Error: " . $conn->error;
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Customer | Book Time</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin-sidebar.css" />
  <style>
    :root { 
        --main-color: #ffa100;
        --font-color: white;
        --bg-color: #f4f7f6;
        --text-dark: #333;
        --text-muted: #777;
        --error-bg: #fff5f5;
        --error-text: #e03131;
        --transition: all 0.3s ease;
    }

    body { 
        font-family: 'Poppins', 'Segoe UI', sans-serif; 
        background: var(--bg-color); 
        margin: 0; 
        display: flex; /* Arrange the sidebar and content area horizontally */
        min-height: 100vh;
        color: var(--text-dark);
        flex-direction: row;
    }
    
    /* Ensure the content area fills the remaining space and wraps automatically */
    .main-content { 
        flex: 1; 
        padding: 40px; 
   
    }
    
    h1 { 
        margin-bottom: 5px; 
        font-size: 28px; 
        font-weight: 700;
    }

    /* back button */
    .btn-back { 
        background: white; 
        color: var(--text-muted); 
        padding: 10px 18px; 
        text-decoration: none; 
        border-radius: 8px; 
        font-size: 14px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 25px; 
        border: 1px solid #ddd;
        transition: var(--transition);
    }
    .btn-back:hover { 
        background: var(--main-color);
        color: white;
        border-color: var(--main-color);
    }

    /* form card */
    .form-card { 
        background: white; 
        padding: 35px; 
        border-radius: 15px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        max-width: 550px; 
        border-top: 4px solid var(--main-color);
    }

    .input-group { 
        margin-bottom: 20px; 
    }
    .input-group label { 
        display: block; 
        margin-bottom: 8px; 
        font-weight: 600; 
        font-size: 14px; 
    }

    /* input box */
    .input-field { 
        width: 100%; 
        padding: 12px 15px; 
        border: 2px solid #eee; 
        border-radius: 10px; 
        box-sizing: border-box; /* Prevent input from exceeding card width */
        font-size: 14px;
        transition: var(--transition);
        background-color: #fafafa;
    }
    .input-field:focus { 
        outline: none; 
        border-color: var(--main-color); 
        background-color: #fff;
    }

    .hint { 
        font-size: 12px; 
        color: var(--text-muted); 
        margin-top: 6px; 
    }

    /* submit button */
    .btn-submit { 
        background: var(--main-color); 
        color: white; 
        border: none; 
        padding: 14px; 
        border-radius: 10px; 
        cursor: pointer; 
        font-weight: 600; 
        width: 100%; 
        font-size: 16px;
        margin-top: 15px; 
        transition: var(--transition);
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }
    .btn-submit:hover { 
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* error message box */
    .error-box { 
        color: var(--error-text); 
        background-color: var(--error-bg); 
        padding: 15px; 
        border-radius: 10px; 
        margin-bottom: 25px; 
        border-left: 5px solid var(--error-text);
        font-size: 14px;
    }
</style>
</head>
<body>
    <?php include 'admin-sidebar.php'; ?>

    <div class="main-content">
        <h1>Add New Customer</h1>

        <a href="Manage Customer.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>

        <?php if ($errorMsg): ?>
            <div class="error-box">
                <i class="fas fa-exclamation-circle"></i> <?php echo $errorMsg; ?>
            </div>
        <?php endif; ?>

        <div class="form-card">
            <form action="AddCustomer.php" method="POST">
                <div class="input-group">
                    <label>Full Name *</label>
                    <input type="text" name="customer_name" class="input-field" placeholder="Enter customer name" required 
                           value="<?php echo isset($_POST['customer_name']) ? htmlspecialchars($_POST['customer_name']) : ''; ?>">
                </div>
                
                <div class="input-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="input-field" placeholder="example@mail.com" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="input-group">
                    <label>Password (Default: 123456)</label>
                    <input type="password" name="password" class="input-field" placeholder="Leave blank for default">
                    <p class="hint">Leave blank to use the default password.</p>
                </div>
                
                <div class="input-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" class="input-field" placeholder="e.g. 012-3456789" required
                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
                </div>

                <div class="input-group">
                    <label>Account Status</label>
                    <select name="status" class="input-field">
                        <option value="Active" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="Suspended" <?php echo (isset($_POST['status']) && $_POST['status'] == 'Suspended') ? 'selected' : ''; ?>>Suspended</option>
                    </select>
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-user-plus"></i> Register Customer
                </button>
            </form>
        </div>
    </div>
</body>
</html>