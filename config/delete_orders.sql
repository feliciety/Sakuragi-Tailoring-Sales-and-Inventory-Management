START TRANSACTION;

-- 1. Delete related records in order_details
DELETE FROM order_details WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 2. Delete related records in payments (if any)
DELETE FROM payments WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 3. Delete related records in order_workflow (if any)
DELETE FROM order_workflow WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 4. Delete related records in shipping (if any)
DELETE FROM shipping WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 5. Delete related records in invoices (if any)
DELETE FROM invoices WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 6. Delete related records in uploads (if any)
DELETE FROM uploads WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 7. Delete related records in feedback (if any)
DELETE FROM feedback WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- 8. Finally, delete from the orders table
DELETE FROM orders WHERE order_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

-- Commit the transaction if all operations succeed
COMMIT;


ALTER TABLE orders AUTO_INCREMENT = 1;