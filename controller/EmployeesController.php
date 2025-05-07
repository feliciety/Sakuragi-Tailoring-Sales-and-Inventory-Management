<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />';
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


<!-- Custom CSS -->
<style>
    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 5% auto;
        padding: 20px;
        border-radius: 8px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Specific styling for the Add Employee Modal */
    #addEmployeeModal .modal-content {
        width: 70%; /* Set the width to 70% of the screen */
        max-width: none; /* Remove the max-width constraint */
    }

    .modal-title {
        font-size: 24px;
        margin-bottom: 20px;
        text-align: center;
        color: #333;
    }

    .close-btn {
        float: right;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
    }

    .close-btn:hover {
        color: #ff0000;
    }

    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f4f4f4;
        font-weight: bold;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 8px 12px;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .form-group {
        margin-bottom: 15px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    select, input[type="text"], button {
        width: 100%;
        padding: 8px;
        border: 1px solid #ddd;
        border-radius: 4px;
        font-size: 14px;
    }

    button {
        cursor: pointer;
    }

    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Responsive Table */
    @media (max-width: 768px) {
        table {
            font-size: 12px;
        }

        th, td {
            padding: 5px;
        }
    }

    /* Style for the button container */
    .table-controls .button-group {
        display: flex;
        justify-content: flex-end; /* Align buttons to the right */
        gap: 20px; /* Add a gap of 20px between the buttons */
        margin-top: 10px; /* Add some spacing above the buttons */
    }

    /* Style for the buttons */
    .table-controls .btn-export {
        width: 10%; /* Set the width to 20% */
        padding: 10px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 14px;
        text-align: center;
    }

    .table-controls .btn-export:hover {
        background-color: #0056b3;
    }

    .success-message {
        background-color: rgb(63, 190, 92); /* Green background */
        color: #fff; /* White text */
        padding: 15px;
        text-align: center;
        border-radius: 100px;
        position: fixed;
        top: 100px;
        left: 50%;
        transform: translateX(-50%);
        z-index: 1000;
        width: 20%;
        max-width: 600px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        opacity: 1; /* Fully visible */
        transition: opacity 0.5s ease-in-out; /* Smooth fade-out */
    }
</style>

<!-- Custom JavaScript -->
<script>
    function showAddEmployeeModal() {
        document.getElementById('addEmployeeModal').style.display = 'block';
    }

    function closeAddEmployeeModal() {
        document.getElementById('addEmployeeModal').style.display = 'none';
    }

    function addEmployee(userId) {
        document.getElementById('addEmployeeUserId').value = userId;
        document.getElementById('addEmployeeDetailsModal').style.display = 'block';
    }

    function closeAddEmployeeDetailsModal() {
        document.getElementById('addEmployeeDetailsModal').style.display = 'none';
    }
</script>

<script>
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
