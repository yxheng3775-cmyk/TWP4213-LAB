<?php
// Initial setup (模拟数据库连接等)//
$customer = null;
$errorMsg = '';

// simulate fetching data// 模拟获取客户数据
if (isset($_GET['id'])) {
    $customerId = $_GET['id'];
    $customer = [
        'customer_id' => $customerId,
        'customer_name' => 'Jack',
        'email' => 'jack@example.com',
        'phone' => '012-3456789',
        'status' => 'Active'
    ];
} else {
    $errorMsg = "Invalid Customer ID.";
}

// handle form submission (simulate)// 处理表单提交（模拟）
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_customer'])) {
    header("Location: index.html?message=updated");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer | Book Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        /* Internal CSS as per requirements */
        :root { 
            --brand-orange: #ffa100; 
        }
        body { 
            background-color: #f4f7f6; 
            font-family: 'Segoe UI', sans-serif;
        }
        
        .sidebar {
            min-height: 100vh;
            background-color: var(--brand-orange);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

         .sidebar-brand-box {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .logo-img { 
            height: 40px; 
            width: auto; 
            max-width: 100%;
            object-fit: contain;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 12px 20px;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(0,0,0,0.1);
            border-left: 4px solid white;
        }
        .card { 
            border: none; 
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); 
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block sidebar collapse px-0 shadow">
            <a href="index.html" class="sidebar-brand-box">
                 <img src="img/logo.png" alt="Book Time Logo" class="logo-img">
            </a>

            <div class="position-sticky pt-2">
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link" href="Dashboard.php"><i class="fas fa-home me-2"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.html"><i class="fas fa-users me-2"></i> Customer Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="Categories.php"><i class="fas fa-list me-2"></i> Categories Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="Books.php"><i class="fas fa-book me-2"></i> Books Management</a></li>
                    <li class="nav-item"><a class="nav-link" href="Order.php"><i class="fas fa-shopping-cart me-2"></i> Orders Management</a></li>
                </ul>
            </div>
        </nav>

        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            
            <div class="mb-3">
                <a href="index.html" class="btn btn-outline-secondary btn-sm px-3 shadow-sm">
                    <i class="fas fa-arrow-left me-1"></i> Back to List
                </a>
            </div>

            <div class="mb-4">
                <h2 class="fw-bold text-dark">Edit Customer Details</h2>
                <p class="text-muted small">Update the information for this customer below.</p>
            </div>

            <?php if ($errorMsg): ?>
                <div class="alert alert-danger shadow-sm"><?php echo $errorMsg; ?></div>
            <?php endif; ?>

            <?php if ($customer): ?>
            <div class="card shadow-sm col-lg-8">
                <div class="card-body p-4">
                    <form action="" method="POST">
                        <input type="hidden" name="customer_id" value="<?php echo $customer['customer_id']; ?>">

                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Customer Name *</label>
                                <input type="text" name="customer_name" class="form-control form-control-lg" 
                                       value="<?php echo htmlspecialchars($customer['customer_name']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Email Address *</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?php echo htmlspecialchars($customer['email']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" 
                                       value="<?php echo htmlspecialchars($customer['phone']); ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Account Status</label>
                                <select name="status" class="form-select">
                                    <option value="Active" <?php echo ($customer['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="Suspended" <?php echo ($customer['status'] == 'Suspended') ? 'selected' : ''; ?>>Suspended</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 pt-2">
                                <hr>
                                <button type="submit" name="update_customer" class="btn btn-primary px-5 py-2 fw-bold shadow-sm">
                                    <i class="fas fa-save me-2"></i>Save Changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>