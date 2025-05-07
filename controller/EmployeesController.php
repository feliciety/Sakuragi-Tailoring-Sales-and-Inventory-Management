
<?php
// Handle Add Employee Action (Quick Add via URL)
if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Check if the user already exists in the employees table
    $checkSql = 'SELECT * FROM employees WHERE user_id = :user_id';
    $stmt = $pdo->prepare($checkSql);
    $stmt->execute([':user_id' => $userId]);
    $existingEmployee = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$existingEmployee) {
        // Insert the user into the employees table with default values
        $insertSql = "INSERT INTO employees (user_id, branch_id, position, department, shift, hire_date, status)
                      VALUES (:user_id, 3, 'Assistant Tailor', 'Printing', 'Morning', CURDATE(), 'Active')";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([':user_id' => $userId]);

        // Update the user's role to 'employee'
        $updateUserSql = "UPDATE users SET role = 'employee' WHERE user_id = :user_id";
        $stmt = $pdo->prepare($updateUserSql);
        $stmt->execute([':user_id' => $userId]);

        // Redirect to refresh the page
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

        // Check if the employees table is empty
        $checkEmptySql = 'SELECT COUNT(*) AS count FROM employees';
        $stmt = $pdo->prepare($checkEmptySql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['count'] == 0) {
            // Reset AUTO_INCREMENT to 1
            $resetAutoIncrementSql = 'ALTER TABLE employees AUTO_INCREMENT = 1';
            $pdo->exec($resetAutoIncrementSql);
        }

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
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $status = $_POST['status'];
    $shift = $_POST['shift']; // Include shift

    // Map branch names to branch IDs
    $branchMap = [
        'Main' => 1,
        'Davao' => 2,
        'Kidapawan' => 3,
        'Tagum' => 4,
    ];

    $branchId = $branchMap[$branchName] ?? null;

    if ($branchId) {
        // Update the employee details in the database
        $updateSql = "UPDATE employees
                      SET position = :position,
                          department = :department,
                          branch_id = :branch_id,
                          status = :status,
                          shift = :shift
                      WHERE user_id = :employee_id";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([
            ':position' => $position,
            ':department' => $department,
            ':branch_id' => $branchId,
            ':status' => $status,
            ':shift' => $shift,
            ':employee_id' => $employeeId,
        ]);

        // Set a success message in the session
        $_SESSION['success_message'] = 'Employee details updated successfully!';

        // Redirect to refresh the page and show the updated table
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<script>alert('Invalid branch selected.');</script>";
        echo "<script>window.location.href = '" . $_SERVER['PHP_SELF'] . "';</script>";
        exit();
    }
}

// ✅ FIXED: Handle Add Employee Details Form Submission (Prevents Duplicates)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id']) && !isset($_POST['employee_id'])) {
    $userId = $_POST['user_id'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $status = $_POST['status'];

    // Map branch names to branch IDs
    $branchMap = [
        'Main' => 1,
        'Davao' => 2,
        'Kidapawan' => 3,
        'Tagum' => 4,
    ];

    $branchId = $branchMap[$branchName] ?? null;

    if ($branchId) {
        // Insert the user into the employees table with the current hire date
        $insertSql = "INSERT INTO employees (user_id, branch_id, position, department, status, hire_date)
                      VALUES (:user_id, :branch_id, :position, :department, :status, CURDATE())";
        $stmt = $pdo->prepare($insertSql);
        $stmt->execute([
            ':user_id' => $userId,
            ':branch_id' => $branchId,
            ':position' => $position,
            ':department' => $department,
            ':status' => $status,
        ]);

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

// Fetch employees
$sql = "SELECT 
            e.user_id AS employee_id,
            u.full_name,
            e.position,
            e.department,
            e.status,
            e.hire_date,
            e.shift,
            b.branch_name
        FROM employees e
        INNER JOIN users u ON e.user_id = u.user_id
        LEFT JOIN branches b ON e.branch_id = b.branch_id
        GROUP BY e.user_id";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch all users
$sql_users = 'SELECT user_id, full_name, email, role, status FROM users';
$stmt_users = $pdo->prepare($sql_users);
$stmt_users->execute();
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);
?>

<script>
    
    function showAddEmployeeModal() {
        document.getElementById('addEmployeeModal').style.display = 'block';
    }

    function closeAddEmployeeModal() {
        document.getElementById('addEmployeeModal').style.display = 'none';
    }

    function addEmployee(userId) {
        // Send a request to the backend to add the user as an employee
        fetch(`?user_id=${userId}`)
            .then(() => {
                // Reload the page to reflect the changes in the table
                window.location.reload();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while adding the employee.');
            });
    }

    function closeAddEmployeeDetailsModal() {
        document.getElementById('addEmployeeDetailsModal').style.display = 'none';
    }

function showEditEmployeeModal(employeeId) {
    const row = document.querySelector(`tr[data-employee-id="${employeeId}"]`);
    const position = row.querySelector('.position').textContent.trim();
    const department = row.querySelector('.department').textContent.trim();
    const branchName = row.querySelector('.branch').textContent.trim();
    const status = row.querySelector('.status').textContent.trim();
    const shift = row.querySelector('.shift').textContent.trim(); // Get shift

    document.getElementById('editEmployeeId').value = employeeId;
    document.getElementById('editPosition').value = position;
    document.getElementById('editDepartment').value = department;
    document.getElementById('editBranch').value = branchName;
    document.getElementById('editStatus').value = status;

    // Set the shift dropdown value
    const shiftDropdown = document.getElementById('editShift');
    if (shiftDropdown) {
        shiftDropdown.value = shift; // Set the dropdown to the correct shift value
    }

    document.getElementById('editEmployeeModal').style.display = 'block';
}

function closeEditEmployeeModal() {
    document.getElementById('editEmployeeModal').style.display = 'none';
}

function showDeleteEmployeeModal(employeeId) {
    window.employeeToDelete = employeeId;
    document.getElementById('deleteEmployeeModal').style.display = 'block';
}

function closeDeleteEmployeeModal() {
    document.getElementById('deleteEmployeeModal').style.display = 'none';
}

function confirmDelete() {
    const employeeId = window.employeeToDelete;
    window.location.href = `?delete_id=${employeeId}`;
}

document.getElementById('editEmployeeForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this);

    fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
        method: 'POST',
        body: formData,
    })
        .then(() => {
            // Refresh the page to show the updated data
            window.location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating employee details.');
        });
});

document.addEventListener('DOMContentLoaded', function () {
    const successMessage = document.getElementById('successMessage');
    if (successMessage) {
        setTimeout(() => {
            successMessage.style.opacity = '0';
            setTimeout(() => {
                successMessage.style.display = 'none'; 
            }, 500); 
        }, 2000); 
    }
});
</script>