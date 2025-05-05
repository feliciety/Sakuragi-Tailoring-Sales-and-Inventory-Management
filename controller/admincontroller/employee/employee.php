<?php
// Handle Add Employee Action
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Check if the user already exists in the employees table
    $checkSql = 'SELECT * FROM employees WHERE user_id = :user_id';
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([':user_id' => $userId]);
    $existingEmployee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingEmployee) {
        // Insert the user into the employees table
        $insertSql = "INSERT INTO employees (user_id, branch_id, position, department, shift, hire_date, salary, status)
                      VALUES (:user_id, NULL, 'New Employee', 'Admin', 'Morning', CURDATE(), 0.00, 'Active')";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([':user_id' => $userId]);

        // Update the user's role to 'employee'
        $updateUserSql = "UPDATE users SET role = 'employee' WHERE user_id = :user_id";
        $stmt = $pdo->prepare($updateUserSql);
        $stmt->execute([':user_id' => $userId]);

        // Redirect to avoid duplicate actions
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('This user is already an employee.');</script>";
    }
}

// Handle Delete Employee Action
if (isset($_GET['delete_id'])) {
    $employeeId = $_GET['delete_id'];

    try {
        // Delete the employee from the employees table
        $deleteSql = 'DELETE FROM employees WHERE user_id = :employee_id';
        $stmt = $pdo->prepare($deleteSql);
        $stmt->execute([':employee_id' => $employeeId]);

        // Update the user's role to 'customer'
        $updateUserSql = 'UPDATE users SET role = "customer" WHERE user_id = :employee_id';
        $stmt = $pdo->prepare($updateUserSql);
        $stmt->execute([':employee_id' => $employeeId]);

        // Redirect to refresh the page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } catch (PDOException $e) {
        echo "<script>alert('Failed to delete employee: " . $e->getMessage() . "');</script>";
    }
}

// Handle Edit Employee Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    $employeeId = $_POST['employee_id'];
    $name = $_POST['name'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $status = $_POST['status'];

    // Update the employee details in the database
    $updateSql = "UPDATE employees e
                  JOIN branches b ON e.branch_id = b.branch_id
                  JOIN users u ON e.user_id = u.user_id
                  SET u.full_name = :name,
                      e.position = :position,
                      e.department = :department,
                      e.status = :status
                  WHERE e.user_id = :employee_id";

    $stmt = $pdo->prepare($updateSql);
    try {
        $stmt->execute([
            ':name' => $name,
            ':position' => $position,
            ':department' => $department,
            ':status' => $status,
            ':employee_id' => $employeeId,
        ]);

        echo json_encode([
            'success' => true,
            'employee_id' => $employeeId,
            'name' => $name,
            'position' => $position,
            'department' => $department,
            'status' => $status,
        ]);
    } catch (PDOException $e) {
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage(),
        ]);
    }
    exit();
}

// Handle Add Employee Details Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $status = $_POST['status'];

    // Get the branch ID based on the branch name
    $branchSql = 'SELECT branch_id FROM branches WHERE branch_name = :branch_name';
    $stmt = $pdo->prepare($branchSql);
    $stmt->execute([':branch_name' => $branchName]);
    $branch = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($branch) {
        $branchId = $branch['branch_id'];

        // Insert the user into the employees table
        $insertSql = "INSERT INTO employees (user_id, branch_id, position, department, status)
                      VALUES (:user_id, :branch_id, :position, :department, :status)";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([
            ':user_id' => $userId,
            ':branch_id' => $branchId,
            ':position' => $position,
            ':department' => $department,
            ':status' => $status,
        ]);

        // Fetch the newly generated employee_id
        $employeeId = $pdo->lastInsertId();

        // Update the user's role to 'employee'
        $updateUserSql = "UPDATE users SET role = 'employee' WHERE user_id = :user_id";
        $stmt = $pdo->prepare($updateUserSql);
        $stmt->execute([':user_id' => $userId]);

        // Redirect to refresh the page
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Invalid branch selected.');</script>";
    }
}

// Fetch employees and users data
$sql = "SELECT 
            u.user_id AS employee_id,   
            u.full_name,
            u.email,
            u.role,
            e.position,
            e.department,
            e.status,
            b.branch_name
        FROM users u
        LEFT JOIN employees e ON u.user_id = e.user_id  
        LEFT JOIN branches b ON e.branch_id = b.branch_id
        WHERE u.role = 'employee'";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql_users = 'SELECT user_id, full_name, email, role, status FROM users';
$stmt_users = $pdo->prepare($sql_users);
$stmt_users->execute();
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

?>
