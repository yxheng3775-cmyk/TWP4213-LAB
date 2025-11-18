<?php
session_start();
include 'includes/config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Result | Lakeshow Grocer</title>
    <link rel="stylesheet" href="css/products.css">
    <link rel="stylesheet" href="css/form.css">
    <link rel="stylesheet" href="css/shoppingcart.css">
    <link rel="stylesheet" href="css/template.css">
</head>

<body>
    <?php include_once 'includes/header.php'; ?>

    <section class="form">
        <div class="cart-container">
        <div class="section-header">
            <h2>Search Results</h2>
        </div>
        <div class="products-container">
                    <div class="product-card">
                        <a href="product_page.php?pid=1">
                            <div class="product-image">
                                <img src="uploads/products/driscollbluberries.webp" alt="">

                            </div>
                            <div class="product-info">
                                <h3 class="product-title">Blueberry Driscolls (200g)</h3>
                                    <p class="product-price">RM 21.90</p>
                            </div>
                        </a>

                            <form method="post" action="Lab 11 Q1 Cart.php" class="add-to-cart-form">
                            <input type="hidden" name="product_id" value="">
                            <input type="hidden" name="product_price" value="">
                            <button class="add-to-cart">Add to Cart</button>
                            </form>
                    </div>

        </div>
    
        </div>
    </section>

    <?php include_once 'includes/footer.php'; ?>

</body>
</html>