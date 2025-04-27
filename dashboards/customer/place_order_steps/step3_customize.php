<h5 class="mb-3 fw-bold text-center">Step 3: Design Type</h5>
<p class="text-muted text-center mb-4">Choose whether your order requires unique names and sizes (Customizable) or standard sizing across all items (Non-Customizable).</p>

<!-- Option Selection -->
<div class="d-flex justify-content-center gap-3 mb-4">
    <div class="design-type-option" onclick="selectDesignType('customizable')">
        <input type="radio" name="design_type" id="customizable" value="customizable" class="d-none">
        <label for="customizable" class="design-type-card text-center p-4 shadow-sm rounded-4">
            <div class="option-icon mb-2">👕</div>
            <h6 class="fw-bold mb-1">Customizable</h6>
            <small>Upload an Excel list for officer shirts with unique names and sizes.</small>
        </label>
    </div>
    <div class="design-type-option" onclick="selectDesignType('standard')">
        <input type="radio" name="design_type" id="standard" value="standard" class="d-none">
        <label for="standard" class="design-type-card text-center p-4 shadow-sm rounded-4">
            <div class="option-icon mb-2">🧵</div>
            <h6 class="fw-bold mb-1">Standard</h6>
            <small>Same design and sizes for all items. Manually add sizes and quantities.</small>
        </label>
    </div>
</div>

<!-- 📂 Customizable Excel Upload Section -->
<div id="customizableSection" class="d-none">
    <h6 class="fw-bold mb-3 text-primary">📂 Upload Excel File (.xlsx)</h6>
    <input type="file" class="form-control mb-3" id="excelFile" accept=".xlsx" onchange="handleExcelUpload()">

    <div id="excelActions" class="d-none mb-3">
        <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeExcelFile()">❌ Remove Uploaded File</button>
        <input type="text" class="form-control mt-3" id="excelSearch" placeholder="🔍 Search rows...">
    </div>

    <div id="excelPreview" class="mt-3"></div>
</div>

<!-- 📝 Non-Customizable Manual Table -->
<div id="nonCustomizableSection" class="d-none">
    <h6 class="fw-bold mb-3 text-primary">📋 Manual Entry for Sizes and Quantities</h6>
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Size</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="manualTableBody">
            <tr>
                <td><input type="text" class="form-control" name="size[]" placeholder="e.g., M"></td>
                <td><input type="number" class="form-control" name="quantity[]" min="1" placeholder="e.g., 12"></td>
                <td><button class="btn btn-outline-danger btn-sm" onclick="removeManualRow(this)">Remove</button></td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-outline-primary btn-sm mt-2 rounded-pill" onclick="addManualRow()">➕ Add Row</button>
</div>
