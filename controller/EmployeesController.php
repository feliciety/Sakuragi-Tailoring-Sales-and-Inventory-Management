<?php
require_once __DIR__ . '/../config/db_connect.php'; // for controller


$branchMap = [
    'Main' => 1,
    'Davao' => 2,
    'Kidapawan' => 3,
    'Tagum' => 4,
];

// DELETE EMPLOYEE
if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    $employeeId = $_POST['employee_id'];

    try {
        // Delete employee
        $stmt = $pdo->prepare("DELETE FROM employees WHERE user_id = :employee_id");
        $stmt->execute(['employee_id' => $employeeId]);

        // Revert user role
        $stmt = $pdo->prepare("UPDATE users SET role = 'customer' WHERE user_id = :employee_id");
        $stmt->execute(['employee_id' => $employeeId]);

        $_SESSION['success_message'] = 'Employee deleted and reverted to customer.';
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error deleting employee: ' . $e->getMessage();
    }

    header('Location: ../dashboards/admin/employees.php');
    exit();
}

// ADD EMPLOYEE
if (isset($_POST['action']) && $_POST['action'] === 'add') {
    $full_name = $_POST['full_name'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $shift = $_POST['shift'];
    $status = $_POST['status'];

    $branchId = $branchMap[$branchName] ?? null;
    $email = strtolower(str_replace(' ', '', $full_name)) . rand(100, 999) . '@sakuragi.com';
    $password = password_hash('123456', PASSWORD_DEFAULT);
    $phone = '09' . rand(100000000, 999999999);

    try {
        // Insert into users
        $stmt = $pdo->prepare("INSERT INTO users (branch_id, full_name, email, password, phone_number, role, status) 
                               VALUES (:branch_id, :full_name, :email, :password, :phone, 'employee', 'Active')");
        $stmt->execute([
            'branch_id' => $branchId,
            'full_name' => $full_name,
            'email' => $email,
            'password' => $password,
            'phone' => $phone,
        ]);

        $userId = $pdo->lastInsertId();

        // Insert into employees
        $stmt = $pdo->prepare("INSERT INTO employees (user_id, branch_id, position, department, shift, hire_date, status, salary) 
                               VALUES (:user_id, :branch_id, :position, :department, :shift, CURDATE(), :status, 0)");
        $stmt->execute([
            'user_id' => $userId,
            'branch_id' => $branchId,
            'position' => $position,
            'department' => $department,
            'shift' => $shift,
            'status' => $status,
        ]);

        $_SESSION['success_message'] = 'Employee added successfully.';
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error adding employee: ' . $e->getMessage();
    }

    header('Location: ../dashboards/admin/employees.php');
    exit();
}

// EDIT EMPLOYEE
if (isset($_POST['action']) && $_POST['action'] === 'edit') {
    $employeeId = $_POST['employee_id'];
    $full_name = $_POST['full_name'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $shift = $_POST['shift'];
    $status = $_POST['status'];
    $branchId = $branchMap[$branchName] ?? null;

    try {
        // Update employee table
        $stmt = $pdo->prepare("UPDATE employees 
                               SET position = :position, department = :department, branch_id = :branch_id, shift = :shift, status = :status 
                               WHERE user_id = :employee_id");
        $stmt->execute([
            'position' => $position,
            'department' => $department,
            'branch_id' => $branchId,
            'shift' => $shift,
            'status' => $status,
            'employee_id' => $employeeId,
        ]);

        // Update user name and branch
        $stmt = $pdo->prepare("UPDATE users SET full_name = :full_name, branch_id = :branch_id WHERE user_id = :employee_id");
        $stmt->execute([
            'full_name' => $full_name,
            'branch_id' => $branchId,
            'employee_id' => $employeeId,
        ]);

        $_SESSION['success_message'] = 'Employee updated successfully.';
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Error updating employee: ' . $e->getMessage();
    }

    header('Location: ../dashboards/admin/employees.php');
    exit();
}
