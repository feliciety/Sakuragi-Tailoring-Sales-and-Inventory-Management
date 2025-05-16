<?php
require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../../config/session_handler.php';

$serviceId = $_SESSION['selected_service_id'] ?? $_POST['service_id'] ?? null;
$unitPrice = 0;

if ($serviceId) {
    $stmt = $pdo->prepare('SELECT price FROM services WHERE service_id = ?');
    $stmt->execute([$serviceId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $unitPrice = $row['price'] ?? 0;
}
?>

<input type="hidden" id="unitPrice" value="<?= $unitPrice ?>">
<input type="hidden" name="standard_table_data" id="standardTableData">

<h5 class="mb-3 fw-bold text-center">Step 3: Design Type</h5>
<p class="text-muted text-center mb-4">Choose whether your order requires unique names and sizes (Customizable) or standard sizing across all items (Standard).</p>

<!-- Design Type Selection -->
<div class="row g-4 justify-content-center">
    <div class="col-md-5 col-sm-6">
        <div class="design-type-card text-center p-4 shadow-sm rounded-4 h-100" onclick="selectDesignType('customizable', this)">
            <input type="radio" name="design_type" id="customizable" value="customizable" class="d-none">
            <label for="customizable" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="option-icon mb-2">👕</div>
                <h6 class="fw-bold mb-2">Customizable</h6>
                <small>Upload an Excel list for personalized uniforms with different names, numbers, or roles.</small>
            </label>
        </div>
    </div>
    <div class="col-md-5 col-sm-6">
        <div class="design-type-card text-center p-4 shadow-sm rounded-4 h-100" onclick="selectDesignType('standard', this)">
            <input type="radio" name="design_type" id="standard" value="standard" class="d-none">
            <label for="standard" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="option-icon mb-2">🧵</div>
                <h6 class="fw-bold mb-2">Standard</h6>
                <small>Same design and sizes for all items. Manually add sizes and quantities.</small>
            </label>
        </div>
    </div>
</div>

<!-- Customizable Section -->
<div id="customizableSection" class="d-none mt-5">
    <h6 class="fw-bold mb-3 text-primary">📂 Upload Excel File (.xlsx)</h6>
    <input type="file" class="form-control mb-3" id="excelFile" name="excel_file" accept=".xlsx" onchange="handleExcelUpload()">

    <div id="excelActions" class="d-none mb-3">
        <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeExcelFile()">❌ Remove Uploaded File</button>
        <input type="text" class="form-control mt-3" id="excelSearch" placeholder="🔍 Search rows...">
    </div>

    <div id="excelPreview" class="mt-3"></div>

    <!-- 🔽 Hidden input to store parsed data for submission -->
    <input type="hidden" name="customizable_table_data" id="customizableTableData">
</div>


<!-- Standard Section -->
<div id="nonCustomizableSection" class="d-none mt-5">
    <h6 class="fw-bold mb-3 text-primary">📋 Manual Entry for Sizes and Quantities</h6>
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Size</th>
                <th>Quantity</th>
                <th>Cost</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="manualTableBody">
            <tr>
                <td>
                    <select class="form-control" name="size[]" onchange="updateCost(this)">
                        <option value="Small">Small</option>
                        <option value="Medium">Medium</option>
                        <option value="Large">Large</option>
                    </select>
                </td>
                <td>
                    <input type="number" class="form-control" name="quantity[]" min="1" placeholder="e.g., 12" oninput="updateCost(this)">
                </td>
                <td class="cost-cell">₱0.00</td>
                <td>
                    <button class="btn btn-outline-danger btn-sm" onclick="removeManualRow(this)">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-outline-primary btn-sm mt-2 rounded-pill" onclick="addManualRow()">➕ Add Row</button>
</div>

<!-- CSS Styling (same as before) -->
<style>
.design-type-card {
    border: 2px solid transparent;
    background-color: #fff;
    transition: all 0.3s ease;
    cursor: pointer;
    border-radius: 16px;
    padding: 30px 20px;
    box-shadow: 0 0 0 rgba(0,0,0,0);
    user-select: none;
}
.design-type-card:hover {
    border-color: #0b5cf9;
    box-shadow: 0 8px 20px rgba(11, 92, 249, 0.15);
    transform: translateY(-2px);
}
.design-type-card.selected {
    border-color: #0b5cf9;
    background: #eef4ff;
    box-shadow: 0 10px 25px rgba(11, 92, 249, 0.15);
}
.design-type-card.selected h6,
.design-type-card.selected small {
    color: #0b5cf9;
}
.option-icon {
    font-size: 2.8rem;
    line-height: 1;
}
</style>

<!-- JS (No Blob, uses hidden input) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
function selectDesignType(type, el) {
    document.getElementById('customizableSection').classList.toggle('d-none', type !== 'customizable');
    document.getElementById('nonCustomizableSection').classList.toggle('d-none', type !== 'standard');

    document.querySelectorAll('.design-type-card').forEach(card => card.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById(type).checked = true;

    sessionStorage.removeItem('uploadedDesignList');
    document.getElementById('standardTableData').value = '';
    disableNextButton();
}

function handleExcelUpload() {
    const file = document.getElementById('excelFile').files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });
        const sheet = workbook.Sheets[workbook.SheetNames[0]];
        const json = XLSX.utils.sheet_to_json(sheet, { header: 1 });

        renderExcelTable(json);
        sessionStorage.setItem('uploadedDesignList', JSON.stringify(json));
        document.getElementById('excelActions').classList.remove('d-none');
        enableNextButton();
    };
    reader.readAsArrayBuffer(file);
}

