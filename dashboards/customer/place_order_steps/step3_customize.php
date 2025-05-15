<?php
require_once __DIR__ . '/../../../config/db_connect.php';
require_once __DIR__ . '/../../../config/session_handler.php';

// Fetch unit price from selected service
$serviceId = $_SESSION['selected_service_id'] ?? $_POST['service_id'] ?? null;
$unitPrice = 0;

if ($serviceId) {
    $stmt = $pdo->prepare('SELECT price FROM services WHERE service_id = ?');
    $stmt->execute([$serviceId]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $unitPrice = $row['price'] ?? 0;
}
?>

<!-- Hidden field for JS use -->
<input type="hidden" id="unitPrice" value="<?= $unitPrice ?>">

<h5 class="mb-3 fw-bold text-center">Step 3: Design Type</h5>
<p class="text-muted text-center mb-4">Choose whether your order requires unique names and sizes (Customizable) or standard sizing across all items (Non-Customizable).</p>

<!-- Design Type Selection -->
<div class="row g-4 justify-content-center">
    <div class="col-md-5 col-sm-6">
        <div class="design-type-card text-center p-4 shadow-sm rounded-4 h-100" onclick="selectDesignType('customizable')">
            <input type="radio" name="design_type" id="customizable" value="customizable" class="d-none">
            <label for="customizable" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="option-icon mb-2">👕</div>
                <h6 class="fw-bold mb-2">Customizable</h6>
                <small>Upload an Excel list for personalized uniforms with different names, numbers, or roles.</small>
            </label>
        </div>
    </div>
    <div class="col-md-5 col-sm-6">
        <div class="design-type-card text-center p-4 shadow-sm rounded-4 h-100" onclick="selectDesignType('standard')">
            <input type="radio" name="design_type" id="standard" value="standard" class="d-none">
            <label for="standard" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="option-icon mb-2">🧵</div>
                <h6 class="fw-bold mb-2">Standard</h6>
                <small>Same design and sizes for all items. Manually add sizes and quantities.</small>
            </label>
        </div>
    </div>
</div>

<!-- Excel Upload Section -->
<div id="customizableSection" class="d-none mt-5">
    <h6 class="fw-bold mb-3 text-primary">📂 Upload Excel File (.xlsx)</h6>
    <input type="file" class="form-control mb-3" id="excelFile" accept=".xlsx" onchange="handleExcelUpload()">

    <div id="excelActions" class="d-none mb-3">
        <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeExcelFile()">❌ Remove Uploaded File</button>
        <input type="text" class="form-control mt-3" id="excelSearch" placeholder="🔍 Search rows...">
    </div>

    <div id="excelPreview" class="mt-3"></div>
</div>

<!-- Manual Entry Section -->
<div id="nonCustomizableSection" class="mt-5">
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

<!-- CSS Styling -->
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

<!-- JavaScript for Dynamic Table -->

<script>
    document.addEventListener('DOMContentLoaded', () => {
    const excelInput = document.getElementById('excelFile');
    const previewContainer = document.getElementById('excelPreview');

    if (!excelInput || !previewContainer) return;

    excelInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = (evt) => {
            const data = evt.target.result;
            const workbook = XLSX.read(data, { type: 'binary' });
            const sheetName = workbook.SheetNames[0];
            const sheet = workbook.Sheets[sheetName];
            const json = XLSX.utils.sheet_to_json(sheet, { header: 1 });

            renderExcelTable(json);
        };
        reader.readAsBinaryString(file);
    });

    function renderExcelTable(rows) {
        if (!rows || rows.length === 0) {
            previewContainer.innerHTML = "<p class='text-danger'>No data found in file.</p>";
            return;
        }

        const table = document.createElement('table');
        table.className = 'table table-bordered table-striped mt-3';
        
        rows.forEach((row, rowIndex) => {
            const tr = document.createElement('tr');
            row.forEach(cell => {
                const td = document.createElement(rowIndex === 0 ? 'th' : 'td');
                td.textContent = cell;
                tr.appendChild(td);
            });
            table.appendChild(tr);
        });

        // Auto-calculate free shirts (1 per 12 ordered)
        const quantity = rows.length - 1;
        const freeShirts = Math.floor(quantity / 12);
        const summaryNote = document.createElement('p');
        summaryNote.className = "mt-2 text-success";
        summaryNote.textContent = `🆓 Eligible for ${freeShirts} free shirt(s) (1 free every 12 ordered).`;

        previewContainer.innerHTML = '';
        previewContainer.appendChild(table);
        previewContainer.appendChild(summaryNote);
    }
});

</script>
<script>
function updateCost(elem) {
    const row = elem.closest('tr');
    const qty = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
    const pricePerUnit = parseFloat(document.getElementById('unitPrice').value) || 0;
    const subtotal = qty * pricePerUnit;
    row.querySelector('.cost-cell').textContent = `₱${subtotal.toFixed(2)}`;
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
            <input type="number" class="form-control" name="quantity[]" min="1" 
                   placeholder="e.g., 12" oninput="updateCost(this)">
        </td>
        <td class="cost-cell">₱0.00</td>
        <td>
            <button class="btn btn-outline-danger btn-sm" onclick="removeManualRow(this)">Remove</button>
        </td>
    `;
    tbody.appendChild(tr);
}

function removeManualRow(button) {
    const row = button.closest('tr');
    row.remove();
}

function selectDesignType(type) {
    document.getElementById('customizableSection').classList.toggle('d-none', type !== 'customizable');
    document.getElementById('nonCustomizableSection').classList.toggle('d-none', type !== 'standard');

    document.querySelectorAll('.design-type-card').forEach(card => card.classList.remove('selected'));
    document.getElementById(type).checked = true;
    event.currentTarget.classList.add('selected');
}
</script>
