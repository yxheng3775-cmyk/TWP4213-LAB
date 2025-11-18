<?php



require_once 'includes/config.php';
/*Total active products*/
$countproductsql = "SELECT COUNT(*) FROM product WHERE status = 'Active'";
$stmtcount = $conn->prepare($countproductsql);
$stmtcount->execute();
$stmtcount->bind_result($totalActiveProducts);
$stmtcount->fetch();
$stmtcount->close();



/*Total inactive products*/
$countInactiveSql = "SELECT COUNT(*) FROM product WHERE status = 'Inactive'";
$stmtInactive = $conn->prepare($countInactiveSql);
$stmtInactive->execute();
$stmtInactive->bind_result($totalInactiveProducts);
$stmtInactive->fetch();
$stmtInactive->close();



/*Low stock products(<10)*/
$countLowStockSql = "SELECT COUNT(*) FROM product WHERE Product_Stock < 10";
$stmtLowStock = $conn->prepare($countLowStockSql);
$stmtLowStock->execute();
$stmtLowStock->bind_result($lowStockProducts);
$stmtLowStock->fetch();
$stmtLowStock->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management | Lakeshow Grocery</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/product.css">
</head>



<body>
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <div class="header">
            <h1>Product Management</h1>
            <div class="header-right">
                <div class="user-info">
                </div>
            </div>
        </div>

   

    <?php if (isset($_GET['message'])): ?>
       <div class="alert <?php echo $_GET['message'] == "activated" ? "alert-success" : ($_GET['message'] == "deactivated" ? "alert-warning" : "alert-danger"); ?>" id="successAlert">
        <?php
        if ($_GET['message'] == "activated"){
           echo "The product status has been activated";
        }elseif ($_GET['message'] == "deactivated"){
           echo "The product status has been deactivated";
        }elseif ($_GET['message'] == "error"){
           echo "An error occurred. Please try again.";
        }
        ?>
    </div>

    <?php endif; ?>
        <div class="content">
            <h2 class="page-title">Product Overview</h2>
            <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total Active Products</span>
                    </div>
                    <div class="card-value"><?php echo $totalActiveProducts; ?></div>
                    <div class="card-footer">All active products</div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">Total Inactive Products</span>
                    </div>

                    <div class="card-value"><?php echo $totalInactiveProducts; ?></div>
                    <div class="card-footer">All inactive products</div>
                </div>

                <div class="card">
                    <div class="card-header">
                          <span class="card-title">Low Stock</span>
                    </div>

                    <div class="card-value"><?php echo $lowStockProducts; ?></div>
                    <div class="card-footer">Products with stock < 10</div>
                </div>
            </div>

<form action="" method="GET" class="filter-form">
            <div class="search-filters">
                <div class="filter-group">
                    <label for="productSearch">Search Products</label>
                    <input type="text" id="productSearch" placeholder="Name or ID..." class="search-input" name="productname">
                </div>
                <?php

$categoriesQuery = "SELECT * FROM category ORDER BY Category_Name";
$categoriesResult = $conn->query($categoriesQuery);
?>

                <div class="filter-group">
                    <label for="categoryFilter">Category</label>
                    <select id="categoryFilter" class="form-control" name="category">
                        <option value="">All Categories</option>
                        <?php
                        while ($category = $categoriesResult->fetch_assoc()): ?>
<option value="<?php echo htmlspecialchars($category['Category_Name']); ?>">
<?php echo htmlspecialchars($category['Category_Name']); ?>
</option>
<?php endwhile; ?>
                    </select>
                </div>

               
                <div class="filter-group">
                    <label for="stockFilter">Stock Status</label>
                    <select id="stockFilter" class="form-control" name="stock">
                        <option value="">All</option>
                        <option value="low">Low Stock (&lt;10)</option>
                        <option value="out">Out of Stock</option>
                        <option value="in">In Stock</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
            </form>
            <div class="action-bar">
                <a href="AddProduct.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add Product
                </a>
            </div>


            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $filter = "";
                        if (isset($_GET['stock']) && !empty($_GET['stock'])) {
                        if ($_GET['stock'] == 'low') {
                        $filter .= " AND product.Product_Stock < 10";
                        } elseif ($_GET['stock'] == 'out') {
                        $filter .= " AND product.Product_Stock = 0";
                        } elseif ($_GET['stock'] == 'in') {
                        $filter .= " AND product.Product_Stock >= 10";
                        }
                  }
                  if (isset($_GET['productname']) && !empty($_GET['productname'])) {
                $filter .= " AND product.Product_Name LIKE
                '%".$_GET['productname']."%'";
               }


               if (isset($_GET['category']) && !empty($_GET['category'])) {
               $filter .= " AND category.Category_Name = '".$_GET['category']."'";
               }

        $productsQuery = "SELECT product.*, category.Category_Name FROM product INNER JOIN category
        ON product.Category_ID = category.Category_ID
        WHERE 1" . $filter;
        $productsQuery .= " ORDER BY product.Product_ID";
        $productsResult = $conn->query($productsQuery);
        while($product = $productsResult->fetch_assoc()): ?>
        <td><?php echo $product['Product_ID']; ?></td>

        <td><?php if ($product['Product_Picture']): ?>
        <img src="uploads/products/<?php echo $product['Product_Picture']; ?>"
        alt="Product Image" class="product-thumbnail">
        <?php else: ?>
        <div class="no-image">No image</div>
     <?php endif; ?>
     </td>

    <td><?php echo $product['Product_Name']; ?></td>
     <td>RM <?php echo number_format($product['Product_Price'], 2); ?></td>
    <td><?php echo $product['Product_Stock']; ?></td>
    <td><?php echo htmlspecialchars($product['Category_Name'] ?? 'Uncategorized'); ?></td>

       <td><a href="EditProduct.php?id=<?php echo $product['Product_ID']; ?>"
         class="btn btn-edit" style="text-decoration: none;">
         <i class="fas fa-edit"></i> Edit</a>
      <form method="POST" action="UpdateProductStatus.php" style="display: inline;">

   

      <?php if ($product['status'] === 'Active'): ?>
    <input type="hidden" name="product_id"
      value="<?php echo $product['Product_ID']; ?>">
         <input type="hidden" name="inactive_product" value="Inactive">



                       <button type="submit" class="btn btn-delete"
                       onclick="return confirm('Are you sure you want to mark this product as inactive?');">
                     <i class="fas fa-trash"></i> Make Inactive
                 </button>
                <?php else: ?>
                      <input type="hidden" name="product_id"
                         value="<?php echo $product['Product_ID']; ?>">
                      <input type="hidden" name="active_product" value="Active">
                      <button type="submit" class="btn btn-primary"
                         onclick="return confirm('Are you sure you want to restore this product to be active?');">
                        <i class="fas fa-undo"></i> Activate Product
                     </button>
                    <?php endif; ?>
                    </form>
                    </td>
                    </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>