<?php
require_once 'config.php'; 

// Retrieves the total count of 'Active' and 'Suspended' customers for the dashboard cards. // 
//Count Active Customers//
$stmtActive = $conn->prepare("SELECT COUNT(*) FROM customers WHERE status = 'Active'");
$stmtActive->execute();
$stmtActive->bind_result($totalActive);
$stmtActive->fetch();
$stmtActive->close();


//Count Suspended Customers//
$stmtSuspended = $conn->prepare("SELECT COUNT(*) FROM customers WHERE status = 'Suspended'");
$stmtSuspended->execute();
$stmtSuspended->bind_result($totalSuspended);
$stmtSuspended->fetch();
$stmtSuspended->close();

// Checks if search terms or status filters are passed via the URL (GET request). //
$searchName = isset($_GET['customername']) ? $_GET['customername'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

$listSql = "SELECT id, name, email, phone, password, registration_date, status FROM customers WHERE 1=1";
// Append conditions based on search and filter inputs. //
if ($searchName != '') { $listSql .= " AND (name LIKE ? OR id LIKE ?)"; }
if ($statusFilter != '') { $listSql .= " AND status = ?"; }

$stmtList = $conn->prepare($listSql);
// Bind parameters based on which filters are applied. //
if ($searchName != '' && $statusFilter != '') {
    $nameParam = "%$searchName%";
    $stmtList->bind_param("sss", $nameParam, $nameParam, $statusFilter);
} elseif ($searchName != '') {
    $nameParam = "%$searchName%";
    $stmtList->bind_param("ss", $nameParam, $nameParam);
} elseif ($statusFilter != '') {
    $stmtList->bind_param("s", $statusFilter);
}

$stmtList->execute();
$result = $stmtList->get_result();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="admin-sidebar.css" />
    <style>
        :root {
           --main-bg: #f8f9fa;
           --border-radius: 8px;
           --card-shadow: 0 2px 10px rgba(0,0,0,0.05);
           --primary-blue: #0d6efd;
           --primaary-orange: #ffa100;
           --primary-red: #dc3545;
        }

        .main-content {
           flex: 1;            /* automatically fill all remaining space in the sidebar*/
           min-width: 0;       /* prevent content  from overflowing and expanding the layout */
           min-height: 100vh;
           padding: 30px;
           background-color: var(--main-bg);
        }

        /* */ 
        .row {
           display: flex;
           flex-wrap: nowrap; /*Force no line breaks to prevent content from falling down.*/
        }

        .top-header {
           display: flex;
           justify-content: space-between;
           align-items: center;
           margin-bottom: 25px;
        }

        .top-header h1 {
           font-size: 24px;
           font-weight: 700;
           color: #333;
        }

        .btn-add {
            background-color: var(--primaary-orange);
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }

        /* stat card */
        .stat-group {
            display: flex;
            gap: 20px;
            margin-bottom: 25px;
            justify-content: flex-start;/* limit the overall width */
        }

        .stat-group .card {
            background: white;
            border: none;
            border-radius: var(--border-radius);
            padding: 20px;
            width:350px;
            box-shadow: var(--card-shadow);
        }

        .card.active { 
            border-left: 4px solid var(--primary-blue); 
        }
        .card.suspended { 
            border-left: 4px solid #dc3545; 
        }

        .card h3 { 
            font-size: 14px; 
            color: #666; 
            margin-bottom: 10px; 
        }
        .card p { 
            font-size: 28px; 
            font-weight: bold; 
            margin: 0; 
        }

        /* search bar */
        .search-bar {
            background: white;
            padding: 20px;
            border-radius: var(--border-radius);
            display: flex;
            align-items: flex-end;
            gap: 20px;
            margin-bottom: 30px;
            box-shadow: var(--card-shadow);
            width: 800px;
        }

        .filter-item { 
            flex: 1; 
        }
        .filter-item label { 
            display: block; 
            font-size: 13px; 
            font-weight: 600; 
            margin-bottom: 8px; 
        }
        .filter-item input, .filter-item select {
             width: 100%;
             padding: 8px 12px;
             font-size: 14px;
             border: 1px solid #dee2e6;
             border-radius: 5px;
        }

        .btn-search {
             background-color: var(--primary-blue);
             color: white;
             border: none;
             padding: 9px 30px;
             border-radius: 5px;
             cursor: pointer;
        }

        /* data table */
        .data-table {
             width: 100%;
             background: white;
             border-collapse: collapse;
             border-radius: var(--border-radius);
             overflow: hidden;
             box-shadow: var(--card-shadow);
        }

        .data-table th {
             background-color: #fcfcfc;
             padding: 15px;
             text-align: left;
             font-size: 11px;
             text-transform: uppercase;
             color: #999;
             border-bottom: 1px solid #eee;
        }

        .data-table td {
              padding: 15px;
              border-bottom: 1px solid #f1f1f1;
              font-size: 14px;
        }

        /* status label */
        .badge-active { 
            background-color: #e6f4ea; 
            color: #1e7e34; 
            padding: 5px 12px; 
            border-radius: 15px; 
            font-size: 12px; }
        .badge-suspended { 
            background-color: #fce8e8; 
            color: var(--primary-red); 
            padding: 5px 12px; 
            border-radius: 15px; 
            font-size: 12px; }

        /* action button */
        .action-btns { 
            display: flex; 
            gap: 8px; 
            align-items: center; /* ensure button is vertically centered确保按钮垂直居中对齐 */
        }

        .action-btns a {
            border: 1px solid #eee;
            background: white;
            padding: 5px 15px;      /* left and right inner margins*/
            border-radius: 4px;
            color: var(--primary-orange);
            text-decoration: none;  
            font-size: 13px;
            display: inline-flex;   /* Use flex layout to place icons and text side by side. */
            align-items: center;
            gap: 5px;               /* Spacing between icons and text */
            white-space: nowrap;    /* Force text to not wrap */
            width: auto;            /* expand automatically according to the text */
            min-width: 130px;       
            justify-content: center;
        }

        /* For other icon buttons (sync and delete) */
        .action-btns button {
            border: 1px solid #eee;
            background: white;
            padding: 5px 8px;
            border-radius: 4px;
            color: #666;
            width: 40px;    /*same width of sync and delete button*/        
            height: 32px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .action-btns .fa-edit { 
            color: var(--primaary-orange); 
        }
        .action-btns .fa-sync { 
            color: var(--primary-blue); 
        }
        .action-btns .fa-trash { 
            color: var(--primary-red); 
        }
       
    </style>
</head>
<body>

    <?php include 'admin-sidebar.php'; ?>

    <div class="main-content">
        <div class="top-header">
            <h1>Customer Management</h1>
            <a href="AddCustomer.php" class="btn-add"><i class="fas fa-plus"></i> Add Customer</a>
        </div>

        <div class="stat-group">
            <div class="card active">
                <h3>Active Customers</h3>
                <p><?php echo $totalActive; ?></p>
            </div>
            <div class="card suspended">
                <h3>Suspended</h3>
                <p><?php echo $totalSuspended; ?></p>
            </div>
        </div>

        <form action="" method="GET" class="search-bar">
            <div class="filter-item search-input">
                <label>Search Customers</label>
                <input type="text" name="customername" placeholder="Name or ID..." value="<?php echo htmlspecialchars($searchName); ?>">
            </div>
            <div class="filter-item status-dropdown">
                <label>Status</label>
                <select name="status">
                    <option value="">All Status</option>
                    <option value="Active" <?php echo ($statusFilter == 'Active') ? 'selected' : ''; ?>>Active</option>
                    <option value="Suspended" <?php echo ($statusFilter == 'Suspended') ? 'selected' : ''; ?>>Suspended</option>
                </select>
            </div>
            <button type="submit" class="btn-search"><i class="fas fa-search"></i> Search</button>
        </form>

        <table class="data-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Password</th>
            <th>Reg. Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><strong><?php echo htmlspecialchars($row['name']); ?></strong></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            
            <td class="cust-password"><?php echo htmlspecialchars($row['password']); ?></td>
            
            <td><?php echo $row['registration_date']; ?></td>
            <td>
                <span class="badge <?php echo ($row['status'] == 'Active') ? 'badge-active' : 'badge-suspended'; ?>">
                    <?php echo $row['status']; ?>
                </span>
            </td>
            <td class="action-btns">
                <a href="EditCustomer.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i>Edit Customer</a>

                <form action="UpdateCustomerStatus.php" method="POST" class="status-form">
                    <input type="hidden" name="customer_id" value="<?php echo $row['id']; ?>">
                    <button type="submit" name="<?php echo ($row['status'] == 'Active') ? 'suspend_customer' : 'active_customer'; ?>">
                        <i class="fas fa-sync sync-icon-<?php echo strtolower($row['status']); ?>"></i>
                    </button>
                </form>

                        <button type="button" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        /*Prevents accidental deletion by asking the user for confirmation.*/
    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete customer #" + id + "?")) {
            window.location.href = 'DeleteCustomer.php?id=' + id;
        }
    }
    </script>
</body>
</html>
