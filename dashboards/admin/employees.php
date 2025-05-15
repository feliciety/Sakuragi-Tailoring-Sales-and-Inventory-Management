<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once __DIR__ . '/../../config/db_connect.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
require_once __DIR__ . '/../../controller/EmployeesController.php';

// Fetch employee list
try {
    $stmt = $pdo->prepare("
        SELECT 
            e.user_id AS employee_id,
            u.full_name,
            e.position,
            e.department,
            e.status,
            e.hire_date,
            e.shift,
            b.branch_name
        FROM employees e
        JOIN users u ON e.user_id = u.user_id
        LEFT JOIN branches b ON e.branch_id = b.branch_id
        ORDER BY u.full_name ASC
    ");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $result = [];
    error_log('DB error: ' . $e->getMessage());
}
?>

<link rel="stylesheet" href="/../public/assets/css/adminEmployee.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<main class="main-content">
  <h1>Manage Employees</h1>
  
  <div class="table-controls">
<div class="search-wrapper">
  <input type="text" id="employeeSearch" placeholder="Search employee..." onkeyup="filterEmployeeTable()" />
</div>

<button onclick="downloadCSV()" class="btn-export">
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
          <th>Name</th><th>Position</th><th>Department</th><th>Branch</th>
          <th>Hire Date</th><th>Shift</th><th>Status</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result):
            foreach ($result as $row): ?>
          <tr data-employee-id="<?= $row['employee_id'] ?>">
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= $row['position'] ?></td>
            <td><?= $row['department'] ?></td>
            <td><?= $row['branch_name'] ?></td>
            <td><?= $row['hire_date'] ?></td>
            <td><?= $row['shift'] ?></td>
            <td><span class="status <?= strtolower($row['status']) ?>"><?= $row['status'] ?></span></td>
            <td class="action-buttons">
              <button class="edit" onclick="showEditEmployeeModal(<?= $row['employee_id'] ?>)">
                <i class="fas fa-pen"></i>
              </button>
              <button class="delete" onclick="showDeleteEmployeeModal(<?= $row['employee_id'] ?>)">
                <i class="fas fa-trash"></i>
              </button>
            </td>
          </tr>
        <?php endforeach;
        else:
             ?>
          <tr><td colspan="8" style="text-align:center;">No employees found.</td></tr>
        <?php
        endif; ?>
      </tbody>
    </table>
  </div>
</main>


<!-- Add Modal -->
<div id="addEmployeeModal" class="modal add">
  <div class="modal-content">
    <span class="close-btn" onclick="closeAddEmployeeModal()">×</span>
    <h2 class="modal-title">Add New Employee</h2>
    <p class="modal-subtext">Fill in the fields to create a new employee profile.</p>
    <form method="POST" action="../../controller/EmployeesController.php">
      <input type="hidden" name="action" value="add">
      <label>Full Name</label>
      <input type="text" name="full_name" placeholder="e.g. Jane Doe" required>
        <label>Position</label>
            <select name="position" required>
                <option value=""> Select Position </option>
                <option value="Tailor">Tailor</option>
                <option value="Senior Tailor">Senior Tailor</option>
                <option value="Alteration Specialist">Alteration Specialist</option>
                <option value="Pattern Maker">Pattern Maker</option>
                <option value="Sublimation Technician">Sublimation Technician</option>
                <option value="Screen Printing Operator">Screen Printing Operator</option>
                <option value="Print Finisher">Print Finisher</option>
                <option value="Embroidery Machine Operator">Embroidery Machine Operator</option>
                <option value="Embroidery Technician">Embroidery Technician</option>
                <option value="Quality Control Inspector">Quality Control Inspector</option>
                <option value="Packing Staff">Packing Staff</option>
                <option value="Production Staff">Production Staff</option>
                <option value="Shop Assistant">Shop Assistant</option>
                <option value="Floor Supervisor">Floor Supervisor</option>
                <option value="Inventory Clerk">Inventory Clerk</option>
                <option value="Admin Assistant">Admin Assistant</option>
                <option value="HR Staff">HR Staff</option>
                <option value="Accountant">Accountant</option>
                <option value="Operations Manager">Operations Manager</option>
            </select>

      <label>Department</label>
      <select name="department" required>
        <option value="">Select</option>
        <option value="Tailoring">Tailoring</option>
        <option value="Printing">Printing</option>
        <option value="Customer Service">Customer Service</option>
        <option value="Admin">Admin</option>
      </select>
      <label>Branch</label>
      <select name="branch_name" required>
        <option value="">Select</option>
        <option value="Main">Main</option>
        <option value="Davao">Davao</option>
        <option value="Kidapawan">Kidapawan</option>
        <option value="Tagum">Tagum</option>
      </select>
      <label>Shift</label>
      <select name="shift" required>
        <option value="">Select</option>
        <option value="Morning">Morning</option>
        <option value="Afternoon">Afternoon</option>
        <option value="Night">Night</option>
      </select>
      <label>Status</label>
      <select name="status" required>
        <option value="Active">Active</option>
        <option value="Resigned">Resigned</option>
        <option value="Terminated">Terminated</option>
      </select>
      <div class="modal-button-group">
        <button type="submit" class="btn-primary">Save</button>
        <button type="button" onclick="closeAddEmployeeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Edit Modal -->
