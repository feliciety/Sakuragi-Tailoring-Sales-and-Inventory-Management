<?php
require_once __DIR__ . '/../../config/db_connect.php';
require_once __DIR__ . '/../../config/session_handler.php';

header('Content-Type: application/json');

try {
    // User verification
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

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

    // Validate required order data
    if (!isset($orderData['service']) || !isset($orderData['items']) || !isset($orderData['totals'])) {
        throw new Exception('Missing required order data fields');
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
            size,
            subtotal
        ) VALUES (?, ?, ?, ?, ?, ?)
    ");

    foreach ($orderData['items'] as $item) {
        if (!isset($item['quantity']) || !isset($item['size']) || !isset($item['pricePerUnit'])) {
            throw new Exception('Invalid item data structure');
        }

        $quantity = intval($item['quantity']);
        $pricePerUnit = floatval($item['pricePerUnit']);
        $subtotal = $quantity * $pricePerUnit;

        $stmt->execute([$order_id, $orderData['service']['id'], $quantity, $pricePerUnit, $item['size'], $subtotal]);
    }

    // 3. Handle payment proof if uploaded
    if (isset($_FILES['payment_proof']) && $_FILES['payment_proof']['error'] === UPLOAD_ERR_OK) {
        $paymentProof = $_FILES['payment_proof'];
        $uploadDir = __DIR__ . '/../../public/uploads/payments/';

        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                throw new Exception('Failed to create payment uploads directory');
            }
        }

        $fileName = uniqid() . '_' . basename($paymentProof['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($paymentProof['tmp_name'], $filePath)) {
            throw new Exception('Failed to upload payment proof');
        }

        // Insert payment record
        $stmt = $pdo->prepare("
            INSERT INTO payments (
                order_id,
                amount,
                proof_file_name,
                proof_file_path,
                payment_date,
                status
            ) VALUES (?, ?, ?, ?, NOW(), 'Pending Verification')
        ");

        $stmt->execute([$order_id, $orderData['totals']['grandTotal'], $fileName, 'uploads/payments/' . $fileName]);
    } else {
        throw new Exception('Payment proof is required');
    }

    // 4. Handle design file upload
    if (isset($_FILES['design_file']) && $_FILES['design_file']['error'] === UPLOAD_ERR_OK) {
        $designFile = $_FILES['design_file'];
        $uploadDir = __DIR__ . '/../../public/uploads/designs/';

        // Create directory if it doesn't exist
        if (!file_exists($uploadDir)) {
            if (!mkdir($uploadDir, 0777, true)) {
                throw new Exception('Failed to create design uploads directory');
            }
        }

        $fileName = uniqid() . '_' . basename($designFile['name']);
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($designFile['tmp_name'], $filePath)) {
            throw new Exception('Failed to upload design file');
        }

        // Update order with design file path
        $stmt = $pdo->prepare("
            UPDATE orders 
            SET design_file_path = ? 
            WHERE order_id = ?
        ");
        $stmt->execute(['uploads/design/' . $fileName, $order_id]);
    }

    $pdo->commit();

    // Success response with order details
    $response = [
        'success' => true,
        'order_id' => $order_id,
        'message' => 'Order submitted successfully!',
    ];

    echo json_encode($response);
} catch (Exception $e) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }

    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Order submission failed: ' . $e->getMessage(),
    ]);
}
?>
