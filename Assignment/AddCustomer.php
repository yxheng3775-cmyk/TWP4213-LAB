<?php
$nameError = ''; 

// handle form submission//
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customerName = trim($_POST['customer_name']);
    
    if ($customerName === 'Admin') {
        $nameError = 'This name is reserved and cannot be used.';
    } else {
        header("Location: index.html?message=success");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer | Book Time</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        :root { --brand-orange: #ffa100; }
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }

        /* sidebar styles unified */
        .sidebar {
            min-height: 100vh;
            background-color: var(--brand-orange);
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
        }

        /* Logo Container */
        .sidebar-brand-box {
            padding: 20px 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        /* Logo overflow prevention */
        .logo-img { 
            height: 40px; 
            width: auto; 
            max-width: 100%;
            object-fit: contain;
        } 

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            font-size: 0.9rem;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: white;
            background: rgba(0,0,0,0.1);
            border-left: 4px solid white;
        }
        
        .card { border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.05); }

        /* Mobile responsive adjustments */
        @media screen and (max-width: 768px) {
            .sidebar { 
                min-height: auto; 
                width: 100%; }
            .sidebar .nav { 
                flex-direction: row; 
                justify-content: center; 
                flex-wrap: wrap; 
            }
            .sidebar .nav-link { 
                border-left: none; 
                border-bottom: 3px solid transparent; 
            }
            .sidebar .nav-link.active { 
                border-bottom: 3px solid white; 
            }
            .sidebar-brand-box { 
                padding: 10px; 
            }
            .logo-img { 
                height: 30px; 
            }
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
                <h2 class="fw-bold text-dark">Add New Customer</h2>
                <p class="text-muted small">Register a new member to the system.</p>
            </div>

            <?php if ($nameError): ?>
                <div class="alert alert-danger shadow-sm border-0 border-start border-4 border-danger">
                    <i class="fas fa-exclamation-circle me-2"></i> <?php echo $nameError; ?>
                </div>
            <?php endif; ?>

            <div class="card shadow-sm col-lg-8">
                <div class="card-body p-4">
                    <form action="AddCustomer.php" method="POST">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label fw-bold small text-muted">Full Name *</label>
                                <input type="text" name="customer_name" 
                                       class="form-control form-control-lg <?php echo $nameError ? 'is-invalid' : ''; ?>" 
                                       placeholder="Enter customer full name" required>
                                <?php if ($nameError): ?>
                                    <div class="invalid-feedback"><?php echo $nameError; ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Email Address *</label>
                                <input type="email" name="email" class="form-control" placeholder="example@mail.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" placeholder="012-3456789" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Initial Status</label>
                                <select name="status" class="form-select">
                                    <option value="Active" selected>Active</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                            </div>

                            <div class="col-12 mt-4 pt-2 border-top">
                                <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm" style="background-color: var(--brand-orange); border: none;">
                                    <i class="fas fa-user-plus me-2"></i>Register Customer
                                </button>
                                <button type="reset" class="btn btn-light px-4 py-2 ms-2">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>