<div id="editEmployeeModal" class="modal edit">
  <div class="modal-content">
    <span class="close-btn" onclick="closeEditEmployeeModal()">×</span>
    <h2 class="modal-title">Edit Employee</h2>
    <form method="POST" action="../../controller/EmployeesController.php">
      <input type="hidden" name="action" value="edit">
      <input type="hidden" id="editEmployeeId" name="employee_id">
      <label>Full Name</label>
      <input type="text" id="editFullName" name="full_name" required>
      <label>Position</label>
      <input type="text" id="editPosition" name="position" required>
      <label>Department</label>
      <select id="editDepartment" name="department" required>
        <option value="Tailoring">Tailoring</option>
        <option value="Printing">Printing</option>
        <option value="Customer Service">Customer Service</option>
        <option value="Admin">Admin</option>
      </select>
      <label>Branch</label>
      <select id="editBranch" name="branch_name" required>
        <option value="Main">Main</option>
        <option value="Davao">Davao</option>
        <option value="Kidapawan">Kidapawan</option>
        <option value="Tagum">Tagum</option>
      </select>
      <label>Shift</label>
      <select id="editShift" name="shift" required>
        <option value="Morning">Morning</option>
        <option value="Afternoon">Afternoon</option>
        <option value="Night">Night</option>
      </select>
      <label>Status</label>
      <select id="editStatus" name="status" required>
        <option value="Active">Active</option>
        <option value="Resigned">Resigned</option>
        <option value="Terminated">Terminated</option>
      </select>
      <div class="modal-button-group">
        <button type="submit" class="btn-primary">Update</button>
        <button type="button" onclick="closeEditEmployeeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<!-- Delete Modal -->
<div id="deleteEmployeeModal" class="modal delete">
  <div class="modal-content">
    <span class="close-btn" onclick="closeDeleteEmployeeModal()">×</span>
    <h2 class="modal-title">Confirm Deletion</h2>
    <form method="POST" action="../../controller/EmployeesController.php">
      <input type="hidden" name="action" value="delete">
      <input type="hidden" id="deleteEmployeeId" name="employee_id">
      <p>This will remove the employee and revert their account to customer. Proceed?</p>
      <div class="modal-button-group">
        <button type="submit" class="btn-primary">Delete</button>
        <button type="button" onclick="closeDeleteEmployeeModal()">Cancel</button>
      </div>
    </form>
  </div>
</div>

<?php require_once '../../includes/footer.php'; ?>

<script>
function showAddEmployeeModal() {
  document.getElementById('addEmployeeModal').style.display = 'flex';
}
function closeAddEmployeeModal() {
  document.getElementById('addEmployeeModal').style.display = 'none';
}
function showEditEmployeeModal(id) {
  const row = document.querySelector(`tr[data-employee-id="${id}"]`);
  document.getElementById('editEmployeeId').value = id;
  document.getElementById('editFullName').value = row.cells[0].textContent.trim();
  document.getElementById('editPosition').value = row.cells[1].textContent.trim();
  document.getElementById('editDepartment').value = row.cells[2].textContent.trim();
  document.getElementById('editBranch').value = row.cells[3].textContent.trim();
  document.getElementById('editShift').value = row.cells[5].textContent.trim();
  document.getElementById('editStatus').value = row.querySelector('.status').textContent.trim();
  document.getElementById('editEmployeeModal').style.display = 'flex';
}
function closeEditEmployeeModal() {
  document.getElementById('editEmployeeModal').style.display = 'none';
}
function showDeleteEmployeeModal(id) {
  document.getElementById('deleteEmployeeId').value = id;
  document.getElementById('deleteEmployeeModal').style.display = 'flex';
}
function closeDeleteEmployeeModal() {
  document.getElementById('deleteEmployeeModal').style.display = 'none';
}

function filterEmployeeTable() {
  const input = document.getElementById("employeeSearch").value.toLowerCase();
  const rows = document.querySelectorAll("#employeeTable tbody tr");
  rows.forEach(row => {
    row.style.display = row.innerText.toLowerCase().includes(input) ? "" : "none";
  });
}
function sortTableByColumn(index) {
  const table = document.getElementById("employeeTable");
  const rows = Array.from(table.rows).slice(1); // skip header
  const asc = table.dataset.sortDir !== "asc";
  rows.sort((a, b) => {
    return asc
      ? a.cells[index].innerText.localeCompare(b.cells[index].innerText)
      : b.cells[index].innerText.localeCompare(a.cells[index].innerText);
  });
  rows.forEach(row => table.tBodies[0].appendChild(row));
  table.dataset.sortDir = asc ? "asc" : "desc";
}

function downloadCSV() {
const table = document.querySelector("#employeeTable"); // ✅ Correct for employees
  const rows = Array.from(table.querySelectorAll("tbody tr"));

  let csvContent = "data:text/csv;charset=utf-8,";

  const headers = Array.from(table.querySelectorAll("thead th"))
    .map(th => `"${th.textContent.trim()}"`).slice(0, 6);
  csvContent += headers.join(",") + "\\r\\n";

  rows.forEach(row => {
    const cols = Array.from(row.querySelectorAll("td")).slice(0, 6);
    const line = cols.map(td => `"${td.textContent.trim()}"`).join(",");
    csvContent += line + "\\r\\n";
  });

  const encodedUri = encodeURI(csvContent);
  const link = document.createElement("a");
  link.setAttribute("href", encodedUri);
  link.setAttribute("download", "employee_data.csv");
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}


</script>
