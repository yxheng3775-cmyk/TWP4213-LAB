<?php


// handle suspend logic (Suspend)// 停用客户账号
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['suspend_customer'])) {
    
    // get ID 获取 ID (虽然在静态版中用不到，但保留逻辑完整性)//
    $customerId = $_POST['customer_id'];

    // redirect to homepage with suspended message 模拟成功：直接跳转回主页，并告知已停用//
    header("Location: index.html?message=suspended");
    exit();
}

// handle activate logic (Activate)// 激活客户账号
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['active_customer'])) {

    $customerId = $_POST['customer_id'];

    // redirect to homepage with activated message 模拟成功：直接跳转回主页，并告知已激活//
    header("Location: index.html?message=activated");
    exit();
}

// If directly accessing this file, redirect back to homepage//
header("Location: index.html");
exit();
?>