<?php
require_once 'config.php'; // must include database connection//

// Handle suspend logic//
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['suspend_customer'])) {
    $customerId = $_POST['customer_id'];

    // Execute database update: change status to Suspended//
    $stmt = $conn->prepare("UPDATE customers SET status = 'Suspended' WHERE id = ?");
    $stmt->bind_param("i", $customerId);

    if ($stmt->execute()) {
        header("Location: Manage Customer.php?message=suspended");
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    exit();
}

// Handle activate logic//
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['active_customer'])) {
    $customerId = $_POST['customer_id'];

    // Execute database update: change status to Active//
    $stmt = $conn->prepare("UPDATE customers SET status = 'Active' WHERE id = ?");
    $stmt->bind_param("i", $customerId);

    if ($stmt->execute()) {
        header("Location: Manage Customer.php?message=activated");
    } else {
        echo "Error: " . $conn->error;
    }
    $stmt->close();
    exit();
}

// If directly accessing this file, redirect back to homepage//
header("Location: Manage Customer.php");
exit();
?>