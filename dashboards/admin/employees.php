<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../includes/header.php';

// Handle Edit Employee Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    $employeeId = $_POST['employee_id'];
    $position = $_POST['position'];
    $department = $_POST['department'];
    $branchName = $_POST['branch_name'];
    $status = $_POST['status'];

    // Update the employee details in the database
    $updateSql = "UPDATE employees e
                  JOIN branches b ON e.branch_id = b.branch_id
                  SET e.position = :position,
                      e.department = :department,
                      b.branch_name = :branch_name,
                      e.status = :status
                  WHERE e.user_id = :employee_id";

    $stmt = $pdo->prepare($updateSql);
    $stmt->execute([
        ':position' => $position,
        ':department' => $department,
        ':branch_name' => $branchName,
        ':status' => $status,
        ':employee_id' => $employeeId,
    ]);

    // Redirect to the same page to avoid form resubmission
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit();
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

<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<main class="main-content">
    <h1>Manage Employees</h1>

    <div class="table-controls">
        <div class="filters">
            <div class="input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search employees..." class="table-search"
                    onkeyup="filterTableBySearch('searchInput', 'employeeTable')">
            </div>
            <div class="select-wrapper">
                <i class="fas fa-filter"></i>
                <select id="statusFilter" class="table-filter"
                    onchange="filterTableByStatus('statusFilter', 'employeeTable')">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="resigned">Resigned</option>
                    <option value="terminated">Terminated</option>
                </select>
            </div>
        </div>
        <button onclick="exportTableToCSV('inventoryTable', 'inventory.csv')" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
        <button onclick="showAddEmployeeModal()" class="btn-export">
            <i class="fas fa-user-plus"></i> Add Employee
        </button>
    </div>

    <div class="table-responsive">
        <table id="employeeTable">
            <thead>
                <tr>
                    <th onclick="sortTableByColumn('employeeTable', 0)">Employee ID</th>
                    <th onclick="sortTableByColumn('employeeTable', 1)">Name</th>
                    <th onclick="sortTableByColumn('employeeTable', 2)">Position</th>
                    <th onclick="sortTableByColumn('employeeTable', 3)">Department</th>
                    <th onclick="sortTableByColumn('employeeTable', 4)">Branch</th>
                    <th onclick="sortTableByColumn('employeeTable', 5)">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && count($result) > 0): ?>
                    <?php foreach ($result as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['employee_id']) ?></td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['position'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($row['department'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($row['branch_name'] ?? '—') ?></td>
                            <td>
                                <span class="status <?= strtolower($row['status'] ?? 'inactive') ?>">
                                    <?= htmlspecialchars($row['status'] ?? 'Inactive') ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <button class="edit" onclick="showEditEmployeeModal(<?= $row['employee_id'] ?>)">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete" onclick="showDeleteEmployeeModal(<?= $row['employee_id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align:center;">No employees found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Modal to Add Employee -->
<div id="addEmployeeModal" class="table-responsive" style="display:none;">
    <div class="modal-content">
        <span onclick="closeAddEmployeeModal()">[Close]</span>
        <h2>Select a User to Add as Employee</h2>
        <div>
            <table id="usersTable" border="1">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php if ($user['role'] === 'customer'):// Only include customers
                             ?>
                            <tr>
                                <td><?= htmlspecialchars($user['user_id']) ?></td>
                                <td><?= htmlspecialchars($user['full_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['status']) ?></td>
                                <td>
                                    <button onclick="addEmployee(<?= $user['user_id'] ?>)">
                                        Add as Employee
                                    </button>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add/Edit/Delete Modals -->
<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span onclick="closeEditEmployeeModal()">[Close]</span>
        <h2>Edit Employee</h2>
        <form id="editEmployeeForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" id="editEmployeeId" name="employee_id">
            <div>
                <label for="editPosition">Position:</label>
                <input type="text" id="editPosition" name="position" required>
            </div>
            <div>
                <label for="editDepartment">Department:</label>
                <input type="text" id="editDepartment" name="department" required>
            </div>
            <div>
                <label for="editBranch">Branch:</label>
                <input type="text" id="editBranch" name="branch_name" required>
            </div>
            <div>
                <label for="editStatus">Status:</label>
                <select id="editStatus" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Resigned">Resigned</option>
                    <option value="Terminated">Terminated</option>
                </select>
            </div>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</div>

<div id="deleteEmployeeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span onclick="closeDeleteEmployeeModal()">[Close]</span>
        <h2>Delete Employee</h2>
        <p>Are you sure you want to delete this employee?</p>
        <div>
            <button onclick="confirmDelete()">Yes, Delete</button>
            <button onclick="closeDeleteEmployeeModal()">Cancel</button>
        </div>
    </div>
</div>

<script>
function showAddEmployeeModal() {
    document.getElementById('addEmployeeModal').style.display = 'block';
}

function closeAddEmployeeModal() {
    document.getElementById('addEmployeeModal').style.display = 'none';
}

function confirmDeleteEmployee(id) {
    if (confirm('Are you sure you want to delete this employee?')) {
        window.location.href = 'employee_delete.php?id=' + id;
    }
}

function showEditEmployeeModal(employeeId) {
    // Populate the modal with employee data (you'll need to fetch this data via AJAX or pass it in)
    document.getElementById('editEmployeeId').value = employeeId;
    // Example: Fetch data and populate fields (replace with actual implementation)
    // fetchEmployeeData(employeeId);

    document.getElementById('editEmployeeModal').style.display = 'block';
}

function closeEditEmployeeModal() {
    document.getElementById('editEmployeeModal').style.display = 'none';
}

function showDeleteEmployeeModal(employeeId) {
    // Store the employee ID for deletion
    window.employeeToDelete = employeeId;
    document.getElementById('deleteEmployeeModal').style.display = 'block';
}

function closeDeleteEmployeeModal() {
    document.getElementById('deleteEmployeeModal').style.display = 'none';
}

function confirmDelete() {
    // Redirect to delete endpoint with the employee ID
    window.location.href = 'employee_delete.php?id=' + window.employeeToDelete;
}
</script>
<?php require_once '../../includes/footer.php'; ?>
