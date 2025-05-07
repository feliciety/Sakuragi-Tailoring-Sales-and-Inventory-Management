<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
require_once __DIR__ . '/../../controller/EmployeesController.php';
?>

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
        <button onclick="exportTableToCSV('inventoryTable', 'employee.csv')" class="btn-export">
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
                    <th onclick="sortTableByColumn('employeeTable', 0)">Name</th>
                    <th onclick="sortTableByColumn('employeeTable', 1)">Position</th>
                    <th onclick="sortTableByColumn('employeeTable', 2)">Department</th>
                    <th onclick="sortTableByColumn('employeeTable', 3)">Branch</th>
                    <th onclick="sortTableByColumn('employeeTable', 4)">Hire Date</th>
                    <th onclick="sortTableByColumn('employeeTable', 5)">Shift</th> <!-- Shift Column -->
                    <th onclick="sortTableByColumn('employeeTable', 6)">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && count($result) > 0): ?>
                    <?php foreach ($result as $row): ?>
                        <tr data-employee-id="<?= htmlspecialchars($row['employee_id']) ?>">
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td class="position"><?= htmlspecialchars($row['position'] ?? '—') ?></td>
                            <td class="department"><?= htmlspecialchars($row['department'] ?? '—') ?></td>
                            <td class="branch"><?= htmlspecialchars($row['branch_name'] ?? '—') ?></td>
                            <td><?= htmlspecialchars($row['hire_date']) ?></td>
                            <td class="shift"><?= htmlspecialchars($row['shift'] ?? '—') ?></td> 
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
                    <tr><td colspan="8" style="text-align:center;">No employees found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Add Employee Modal -->
<div id="addEmployeeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeAddEmployeeModal()">×</span>
        <h2 class="modal-title">Select a User to Add as Employee</h2>
        <div class="table-responsive">
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <?php if ($user['role'] === 'customer'): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['full_name']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td><?= htmlspecialchars($user['role']) ?></td>
                                <td><?= htmlspecialchars($user['status']) ?></td>
                                <td>
                                    <button class="btn-primary" onclick="addEmployee(<?= $user['user_id'] ?>)">
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

<!-- Add Employee Modal -->
<div id="addEmployeeDetailsModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span onclick="closeAddEmployeeDetailsModal()">[Close]</span>
        <h2>Add Employee Details</h2>
        <form id="addEmployeeDetailsForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" id="addEmployeeUserId" name="user_id">
            <div>
                <label for="addPosition">Position:</label>
                <select id="addPosition" name="position" required>
                    <option value="Tailor">Tailor</option>
                    <option value="Senior Tailor">Senior Tailor</option>
                    <option value="Assistant Tailor">Assistant Tailor</option>
                    <option value="Quality Checker">Quality Checker</option>
                </select>
            </div>
            <div>
                <label for="addDepartment">Department:</label>
                <select id="addDepartment" name="department" required>
                    <option value="Tailoring">Tailoring</option>
                    <option value="Printing">Printing</option>
                    <option value="Customer Service">Customer Service</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div>
                <label for="addBranch">Branch:</label>
                <select id="addBranch" name="branch_name" required>
                    <option value="Main">Main</option>
                    <option value="Davao">Davao</option>
                    <option value="Kidapawan">Kidapawan</option>
                    <option value="Tagum">Tagum</option>
                </select>
            </div>
            <div>
                <label for="addStatus">Status:</label>
                <select id="addStatus" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Resigned">Resigned</option>
                    <option value="Terminated">Terminated</option>
                </select>
            </div>
            <div>
                <label for="addShift">Shift:</label>
                <select id="addShift" name="shift" required>
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
            <button type="submit">Add Employee</button>
        </form>
    </div>
</div>

<!-- Edit Employee Modal -->
<div id="editEmployeeModal" class="modal" style="display:none;">
    <div class="modal-content">
        <span class="close-btn" onclick="closeEditEmployeeModal()">×</span>
        <h2 class="modal-title">Edit Employee</h2>
        <form id="editEmployeeForm" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" id="editEmployeeId" name="employee_id">
            <div class="form-group">
                <label for="editPosition">Position:</label>
                <select id="editPosition" name="position" required>
                    <option value="Tailor">Tailor</option>
                    <option value="Senior Tailor">Senior Tailor</option>
                    <option value="Assistant Tailor">Assistant Tailor</option>
                    <option value="Quality Checker">Quality Checker</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editDepartment">Department:</label>
                <select id="editDepartment" name="department" required>
                    <option value="Tailoring">Tailoring</option>
                    <option value="Printing">Printing</option>
                    <option value="Customer Service">Customer Service</option>
                    <option value="Admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editBranch">Branch:</label>
                <select id="editBranch" name="branch_name" required>
                    <option value="Main">Main</option>
                    <option value="Davao">Davao</option>
                    <option value="Kidapawan">Kidapawan</option>
                    <option value="Tagum">Tagum</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editShift">Shift:</label>
                <select id="editShift" name="shift" required>
                    <option value="Morning">Morning</option>
                    <option value="Afternoon">Afternoon</option>
                    <option value="Evening">Evening</option>
                </select>
            </div>
            <div class="form-group">
                <label for="editStatus">Status:</label>
                <select id="editStatus" name="status" required>
                    <option value="Active">Active</option>
                    <option value="Resigned">Resigned</option>
                    <option value="Terminated">Terminated</option>
                </select>
            </div>
            <button type="submit" class="btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<!-- Delete Employee Modal -->
<div id="deleteEmployeeModal" class="modal"">
    <div class="modal-content">
        <span onclick="closeDeleteEmployeeModal()">[Close]</span>
        <h2>Delete Employee</h2>
        <p>Are you sure you want to delete this employee? This will revert them back to a customer.</p>
        <div>
            <button onclick="confirmDelete()">Yes, Delete</button>
            <button onclick="closeDeleteEmployeeModal()">Cancel</button>
        </div>
    </div>
</div>

<?php if (isset($_SESSION['success_message'])): ?>
    <div id="successMessage" class="success-message">
        <?= htmlspecialchars($_SESSION['success_message']) ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<?php require_once '../../includes/footer.php'; ?>
