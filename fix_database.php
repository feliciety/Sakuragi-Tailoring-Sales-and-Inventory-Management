<?php
// This script fixes the database by executing the SQL file

// Include database connection
require_once __DIR__ . '/config/db_connect.php';

echo '<h1>Database Fix Utility</h1>';

// Read the SQL file
$sqlFile = __DIR__ . '/config/fix_database.sql';

if (!file_exists($sqlFile)) {
    die('SQL file not found: ' . $sqlFile);
}

$sql = file_get_contents($sqlFile);

// Split SQL file into individual statements
$statements = explode(';', $sql);

echo '<div style="font-family: monospace; padding: 20px; background: #f5f5f5; border: 1px solid #ddd; max-height: 400px; overflow-y: auto;">';

// Execute each statement
$successCount = 0;
$errorCount = 0;

foreach ($statements as $statement) {
    $statement = trim($statement);

    if (empty($statement)) {
        continue;
    }

    try {
        $pdo->exec($statement);
        echo '<p style="color: green;">✓ Success: ' . htmlspecialchars(substr($statement, 0, 100)) . '...</p>';
        $successCount++;
    } catch (PDOException $e) {
        echo '<p style="color: red;">✗ Error: ' .
            htmlspecialchars($e->getMessage()) .
            '<br>Statement: ' .
            htmlspecialchars(substr($statement, 0, 100)) .
            '...</p>';
        $errorCount++;
    }
}

echo '</div>';

// Show summary
echo '<div style="margin-top: 20px; padding: 10px; background: #eef; border: 1px solid #ddf;">';
echo '<h2>Summary</h2>';
echo '<p>Total statements processed: ' . ($successCount + $errorCount) . '</p>';
echo '<p>Successful: ' . $successCount . '</p>';
echo '<p>Failed: ' . $errorCount . '</p>';

if ($errorCount === 0) {
    echo '<div style="margin-top: 20px; padding: 10px; background: #dfd; border: 1px solid #afa;">';
    echo '<h3 style="color: green;">Database Fix Complete!</h3>';
    echo '<p>Your database structure has been updated successfully.</p>';
    echo '</div>';
}
echo '</div>';

echo '<p style="margin-top: 20px;"><a href="dashboards/customer/my_orders.php" style="display: inline-block; padding: 10px 20px; background: #0B5CF9; color: white; text-decoration: none; border-radius: 5px;">Go to My Orders</a></p>';
?>
