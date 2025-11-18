<?php
require_once 'config.php';

// Check if customer ID is provided//
if (isset($_GET['id'])) {
    $customerId = intval($_GET['id']);

    // Delete SQL//
    $stmt = $conn->prepare("DELETE FROM customers WHERE id = ?");
    $stmt->bind_param("i", $customerId);
   
   // Execute and redirect//
   if ($stmt->execute()) {
        header("Location: Manage Customer.php?message=deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    $stmt->close();
}
exit();
?>