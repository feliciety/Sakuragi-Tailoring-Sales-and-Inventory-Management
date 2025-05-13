-- Start a transaction to ensure all deletes succeed or none do
START TRANSACTION;

-- 1. Delete related records in order_details
DELETE FROM order_details WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 2. Delete related records in payments (if any)
DELETE FROM payments WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 3. Delete related records in order_workflow (if any)
DELETE FROM order_workflow WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 4. Delete related records in shipping (if any)
DELETE FROM shipping WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 5. Delete related records in invoices (if any)
DELETE FROM invoices WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 6. Delete related records in uploads (if any)
DELETE FROM uploads WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 7. Delete related records in feedback (if any)
DELETE FROM feedback WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- 8. Finally, delete from the orders table
DELETE FROM orders WHERE order_id IN (20, 21, 22, 23, 24, 25, 26, 27, 28);

-- Commit the transaction if all operations succeed
COMMIT;
