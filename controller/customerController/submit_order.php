<?php
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../config/session_handler.php';

header('Content-Type: application/json');

try {
    // Add user verification before processing order
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    // Verify user exists and is active
    $stmt = $pdo->prepare("
        SELECT user_id FROM users 
        WHERE user_id = ? AND role = 'customer' AND status = 'Active'
    ");
    $stmt->execute([$_SESSION['user_id']]);
    if (!$stmt->fetch()) {
        throw new Exception('Invalid or inactive user');
    }

    // Check if request contains order data
    if (!isset($_POST['orderData'])) {
        throw new Exception('No order data received');
    }

    $orderData = json_decode($_POST['orderData'], true);
    if (!$orderData) {
        throw new Exception('Invalid order data format');
    }

    $pdo->beginTransaction();

    // 1. Insert main order
    $stmt = $pdo->prepare("
        INSERT INTO orders (
            user_id,
            service_id,
            total_price,
            status,
            payment_status,
            order_date,
            branch_id
        ) VALUES (?, ?, ?, 'Pending', 'Pending', NOW(), 1)
    ");

    $stmt->execute([$_SESSION['user_id'], $orderData['service']['id'], $orderData['totals']['grandTotal']]);

    $order_id = $pdo->lastInsertId();

    // 2. Insert order details
    $stmt = $pdo->prepare("
        INSERT INTO order_details (
            order_id,
            service_id,
            quantity,
            unit_price,
            size
        ) VALUES (?, ?, ?, ?, ?)
    ");

    foreach ($orderData['items'] as $item) {
        $stmt->execute([
            $order_id,
            $orderData['service']['id'],
            $item['quantity'],
            $item['pricePerUnit'],
            $item['size'],
        ]);
    }

    // 3. Handle payment proof if uploaded
    if (isset($_FILES['payment_proof'])) {
        $paymentProof = $_FILES['payment_proof'];
        $uploadDir = __DIR__ . '/../../uploads/payments/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = uniqid() . '_' . basename($paymentProof['name']);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($paymentProof['tmp_name'], $filePath)) {
            $stmt = $pdo->prepare("
                INSERT INTO payments (
                    order_id,
                    payment_method,
                    amount,
                    proof_file_name,
                    proof_file_path,
                    status
                ) VALUES (?, 'GCash', ?, ?, ?, 'Pending Verification')
            ");

            $stmt->execute([$order_id, $orderData['totals']['grandTotal'], $fileName, 'uploads/payments/' . $fileName]);
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Order submitted successfully!',
    ]);
} catch (Exception $e) {
    if (isset($pdo)) {
        $pdo->rollBack();
    }
    error_log('Order submission failed: ' . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Order submission failed: ' . $e->getMessage(),
    ]);
}
?>