function renderExcelTable(json) {
    const selectedService = JSON.parse(sessionStorage.getItem('selectedService'));
    const unitPrice = selectedService?.price || 0;

    const headers = json[0]; // First row = header
    const sizeIndex = headers.findIndex(h => h.toLowerCase().includes('size'));
    const qtyIndex = headers.findIndex(h => h.toLowerCase().includes('quantity') || h.toLowerCase().includes('number'));

    if (sizeIndex === -1 || qtyIndex === -1) {
        document.getElementById('excelPreview').innerHTML = `<div class="alert alert-warning">Missing "Size" or "Quantity/Number" column in uploaded file.</div>`;
        disableNextButton();
        return;
    }

    let dataRows = [];
    let html = `
      <table class="table table-bordered align-middle">
        <thead class="table-primary text-white">
          <tr>
            <th>Size</th>
            <th>Quantity</th>
            <th>Cost</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="customExcelBody">
    `;

    for (let i = 1; i < json.length; i++) {
        const row = json[i];
        const size = row[sizeIndex]?.trim();
        const quantity = parseInt(row[qtyIndex]) || 0;
        if (!size || quantity <= 0) continue;

        const cost = quantity * unitPrice;

        html += `
          <tr>
            <td>${size}</td>
            <td>${quantity}</td>
            <td class="cost-cell">₱${cost.toFixed(2)}</td>
            <td><button class="btn btn-outline-danger btn-sm" onclick="removeExcelRow(this)">Remove</button></td>
          </tr>
        `;

        dataRows.push({ size, quantity, cost });
    }

    const totalQty = dataRows.reduce((sum, row) => sum + row.quantity, 0);
    const freeShirts = Math.floor(totalQty / 12);

    html += `
        </tbody>
      </table>
      <p class="mt-3 text-success">
        🎁 Eligible for <strong>${freeShirts}</strong> free shirt(s) (1 free every 12 ordered).
      </p>
    `;

    // Store in preview + hidden input
    document.getElementById('excelPreview').innerHTML = html;
    document.getElementById('customizableTableData').value = JSON.stringify(dataRows);

    dataRows.length ? enableNextButton() : disableNextButton();
}

function removeExcelRow(button) {
    const row = button.closest('tr');
    row.remove();

    // Recalculate totals and cost
    const updatedRows = [];
    const selectedService = JSON.parse(sessionStorage.getItem('selectedService'));
    const unitPrice = selectedService?.price || 0;

    document.querySelectorAll('#customExcelBody tr').forEach(row => {
        const size = row.cells[0].textContent.trim();
        const qty = parseInt(row.cells[1].textContent.trim()) || 0;
        const cost = qty * unitPrice;
        row.querySelector('.cost-cell').textContent = `₱${cost.toFixed(2)}`;
        if (qty > 0) updatedRows.push({ size, quantity: qty, cost });
    });

    const totalQty = updatedRows.reduce((sum, r) => sum + r.quantity, 0);
    const freeShirts = Math.floor(totalQty / 12);

    const updatedNote = `
      <p class="mt-3 text-success">
        🎁 Eligible for <strong>${freeShirts}</strong> free shirt(s) (1 free every 12 ordered).
      </p>
    `;
    document.querySelector('#excelPreview').innerHTML = document.querySelector('#excelPreview').innerHTML.replace(/<p class="mt-3 text-success">.*?<\/p>/s, updatedNote);

    document.getElementById('customizableTableData').value = JSON.stringify(updatedRows);
    updatedRows.length ? enableNextButton() : disableNextButton();
}


function removeExcelFile() {
    document.getElementById('excelFile').value = '';
    document.getElementById('excelPreview').innerHTML = '';
    document.getElementById('excelActions').classList.add('d-none');
    sessionStorage.removeItem('uploadedDesignList');
    disableNextButton();
}

function addManualRow() {
    const tbody = document.getElementById('manualTableBody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td>
            <select class="form-control" name="size[]" onchange="updateCost(this)">
                <option value="Small">Small</option>
                <option value="Medium">Medium</option>
                <option value="Large">Large</option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="quantity[]" min="1" placeholder="e.g., 12" oninput="updateCost(this)">
        </td>
        <td class="cost-cell">₱0.00</td>
        <td>
            <button class="btn btn-outline-danger btn-sm" onclick="removeManualRow(this)">Remove</button>
        </td>
    `;
    tbody.appendChild(tr);
}

const selectedService = JSON.parse(sessionStorage.getItem('selectedService'));
const unitPrice = selectedService?.price || 0;

function updateCost(el) {
    const row = el.closest('tr');
    const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
    const selectedService = JSON.parse(sessionStorage.getItem('selectedService'));
    const unitPrice = selectedService?.price || 0;

    const total = quantity * unitPrice;
    row.querySelector('.cost-cell').textContent = `₱${total.toFixed(2)}`;

    updateStandardValidation();
}


function removeManualRow(btn) {
    btn.closest('tr').remove();
    updateStandardValidation();
}

function updateStandardValidation() {
    const rows = document.querySelectorAll('#manualTableBody tr');
    const data = [];

    let valid = false;

    rows.forEach(row => {
        const size = row.querySelector('select[name="size[]"]').value;
        const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
        if (quantity > 0) {
            data.push({ size, quantity });
            valid = true;
        }
    });

    document.getElementById('standardTableData').value = JSON.stringify(data);
    valid ? enableNextButton() : disableNextButton();
}

function enableNextButton() {
    const btn = document.getElementById('nextBtn');
    if (btn) {
        btn.disabled = false;
        btn.classList.remove('btn-secondary');
        btn.classList.add('btn-primary');
    }
}

function disableNextButton() {
    const btn = document.getElementById('nextBtn');
    if (btn) {
        btn.disabled = true;
        btn.classList.remove('btn-primary');
        btn.classList.add('btn-secondary');
    }
}

document.addEventListener('DOMContentLoaded', disableNextButton);
</script>
