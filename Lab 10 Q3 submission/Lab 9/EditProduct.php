<?php
require_once 'includes/config.php';

// Initialize variables//

$product = null;
$errorMsg = '';
$successMsg = '';

// Check and get product ID (Primary Key)//
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Use Prepared Statement to get current product data//
    $stmt = $conn->prepare("SELECT * FROM product WHERE Product_ID = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $product = $result->fetch_assoc();
    } else {
        $errorMsg = "Product not found.";
    }
    $stmt->close();
} else {
    header("Location: lab 09 Q1.php");
    exit();
}

// handle form submission(Update Logic)//
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_product'])) {
    $pid = $_POST['product_id'];
    $name = trim(htmlspecialchars($_POST['product_name']));
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $description = trim(htmlspecialchars($_POST['description']));

    if (empty($name) || empty($category_id) || $price <= 0 || $stock < 0) {
        $errorMsg = "Please fill in all required fields.";
    } else {
        // data update//
        $updateSql = "UPDATE product SET 
                      Product_Name = ?, Category_ID = ?, 
                      Product_Price = ?, Product_Stock = ?, 
                      Product_Description = ? 
                      WHERE Product_ID = ?";
        
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sidisi", $name, $category_id, $price, $stock, $description, $pid);
        
        if ($updateStmt->execute()) {
            // independently handle image logic//
            if (isset($_POST['remove_image'])) {
                $conn->query("UPDATE product SET Product_Picture = NULL WHERE Product_ID = $pid");
            } elseif (!empty($_FILES['product_image']['name'])) {
                $target_dir = "uploads/products/";
                // check if directory exists//
                if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }
                
                $image_name = time() . "_" . basename($_FILES["product_image"]["name"]);
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_dir . $image_name)) {
                    $conn->query("UPDATE product SET Product_Picture = '$image_name' WHERE Product_ID = $pid");
                }
            }
            $updateStmt->close();
            header("Location: lab 09 Q1.php?message=updated");
            exit();
        } else {
            $errorMsg = "Update failed: " . $conn->error;
            $updateStmt->close();
        }
    }
}

// get all categories for dropdown menu//
$catResult = $conn->query("SELECT * FROM category ORDER BY Category_Name");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product | Lakeshow Grocery</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/product.css">

</head>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <div class="main-content">
        <div class="header">
            <h1>Edit Product</h1>
        </div>

        <div class="content">
            <div class="action-bar">
                <a href="lab 09 Q1.php" class="btn btn-secondary">Back to List</a>
            </div>


            <?php if ($errorMsg): ?>
                <div class="alert alert-danger"><?php echo $errorMsg; ?></div>
            <?php endif; ?>

            <?php if ($product): ?>
            <form action="EditProduct.php?id=<?php echo $product['Product_ID']; ?>" method="POST" enctype="multipart/form-data" class="product-form">
                <input type="hidden" name="product_id" value="<?php echo $product['Product_ID']; ?>">

                <div class="form-group">
                    <label>Product Name *</label>
                    <input type="text" name="product_name" class="form-control"
                           value="<?php echo htmlspecialchars($product['Product_Name']); ?>" required>
                </div>

                <div class="form-group">
                    <label>Category *</label>
                    <select name="category_id" class="form-control" required>
                        <?php while ($cat = $catResult->fetch_assoc()): ?>
                            <option value="<?php echo $cat['Category_ID']; ?>"
                                <?php echo ($cat['Category_ID'] == $product['Category_ID']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['Category_Name']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Price (RM) *</label>
                    <input type="number" name="price" class="form-control" step="0.01" min="0.01"
                           value="<?php echo $product['Product_Price']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Stock Quantity *</label>
                    <input type="number" name="stock" class="form-control" min="0"
                           value="<?php echo $product['Product_Stock']; ?>" required>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($product['Product_Description']); ?></textarea>
                </div>

                <div class="form-group">
                    <label>Product Image</label>
                    <?php if(!empty($product['Product_Picture'])): ?>
                <div style="margin: 10px 0;">
                    <img src="uploads/products/<?php echo $product['Product_Picture']; ?>" width="100" style="border: 1px solid #ddd;">
                </div>
            <?php endif; ?>
                    <input type="file" name="product_image" class="form-control">
                </div>

                <div class="form-group">
                    <input type="checkbox" name="remove_image" value="1">
                    <label>Remove current image</label>
                <small>Max file size: 2MB (JPG, PNG, GIF)</small>
                </div>
             <p>
                <button type="submit" name="update_product" class="btn btn-primary">
                 <img src="images/update-icon.png" alt="Update Icon" width= "20" height = "20">
                 Update Product</button></p>
            </form>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>