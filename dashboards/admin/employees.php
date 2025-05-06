<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../includes/header.php';
require_once __DIR__ . '/../../includes/sidebar_admin.php';
require_once __DIR__ . '/../../controller/admincontroller/employee/employee.php';
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
                    <th onclick="sortTableByColumn('employeeTable', 4)">Status</th>
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
                    <tr><td colspan="6" style="text-align:center;">No employees found.</td></tr>
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
        width: 20%; /* Set the width to 20% */
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

    document.getElementById('editEmployeeId').value = employeeId;
    document.getElementById('editPosition').value = position;
    document.getElementById('editDepartment').value = department;
    document.getElementById('editBranch').value = branchName;
    document.getElementById('editStatus').value = status;

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
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the table row with the new data
                const row = document.querySelector(`tr[data-employee-id="${data.employee_id}"]`);
                row.querySelector('td:nth-child(2)').textContent = data.name; // Update name
                row.querySelector('.position').textContent = data.position;
                row.querySelector('.department').textContent = data.department;
                row.querySelector('.branch').textContent = data.branch_name;
                row.querySelector('.status').textContent = data.status;

                // Close the modal
                closeEditEmployeeModal();
            } else {
                alert('Failed to update employee details: ' + (data.error || 'Unknown error.'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating employee details.');
        });
});
</script>
<?php require_once '../../includes/footer.php'; ?>
