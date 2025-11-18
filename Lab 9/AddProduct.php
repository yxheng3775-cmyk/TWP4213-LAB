<?php
 require_once 'includes/config.php';

 // Initialize error message variable//
 $nameError = '';   
 $message = '';

 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productname = trim($_POST['product_name']);
    // Check for duplicate product name//
    $checkQuery = "SELECT Product_ID FROM product WHERE Product_Name = ?";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->bind_param('s', $productname);
    $checkStmt->execute();
    $checkStmt->bind_result($checkResult);
    $checkStmt->fetch();
    $checkStmt->close();

 if ($checkResult > 0) {
    $nameError = 'A product with this name already exists.';
 }else {
    $categoryid = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'] ;
    $description = trim($_POST['description']);
    // Insert new product into the database//
    $query = "INSERT INTO product (Product_Name, Category_ID, Product_Price, Product_Stock, Product_Description, status)
    VALUES (?, ?, ?, ?, ?, 'Active')";
    $addproductstmt = $conn->prepare($query);
    $addproductstmt->bind_param('sidis',
    $productname, $categoryid, $price, $stock, $description);
 
    if ($addproductstmt->execute()) {
       header("Location: Lab 09 Q1.php?message=success");
       exit();
    }else {
       header("Location: Lab 09 Q1.php?message=error");
       exit();
   }
    $addproductstmt->close();
   }
}

// Fetch categories for the dropdown//
$categorySql = "SELECT Category_ID, Category_Name FROM category";
$categoryStmt = $conn->prepare($categorySql);
$categoryStmt->execute();
$categoryResult = $categoryStmt->get_result();
$categories = [];
while ($row = $categoryResult->fetch_assoc()) {
   $categories[] = $row;
}
$categoryStmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product | Lakeshow Grocery</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<?php include_once 'includes/sidebar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h1>Add New Product</h1>
            <div class="header-right">
                <div class="user-info">
                    <img src="img/AdminLogo.webp" alt="Admin Profile">
                    <span></span>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="action-bar">
                <a href="Product.php" class="btn btn-secondary" style="text-decoration: none;">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>

            <?php if (isset($_GET['message'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_GET['message'];  ?>
                </div>
            <?php endif; ?>

            <form id="productForm" action="AddProduct.php" method="POST" enctype="multipart/form-data" class="product-form">
                <div class="form-group">
                    <label for="product_name">Product Name *</label>
                    <input type="text" id="product_name" name="product_name" class="form-control <?php echo $nameError ? 'is-invalid' : ''; ?>" 
                           value="" required>
                    <div class="invalid-feedback"><?php echo $nameError; ?></div>
                </div>
                
                <div class="form-group">
                    <label for="category_id">Category *</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['Category_ID']; ?>">
                                <?php echo htmlspecialchars($category['Category_Name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Please select a category.</div>
                </div>
                
                <div class="form-group">
                    <label for="price">Price (RM) *</label>
                    <input type="number" id="price" name="price" class="form-control" step="0.01" min="0.01" 
                           value="" required>
                    <div class="invalid-feedback">Please provide a valid price.</div>
                </div>
                
                <div class="form-group">
                    <label for="stock">Initial Stock Quantity *</label>
                    <input type="number" id="stock" name="stock" class="form-control" min="0" 
                           value="" required>
                    <div class="invalid-feedback">Please provide a valid stock quantity.</div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <button type="submit" id="submitBtn" class="btn btn-primary">
                        <i class="fas fa-save"></i> Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
