<h5 class="mb-3 fw-bold text-center">Step 4: Order Summary</h5>
<p class="text-muted text-center mb-4">
    Here's a breakdown of your order. Please confirm that all details below are correct before proceeding.
</p>

<div class="order-summary-card">
    <div class="summary-header text-center">
        <h4>Order Summary</h4>
        <p class="summary-subtext">Review your selected service, sizes, quantities, and total cost.</p>
    </div>

    <div class="summary-details">
        <div class="summary-row"><span>Service:</span> <strong id="summaryService">Embroidery</strong></div>
        <div class="summary-row"><span>Total Shirts:</span> <strong id="summaryQuantity">24</strong></div>
        <div class="summary-row"><span>Free Shirts:</span> <strong id="summaryFree">2</strong></div>
        <div class="summary-row"><span>Total Price:</span> <strong id="summaryTotal">₱2,400.00</strong></div>
    </div>

    <div class="summary-table-wrapper">
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody id="summaryTableBody">
                <tr>
                    <td>Small</td>
                    <td>10</td>
                    <td>₱1,000.00</td>
                </tr>
                <tr>
                    <td>Medium</td>
                    <td>8</td>
                    <td>₱800.00</td>
                </tr>
                <tr>
                    <td>Large</td>
                    <td>6</td>
                    <td>₱600.00</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>



<style>
.order-summary-card {
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 6px 24px rgba(0,0,0,0.06);
    max-width: 800px;
    margin: 0 auto;
    animation: fadeInStep 0.4s ease;
}

.summary-header h4 {
    color: #0B5CF9;
    font-size: 1.8rem;
    margin-bottom: 8px;
    font-weight: 700;
}

.summary-subtext {
    font-size: 1.1rem;
    color: #555;
    margin-bottom: 28px;
}

.summary-details {
    margin-bottom: 24px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    font-size: 1.1rem;
    border-bottom: 1px dashed #d4dce5;
}

.summary-row span {
    color: #333;
    font-weight: 500;
}

.summary-row strong {
    color: #0B5CF9;
    font-weight: 700;
}

.summary-table-wrapper {
    margin-top: 28px;
}

.summary-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 1.05rem;
    background-color: #fefefe;
    table-layout: fixed;
    min-width: 100%;
}

.summary-table th,
.summary-table td {
    padding: 16px 18px;
    border: 1px solid #e0e6ed;
    text-align: left;
    word-wrap: break-word;
}

.summary-table th {
    background: linear-gradient(90deg, #0B5CF9, #4D8CFF);
    color: white;
    font-weight: 600;
    font-size: 1.1rem;
}

.receipt-actions {
    text-align: center;
    margin-top: 30px;
}

</style>
