<?php

require_once 'config.php'; 

// Initialize variables for customer data and error messages//
$customer = null;
$errorMsg = '';

// Handle saving/updating request (prioritize POST)//
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_customer'])) {
    $id = $_POST['customer_id'];
    $name = $_POST['customer_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $status = $_POST['status'];
    $newPassword = $_POST['new_password'];

    // If a new password is provided, update it; otherwise keep the existing one//
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone=?, status=?, password=? WHERE id=?");
        $updateStmt->bind_param("sssssi", $name, $email, $phone, $status, $hashedPassword, $id);
    } else {
        $updateStmt = $conn->prepare("UPDATE customers SET name=?, email=?, phone=?, status=? WHERE id=?");
        $updateStmt->bind_param("ssssi", $name, $email, $phone, $status, $id);
    }

    if ($updateStmt->execute()) {
        // Update successful, redirect to list page//
        header("Location: Manage Customer.php?message=updated");
        exit();
    } else {
        $errorMsg = "Update failed: " . $conn->error;
    }
    $updateStmt->close();
}

// Get current customer information (for displaying in the form)//
if (isset($_GET['id'])) {
    $customerId = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM customers WHERE id = ?");
    $stmt->bind_param("i", $customerId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $customer = $result->fetch_assoc();
    } else {
        header("Location: Manage Customer.php");
        exit();
    }
    $stmt->close();
} else {
        header("Location: Manage Customer.php");
        exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Customer | Book Time</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin-sidebar.css" />
    <style>
       
        :root { 
            --blue: #007bff; 
            --grey: #6c757d; 
            --bg: #f8f9fa; 
        }

        body { 
            font-family: 'Segoe UI', Arial; 
            background: var(--bg); 
            margin: 0;  
            display: flex; 
        }
        
        .main-content { 
            flex: 1; 
            padding: 30px; 
        }

        h1 { 
            margin-bottom: 20px;  
            font-size: 24px; 
            color: #333; 
        }

        /* back button */
        .btn-back { 
            background: var(--grey); 
            color: white; 
            padding: 8px 15px; 
            text-decoration: none; 
            border-radius: 5px; font-size: 14px;
            display: inline-block; 
            margin-bottom: 20px; 
        }

        /* form card */
        .form-card { 
            background: white; 
            padding: 25px; 
            border-radius: 10px; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.05); 
            max-width: 500px; 
        }

        .input-group { 
            margin-bottom: 18px; 
        }
        .input-group label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: bold; 
            font-size: 13px; 
            color: #555; 
        }

        /* input field */
        .input-field { 
            width: 100%; 
            padding: 10px; 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            box-sizing: border-box; 
            font-size: 14px;
        }
        .input-field:focus { 
            outline: none; 
            border-color: var(--blue); 
        }

        .hint { 
            font-size: 12px; 
            color: #999; 
            margin-top: 5px; 
        }

        /* Save button */
        .btn-save { 
            background: var(--blue); 
            color: white; 
            border: none; 
            padding: 12px 25px; 
            border-radius: 6px; 
            cursor: pointer; 
            font-weight: bold; 
            width: 100%; 
            font-size: 15px;
            margin-top: 10px; 
            transition: 0.3s;
        }
        .btn-save:hover { 
            opacity: 0.9; 
        }
        
        .error-box { 
            color: #dc3545; 
            background: #f8d7da; 
            padding: 10px; 
            border-radius: 5px; 
            margin-bottom: 20px; 
        }
    </style>
</head>

<body>
    <?php include 'admin-sidebar.php'; ?>

    <div class="main-content">
        <h1>Edit Customer Details</h1>

        <a href="Manage Customer.php" class="btn-back">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>

        <?php if ($errorMsg): ?>
            <div class="error-box"><?php echo $errorMsg; ?></div>
        <?php endif; ?>

        <?php if ($customer): ?>
        <div class="form-card">
            <form action="" method="POST">
                <input type="hidden" name="customer_id" value="<?php echo $customer['id']; ?>">

                <div class="input-group">
                    <label>Customer Name *</label>
                    <input type="text" name="customer_name" class="input-field" 
                           value="<?php echo htmlspecialchars($customer['name']); ?>" required>
                </div>

                <div class="input-group">
                    <label>Email Address *</label>
                    <input type="email" name="email" class="input-field" 
                           value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                </div>

                <div class="input-group">
                    <label>New Password</label>
                    <input type="password" name="new_password" class="input-field" placeholder="Enter new password">
                    <p class="hint">Leave blank if you don't want to change it.</p>
                </div>

                <div class="input-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" class="input-field" 
                           value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
                </div>

                <div class="input-group">
                    <label>Status</label>
                    <select name="status" class="input-field">
                        <option value="Active" <?php echo ($customer['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                        <option value="Suspended" <?php echo ($customer['status'] == 'Suspended') ? 'selected' : ''; ?>>Suspended</option>
                    </select>
                </div>

                <button type="submit" name="update_customer" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </form>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>