<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
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
                    <option value="hired">Hired</option>
                    <option value="absent">Absent</option>
                </select>
            </div>
        </div>

        <button onclick="exportTableToCSV('employeeTable', 'employees.csv')" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
        <!-- Add Employee button (shows modal or redirects to add page) -->
        <button onclick="showAddEmployeeModal()" class="btn-add">
            <i class="fas fa-user-plus"></i> Add Employee
        </button>
    </div>

    <div class="table-responsive">
        <table id="employeeTable">
            <thead>
                <tr>
                    <th onclick="sortTableByColumn('employeeTable', 0)">Name</th>
                    <th onclick="sortTableByColumn('employeeTable', 1)">Position</th>
                    <th onclick="sortTableByColumn('employeeTable', 2)">Department</th>
                    <th onclick="sortTableByColumn('employeeTable', 3)">Branch</th>
                    <th onclick="sortTableByColumn('employeeTable', 4)">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && $result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php if (!empty($row['avatar_path'])): ?>
                                    <img src="<?= htmlspecialchars($row['avatar_path']) ?>" class="avatar">
                                <?php else: ?>
                                    <img src="/assets/images/default_avatar.png" class="avatar">
                                <?php endif; ?>
                                <?= htmlspecialchars($row['name']) ?>
                            </td>
                            <td><?= htmlspecialchars($row['role']) ?></td>
                            <td><?= htmlspecialchars($row['department_name']) ?></td>
                            <td><?= htmlspecialchars($row['branch_name']) ?></td>
                            <td>
                                <span class="status <?= strtolower($row['status']) ?>">
                                    <?= htmlspecialchars(ucfirst($row['status'])) ?>
                                </span>
                            </td>
                            <td class="action-buttons">
                                <button class="edit" onclick="showEditEmployeeModal(<?= $row['id'] ?>)">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="delete" onclick="confirmDeleteEmployee(<?= $row['id'] ?>)">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="6" style="text-align:center;">No employees found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Add/Edit Employee Modal (scaffold only, implement logic as needed) -->
<div id="employeeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close" onclick="closeEmployeeModal()">&times;</span>
        <form id="employeeForm" method="post" enctype="multipart/form-data" action="employee_save.php">
            <input type="hidden" name="employee_id" id="employee_id" value="">
            <label>Name: <input type="text" name="name" id="emp_name" required></label>
            <label>Email: <input type="email" name="email" id="emp_email" required></label>
            <label>Role:
                <select name="role" id="emp_role" required>
                    <option value="Tailor">Tailor</option>
                    <option value="Customer Support">Customer Support</option>
                    <option value="Manager">Manager</option>
                </select>
            </label>
            <label>Department: <input type="text" name="department" id="emp_dept"></label>
            <label>Branch: <input type="text" name="branch" id="emp_branch"></label>
            <label>Status:
                <select name="status" id="emp_status" required>
                    <option value="active">Active</option>
                    <option value="hired">Hired</option>
                    <option value="absent">Absent</option>
                </select>
            </label>
            <label>Avatar:
                <input type="file" name="avatar" id="emp_avatar" accept="image/*">
            </label>
            <button type="submit">Save</button>
        </form>
    </div>
</div>

<!-- Table and Modal JS, CSV Export -->
<script src="/assets/js/tables.js"></script>
<script>
// Add/Edit modal logic
function showAddEmployeeModal() {
    document.getElementById('employeeForm').reset();
    document.getElementById('employee_id').value = '';
    document.getElementById('employeeModal').style.display = "block";
}
function showEditEmployeeModal(id) {
    // TODO: Fetch employee details via AJAX and fill the form
    // For now, just show modal (implement AJAX for real data)
    document.getElementById('employeeModal').style.display = "block";
}
function closeEmployeeModal() {
    document.getElementById('employeeModal').style.display = "none";
}
function confirmDeleteEmployee(id) {
    if (confirm('Are you sure you want to delete this employee?')) {
        window.location.href = 'employee_delete.php?id=' + id;
    }
}
</script>
<?php require_once '../../includes/footer.php'; ?>
