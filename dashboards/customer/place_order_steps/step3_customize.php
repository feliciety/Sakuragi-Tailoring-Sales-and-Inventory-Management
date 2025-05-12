<?php
require_once __DIR__ . '../../../../config/db_connect.php';
require_once __DIR__ . '../../../../config/session_handler.php';

// Fetch size pricing data
$query = 'SELECT size, quantity, price FROM sizes_pricing';
$result = $pdo->query($query);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax'])) {
    $sizes = $_POST['size'];
    $quantities = $_POST['quantity'];

    $response = [
        'totalShirts' => 0,
        'shirtTotalPrice' => 0,
        'breakdown' => [],
    ];

    // Loop through the sizes and quantities
    for ($i = 0; $i < count($sizes); $i++) {
        $size = $sizes[$i];
        $quantity = (int) $quantities[$i];

        // Fetch price from database
        $stmt = $pdo->prepare('SELECT price FROM sizes_pricing WHERE size = ?');
        $stmt->execute([$size]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $pricePerUnit = $row['price'];
            $subtotal = $pricePerUnit * $quantity;

            $response['totalShirts'] += $quantity;
            $response['shirtTotalPrice'] += $subtotal;

            $response['breakdown'][] = [
                'size' => $size,
                'quantity' => $quantity,
                'pricePerUnit' => $pricePerUnit,
                'subtotal' => $subtotal,
            ];
        }
    }

    // Return the response as JSON
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['fetchPrices'])) {
    $query = 'SELECT size, price FROM sizes_pricing';
    $result = $pdo->query($query);
    $prices = $result->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($prices);
    exit();
}
?>
<h5 class="mb-3 fw-bold text-center">Step 3: Design Type</h5>
<p class="text-muted text-center mb-4">Choose whether your order requires unique names and sizes (Customizable) or standard sizing across all items (Non-Customizable).</p>

<!-- Option Selection -->
<div class="row g-4 justify-content-center">
    <div class="col-md-5 col-sm-6">
        <div class="design-type-card text-center p-4 shadow-sm rounded-4 h-100"onclick="selectDesignType('customizable')">
            <input type="radio" name="design_type" id="customizable" value="customizable" class="d-none">
            <label for="customizable" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="option-icon mb-2">👕</div>
                <h6 class="fw-bold mb-2">Customizable</h6>
                <small>Upload an Excel list for personalized uniforms with different names, numbers, or roles.</small>
            </label>
        </div>
    </div>
    <div class="col-md-5 col-sm-6">
        <div class="design-type-card text-center p-4 shadow-sm rounded-4 h-100"
             onclick="selectDesignType('standard')">
            <input type="radio" name="design_type" id="standard" value="standard" class="d-none">
            <label for="standard" class="w-100 h-100 d-flex flex-column align-items-center justify-content-center">
                <div class="option-icon mb-2">🧵</div>
                <h6 class="fw-bold mb-2">Standard</h6>
                <small>Same design and sizes for all items. Manually add sizes and quantities.</small>
            </label>
        </div>
    </div>
</div>

<!-- 📂 Customizable Excel Upload Section -->
<div id="customizableSection" class="d-none mt-5">
    <h6 class="fw-bold mb-3 text-primary">📂 Upload Excel File (.xlsx)</h6>
    <input type="file" class="form-control mb-3" id="excelFile" accept=".xlsx" onchange="handleExcelUpload()">

    <div id="excelActions" class="d-none mb-3">
        <button class="btn btn-outline-danger btn-sm rounded-pill" onclick="removeExcelFile()">❌ Remove Uploaded File</button>
        <input type="text" class="form-control mt-3" id="excelSearch" placeholder="🔍 Search rows...">
    </div>

    <div id="excelPreview" class="mt-3"></div>
</div>

<!-- 📝 Non-Customizable Manual Table -->
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
            <input type="number" class="form-control" name="quantity[]" min="1" 
                   placeholder="e.g., 12" oninput="updateCost(this)">
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


<style>
.design-type-card {
    border: 2px solid transparent;
    background-color: #fff;
    transition: all 0.3s ease;
    cursor: pointer;
    border-radius: 16px;
    height: 100%;
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
