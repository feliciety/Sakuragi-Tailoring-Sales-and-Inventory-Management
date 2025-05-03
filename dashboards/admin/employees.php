<?php
require_once __DIR__ . '/../../config/session_handler.php';
require_once __DIR__ . '/../../config/constants.php';
require_once '../../middleware/role_admin_only.php';
require_once '../../includes/header.php';
require_once '../../includes/sidebar_admin.php';
?>

<main class="main-content">
    <h1>Manage Employees</h1>

    <div class="table-controls">
        <div class="filters">
            <div class="input-wrapper">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" placeholder="Search employees..." class="table-search" onkeyup="filterTable()">
            </div>
            <div class="select-wrapper">
                <i class="fas fa-filter"></i>
                <select id="statusFilter" class="table-filter" onchange="filterByStatus()">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="hired">Hired</option>
                    <option value="absent">Absent</option>
                </select>
            </div>
        </div>

        <button onclick="exportTableToCSV()" class="btn-export">
            <i class="fas fa-download"></i> Export CSV
        </button>
    </div>

    <div class="table-responsive">
        <table id="employeeTable">
            <thead>
                <tr>
                    <th onclick="sortTable(0)">Name</th>
                    <th onclick="sortTable(1)">Position</th>
                    <th onclick="sortTable(2)">Department</th>
                    <th onclick="sortTable(3)">Branch</th>
                    <th onclick="sortTable(4)">Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><img src="/assets/images/user1.jpg" class="avatar"> Juan Dela Cruz</td>
                    <td>Tailor</td>
                    <td>Tailoring</td>
                    <td>Main Branch</td>
                    <td><span class="status employed">Active</span></td>
                    <td class="action-buttons">
                        <button class="edit"><i class="fas fa-pen"></i></button>
                        <button class="delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
                <tr>
                    <td><img src="/assets/images/user2.jpg" class="avatar"> Maria Santos</td>
                    <td>Customer Support</td>
                    <td>Customer Service</td>
                    <td>SM Lanang</td>
                    <td><span class="status absent">Absent</span></td>
                    <td class="action-buttons">
                        <button class="edit"><i class="fas fa-pen"></i></button>
                        <button class="delete"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<?php require_once '../../includes/footer.php'; ?>