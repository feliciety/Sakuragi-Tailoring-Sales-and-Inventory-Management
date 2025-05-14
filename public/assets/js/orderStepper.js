//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------ STEP 1: Services⭐ ------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//

function selectService(serviceName, element) {
    // Remove selected class from all cards
    document.querySelectorAll('.service-card').forEach(card => {
        card.classList.remove('selected');
    });

    // Add selected class to clicked card
    element.classList.add('selected');

    // Get complete service data from the clicked card
    const serviceData = {
        id: parseInt(element.dataset.serviceId),
        name: serviceName,
        price: parseFloat(element.dataset.price),
        category: element.dataset.category,
        description: element.querySelector('small').textContent
    };

    // Store complete service data in sessionStorage
    sessionStorage.setItem('selectedService', JSON.stringify(serviceData));

    // Also store in orderSummaryData
    const orderData = {
        service: serviceData,
        items: []
    };
    sessionStorage.setItem('orderSummaryData', JSON.stringify(orderData));

    // Update service details display
    document.getElementById('service-details').innerHTML = `
        <div class="alert alert-info">
            <h6 class="mb-2">Selected Service: ${serviceName}</h6>
            <p class="mb-1">Category: ${serviceData.category}</p>
            <p class="mb-1">Price: ₱${serviceData.price.toFixed(2)}</p>
            <p class="mb-0">${serviceData.description}</p>
        </div>
    `;

    // Update hidden inputs
    document.getElementById('selected_service').value = serviceData.id;
    document.getElementById('selected_service_price').value = serviceData.price;

    // Log to verify data is being stored correctly
    console.log('Selected Service Data:', serviceData);
}



//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------ STEP 2: Uplaods ⭐------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//

function handleFileUpload() {
    const fileInput = document.getElementById('image');
    const file = fileInput.files[0];

    if (!file) return;

    // Validate file extension
    const fileExtension = file.name.split('.').pop().toLowerCase();
    if (fileExtension !== 'zip' && fileExtension !== 'psd') {
        alert('Invalid file type. Only PSD and ZIP files are allowed.');
        fileInput.value = '';
        return;
    }

    // Validate file size (500MB)
    if (file.size > 500 * 1024 * 1024) {
        alert('File size exceeds the maximum limit of 500MB.');
        fileInput.value = '';
        return;
    }

    // Store the file information in sessionStorage
    const designData = {
        fileName: file.name,
        fileSize: file.size,
        fileType: fileExtension.toUpperCase(),
        uploadDate: new Date().toISOString()
    };

    // Update order data
    updateOrderData({ design: designData });

    // Show file info
    document.getElementById('fileInfoContainer').innerHTML = `
        <div class="alert alert-info">
            <p class="mb-2"><strong>Selected file:</strong> ${file.name}</p>
            <p class="mb-0"><strong>Size:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB</p>
        </div>
    `;
    document.getElementById('fileInfoContainer').classList.remove('d-none');

    // Show upload progress (simulated)
    simulateUploadProgress();
}

function simulateUploadProgress() {
    const progressContainer = document.getElementById('uploadProgressContainer');
    const progressBar = document.getElementById('uploadProgressBar');
    const percentageText = document.getElementById('uploadPercentage');
    
    // Reset progress
    progressBar.style.width = '0%';
    percentageText.textContent = '0%';
    
    // Show progress container
    progressContainer.classList.remove('d-none');
    
    // Simulate upload progress
    let progress = 0;
    const progressInterval = setInterval(() => {
        progress += Math.floor(Math.random() * 8) + 2; // Random increment between 2-10%
        
        if (progress >= 100) {
            progress = 100;
            clearInterval(progressInterval);
            
            // Complete upload
            setTimeout(() => {
                progressContainer.classList.add('d-none');
                displayUploadedFile();
            }, 500);
        }
        
        // Update progress UI
        progressBar.style.width = `${progress}%`;
        percentageText.textContent = `${progress}%`;
    }, 200);
}

function displayUploadedFile() {
    const file = document.getElementById('image').files[0];
    const fileExtension = file.name.split('.').pop().toLowerCase();
    
    // Set appropriate icon based on file type
    const preview = document.getElementById('imagePreview');
    if (fileExtension === 'zip') {
        preview.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBkPSJNMjU2IDUxMmMxNDEuNCAwIDI1Ni0xMTQuNiAyNTYtMjU2UzM5Ny40IDAgMjU2IDAgMCAxMTQuNiAwIDI1NnMxMTQuNiAyNTYgMjU2IDI1NnptLTk5LTM2OGg2MHY0MGgtMjB2MjBoMjB2NDBoLTIwdjIwaDIwdjQwaC02MFYxNDR6bS04MCAxMjhoNjBWMTQ0aC02MHYxMjh6bTI0MC0xMjhIMjE3djEyOGgxMDBWMTQ0em0tNDAgMjBoNjB2ODhoLTYwdi04OHoiIGZpbGw9IiMwQjVDRjkiLz48L3N2Zz4=';
        preview.classList.add('file-icon');
    } else if (fileExtension === 'psd') {
        preview.src = 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCA1MTIgNTEyIj48cGF0aCBkPSJNMTA4LjEgOTYuMWMtNC4yLS4xLTguNy4xLTEzLjUuN0MyMC44IDEwMy40LS4xIDE0Ny44IDAgMjA1YzAgMTQ5LjQ4IDEyNC42IDE0Ni43NSAxMjQuNiAyMjUuMSAwIDMzIDI4LjggNTcuNyA2MS40IDU3LjcgOTYuNCAwIDEyNy0yMTguOCAxOTAuOC0yMTguOCAyNSAwIDQzLjQgMjEgNDMuNCA0NS4zIDAgMzQuOC0yNy4zIDc3LjItNjEuNCA3Ny4yLTIzIDAtMjkuNi0xMS4gNC44LTExLjcgMjcuNyAwIDQzLjQtMjQuMSA0My40LTUwLjggMC0yMS43LTEwLjUtMzcuMS0zMC4yLTM3LjEtOTcuNiAwLTEyNiAyMTguOC0xOTAuOCAyMTguOC0yNyAwLTU1LjgtMzAuMS01NS44LTY1LjVDMTMwLjIgMzU1LjMgNCAxMzcuMyA0IDEyNi44YzAtMTQuOSAxMS4zLTI4LjQgMjkuMi0zMC4xIDE5LjctMS45IDI5IDIyLjQuOTkgMjIuNC0xMC44IDAtMTYuMS02LjQtMTYuMS0xMy43IDAtNS43IDYuMi05LjE0IDE0LjYtOS4xNEgzM2MxOS42IDExLjE4IDIzLjIyLTE2LjM0IDc1LjEtMTYuMzR6IiBmaWxsPSIjMDAxZTM2Ii8+PC9zdmc+';
        preview.classList.add('file-icon');
    }
    
    // Update file details
    document.getElementById('fileName').innerHTML = `<strong>File name:</strong> ${file.name}`;
    document.getElementById('fileSize').innerHTML = `<strong>Size:</strong> ${(file.size / 1024 / 1024).toFixed(2)} MB`;
    document.getElementById('fileType').innerHTML = `<strong>Type:</strong> ${fileExtension.toUpperCase()} file`;
    
    // Show preview container
    document.getElementById('imagePreviewContainer').classList.remove('d-none');
    
    // Hide file info container
    document.getElementById('fileInfoContainer').classList.add('d-none');
}

// Remove uploaded file
function removeUploadedFile() {
    const fileInput = document.getElementById('image');
    const fileInfoContainer = document.getElementById('fileInfoContainer');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const progressContainer = document.getElementById('uploadProgressContainer');

    // Clear file input and hide containers
    fileInput.value = '';
    fileInfoContainer.classList.add('d-none');
    fileInfoContainer.innerHTML = '';
    imagePreviewContainer.classList.add('d-none');
    progressContainer.classList.add('d-none');

    // Clear design data from order
    updateOrderData({ design: null });
}

// Initialize drag and drop
document.addEventListener('DOMContentLoaded', function() {
    const dropArea = document.getElementById('uploadDropArea');

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropArea.classList.add('highlight');
    }

    function unhighlight(e) {
        dropArea.classList.remove('highlight');
    }

    dropArea.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;

        if (files.length > 0) {
            document.getElementById('image').files = files;
            handleFileUpload();
        }
    }
});

// Helper function to update order data in session storage
function updateOrderData(data) {
    let orderData = {};
    try {
        const storedData = sessionStorage.getItem('orderSummaryData');
        if (storedData) {
            orderData = JSON.parse(storedData);
        }
    } catch (e) {
        console.error('Error parsing order data', e);
    }
    
    // Merge new data with existing data
    orderData = { ...orderData, ...data };
    sessionStorage.setItem('orderSummaryData', JSON.stringify(orderData));
}
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------ STEP 3: Customize ⭐------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//

function selectDesignType(type) {
    // Remove 'selected' from all cards
    document.querySelectorAll('.design-type-card').forEach(card => {
        card.classList.remove('selected');
    });

    // Add 'selected' to the clicked one
    const selectedCard = type === 'customizable'
        ? document.querySelector('input#customizable').closest('.design-type-card')
        : document.querySelector('input#standard').closest('.design-type-card');

    selectedCard.classList.add('selected');

    // Toggle visibility of related sections
    document.getElementById('customizableSection').classList.toggle('d-none', type !== 'customizable');
    document.getElementById('nonCustomizableSection').classList.toggle('d-none', type !== 'standard');

    // Update hidden input if needed
    document.getElementById('customizable').checked = type === 'customizable';
    document.getElementById('standard').checked = type === 'standard';
}

// ⭐ Handle Excel Upload and Convert to Editable Table
function handleExcelUpload() {
    const file = document.getElementById('excelFile').files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (e) {
        const data = new Uint8Array(e.target.result);
        const workbook = XLSX.read(data, { type: 'array' });
        const worksheet = workbook.Sheets[workbook.SheetNames[0]];
        const jsonData = XLSX.utils.sheet_to_json(worksheet, { header: 1 });

        if (jsonData.length === 0) {
            alert('❌ The uploaded Excel file is empty.');
            return;
        }

        generateEditableExcelTable(jsonData);
        document.getElementById('excelActions').classList.remove('d-none');
    };
    reader.readAsArrayBuffer(file);
}

// ⭐ Generate Editable Table From Excel Data
function generateEditableExcelTable(data) {
    const headers = data[0].map(h => h?.toString().trim().toLowerCase());
    const nameIndex = headers.indexOf('name');
    const numberIndex = headers.indexOf('number');
    const sizeIndex = headers.indexOf('size');

    if (nameIndex === -1 || numberIndex === -1 || sizeIndex === -1) {
        alert('❌ Excel must include "Name", "Number", and "Size" columns.');
        removeExcelFile();
        return;
    }

    let table = '<table class="table table-bordered editable-table align-middle"><thead class="table-light"><tr>';
    table += '<th>Name</th><th>Number</th><th>Size</th><th>Action</th></tr></thead><tbody>';

    data.slice(1).forEach(row => {
        if (row.length > 0) {
            const name = row[nameIndex] ?? '';
            const number = row[numberIndex] ?? '';
            const size = row[sizeIndex] ?? '';
            table += `
                <tr>
                    <td><input type="text" class="form-control" value="${name}"></td>
                    <td><input type="text" class="form-control" value="${number}"></td>
                    <td><input type="text" class="form-control" value="${size}"></td>
                    <td><button class="btn btn-outline-danger btn-sm" onclick="removeExcelRow(this)">Remove</button></td>
                </tr>`;
        }
    });

    table += '</tbody></table>';
    document.getElementById('excelPreview').innerHTML = table;
}

// ⭐ Remove Uploaded Excel File
function removeExcelFile() {
    document.getElementById('excelFile').value = '';
    document.getElementById('excelPreview').innerHTML = '';
    document.getElementById('excelActions').classList.add('d-none');
}

// ⭐ Remove Row From Excel Preview Table
function removeExcelRow(button) {
    button.closest('tr').remove();
}

// ⭐ Search Filtering for Excel Table (Live Search)
document.getElementById('excelSearch').addEventListener('keyup', function () {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('#excelPreview table tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});
// ⭐ Step 3 Standard Design Type

// Update the sizePrices object and cost calculation functions
let sizePrices = {
    'Small': 200,
    'Medium': 200,
    'Large': 200
};

function calculateTotalCost() {
    let totalCost = 0;
    const rows = document.querySelectorAll('#manualTableBody tr');

    rows.forEach(row => {
        const size = row.querySelector('select[name="size[]"]').value;
        const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
        const pricePerUnit = sizePrices[size];
        const rowTotal = quantity * pricePerUnit;

        // Update individual row cost
        row.querySelector('.cost-cell').textContent = `₱${rowTotal.toFixed(2)}`;
        totalCost += rowTotal;
    });

    // Store updated items in sessionStorage
    const items = Array.from(rows).map(row => ({
        size: row.querySelector('select[name="size[]"]').value,
        quantity: parseInt(row.querySelector('input[name="quantity[]"]').value) || 0,
        pricePerUnit: sizePrices[row.querySelector('select[name="size[]"]').value],
        cost: parseFloat(row.querySelector('.cost-cell').textContent.replace('₱', ''))
    }));

    sessionStorage.setItem('orderItems', JSON.stringify(items));
    return totalCost;
}

function updateCost(element) {
    calculateTotalCost();
}

// Initialize a counter for row additions if it doesn't exist
if (typeof window.rowAddCounter === 'undefined') {
    window.rowAddCounter = 0;
}

function addManualRow() {
    const tbody = document.getElementById('manualTableBody');

    // Increment counter each time a row is added
    window.rowAddCounter++;

    // Determine which size should be selected based on the counter
    // Cycle through Medium, Large, Small in that order
    const sizePattern = ['Medium', 'Large', 'Small'];
    const defaultSize = sizePattern[(window.rowAddCounter - 1) % 3]; // Use modulo to cycle through the array

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <select class="form-control" name="size[]">
                <option value="Small" ${defaultSize === 'Small' ? 'selected' : ''}>Small</option>
                <option value="Medium" ${defaultSize === 'Medium' ? 'selected' : ''}>Medium</option>
                <option value="Large" ${defaultSize === 'Large' ? 'selected' : ''}>Large</option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="quantity[]" min="1" 
                   placeholder="e.g., 12" >
        </td>
        <td class="cost-cell">₱0.00</td>
        <td>
            <button class="btn btn-outline-danger btn-sm">Remove</button>
        </td>
    `;

    // Add event listeners to new row elements
    const sizeSelect = newRow.querySelector('select[name="size[]"]');
    const quantityInput = newRow.querySelector('input[name="quantity[]"]');
    const removeButton = newRow.querySelector('button');

    // Update event listeners to use direct function calls
    sizeSelect.addEventListener('change', () => {
        calculateTotalCost();
        updateDisplay();
    });

    quantityInput.addEventListener('input', () => {
        calculateTotalCost();
        updateDisplay();
    });

    removeButton.addEventListener('click', () => {
        newRow.remove();
        calculateTotalCost();
        updateDisplay();
    });

    tbody.appendChild(newRow);
    calculateTotalCost(); // Calculate costs immediately after adding row
    updateDisplay(); // Update the display
}

// Add this new function to update all displays
function updateDisplay() {
    const rows = document.querySelectorAll('#manualTableBody tr');
    let totalCost = 0;

    rows.forEach(row => {
        const size = row.querySelector('select[name="size[]"]').value;
        const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
        const pricePerUnit = sizePrices[size];
        const rowTotal = quantity * pricePerUnit;

        row.querySelector('.cost-cell').textContent = `₱${rowTotal.toFixed(2)}`;
        totalCost += rowTotal;
    });

    // Update session storage with current state
    const items = Array.from(rows).map(row => ({
        size: row.querySelector('select[name="size[]"]').value,
        quantity: parseInt(row.querySelector('input[name="quantity[]"]').value) || 0,
        pricePerUnit: sizePrices[row.querySelector('select[name="size[]"]').value],
        cost: parseFloat(row.querySelector('.cost-cell').textContent.replace('₱', ''))
    }));

    sessionStorage.setItem('orderItems', JSON.stringify({
        items: items,
        totalCost: totalCost
    }));
}

// Update the original updateCost function
function updateCost(element) {
    calculateTotalCost();
    updateDisplay();
}


function updatePaymentAmount() {
    try {
        const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
        if (orderData && orderData.totals) {
            // Fetch service price and shirt total from session storage
            const servicePrice = orderData.totals.servicePrice || 0;
            const shirtTotal = orderData.totals.shirtTotal || 0;

            // Calculate the grand total
            const grandTotal = servicePrice + shirtTotal;

            // Update the displayed amount in Step 5
            const amountToPayElement = document.getElementById('amountToPay');
            if (amountToPayElement) {
                amountToPayElement.textContent = `₱${grandTotal.toFixed(2)}`;
            }
        }
    } catch (error) {
        console.error('Error updating payment amount:', error);
    }
}

//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------ STEP 4: Summarize 📋 ------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//

function displayOrderSummary() {
    const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
    const serviceData = JSON.parse(sessionStorage.getItem('selectedService'));
    const orderItems = JSON.parse(sessionStorage.getItem('orderItems'));
    const designFile = sessionStorage.getItem('uploadedDesign');

    if (!orderData || !serviceData) {
        console.error('Missing order data');
        return;
    }

    // Update service details
    document.getElementById('serviceSummary').innerHTML = `
        <p><strong>Service:</strong> ${serviceData.name}</p>
        <p><strong>Category:</strong> ${serviceData.category}</p>
        <p><strong>Service Price:</strong> ₱${serviceData.price.toFixed(2)}</p>
        <p><strong>Description:</strong> ${serviceData.description}</p>
    `;

    // Show design file info
    document.getElementById('designSummary').innerHTML = designFile ?
        `<p><strong>File:</strong> ${designFile}</p>` :
        '<p class="text-muted">No design file uploaded</p>';

    let totalItems = 0;
    let shirtTotal = 0;

    // Update table body with items from orderItems
    const tableBody = document.getElementById('summaryTableBody');
    if (orderItems && orderItems.items) {
        tableBody.innerHTML = orderItems.items.map(item => {
            const quantity = parseInt(item.quantity);
            const cost = parseFloat(item.cost);
            totalItems += quantity;
            shirtTotal += cost;

            return `
                <tr>
                    <td>${item.size}</td>
                    <td>${quantity}</td>
                    <td>₱${item.pricePerUnit.toFixed(2)}</td>
                    <td>₱${cost.toFixed(2)}</td>
                </tr>
            `;
        }).join('');
    }

    // Calculate grand total
    const grandTotal = shirtTotal + parseFloat(serviceData.price);

    // Update summary totals
    document.getElementById('totalItems').textContent = totalItems;
    document.getElementById('shirtTotal').textContent = `₱${shirtTotal.toFixed(2)}`;
    document.getElementById('servicePrice').textContent = `₱${serviceData.price.toFixed(2)}`;
    document.getElementById('grandTotal').textContent = `₱${grandTotal.toFixed(2)}`;

    // Store the complete order summary
    const orderSummary = {
        service: serviceData,
        items: orderItems?.items || [],
        design: designFile,
        totals: {
            totalItems: totalItems,
            shirtTotal: shirtTotal,
            servicePrice: parseFloat(serviceData.price),
            grandTotal: grandTotal
        }
    };
    sessionStorage.setItem('orderSummaryData', JSON.stringify(orderSummary));
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('#step4.active')) {
        displayOrderSummary();
    }
});
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------ STEP 5: Payment 💳 ------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//

document.addEventListener('DOMContentLoaded', function() {
    updatePaymentDetails('GCash');
});

function handlePaymentImageUpload(input) {
    const file = input.files[0];
    if (!file) return;    // Validate file size (500MB)
    if (file.size > 500 * 1024 * 1024) {
        alert('File size exceeds the maximum limit of 500MB');
        input.value = '';
        return;
    }

    // Validate file type
    if (!file.type.startsWith('image/')) {
        alert('Please upload an image file (JPG or PNG)');
        input.value = '';
        return;
    }

    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('paymentImagePreview');
        const placeholder = document.getElementById('uploadPlaceholder');
        
        preview.querySelector('img').src = e.target.result;
        preview.classList.remove('d-none');
        placeholder.classList.add('d-none');
    };
    reader.readAsDataURL(file);
}

function removePaymentImage() {
    const input = document.getElementById('paymentProof');
    const preview = document.getElementById('paymentImagePreview');
    const placeholder = document.getElementById('uploadPlaceholder');
    
    input.value = '';
    preview.classList.add('d-none');
    preview.querySelector('img').src = '';
    placeholder.classList.remove('d-none');
}

function updatePaymentDetails(method) {
    const detailsDiv = document.getElementById('paymentDetails');
    const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
    const amount = orderData?.totals?.grandTotal || 0;
    
    if (method === 'GCash') {
        detailsDiv.innerHTML = `
            <div class="payment-info">
                <div class="qr-code text-center mb-3">
                    <img src="../../../public/assets/images/gcash-qr.png" 
                         alt="GCash QR Code" class="img-fluid gcash-qr-sm">
                </div>
                <div class="account-details">
                    <p class="mb-2"><strong>Account Name:</strong> Sakuragi Tailoring</p>
                    <p class="mb-2"><strong>GCash Number:</strong> 09123456789</p>
                </div>
            </div>`;
    } else {
        detailsDiv.innerHTML = `
            <div class="payment-info">
                <div class="account-details">
                    <p class="mb-2"><strong>Bank:</strong> BDO</p>
                    <p class="mb-2"><strong>Account Name:</strong> Sakuragi Tailoring</p>
                    <p class="mb-2"><strong>Account Number:</strong> 1234 5678 9012</p>
                    <p class="mb-0 text-primary"><strong>Amount to Pay:</strong> ₱${amount.toFixed(2)}</p>
                </div>
            </div>`;
    }
}


//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//------------------------------------------ Progress Indicator 📍 ------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------------------------------------------------------------//


let currentStep = 1;
const totalSteps = 6;

function updateStepper() {
    const steps = document.querySelectorAll('.progress-step');
    const fillBar = document.querySelector('.progress-bar-fill');
    const stepBoxes = document.querySelectorAll('.step-box');

    steps.forEach((step, index) => {
        const circle = step.querySelector('.step-circle');
        if (index + 1 < currentStep) {
            circle.classList.add('completed');
            circle.classList.remove('active');
            step.classList.add('completed');
            step.classList.remove('active');
        } else if (index + 1 === currentStep) {
            circle.classList.add('active');
            circle.classList.remove('completed');
            step.classList.add('active');
            step.classList.remove('completed');
        } else {
            circle.classList.remove('completed', 'active');
            step.classList.remove('completed', 'active');
        }
    });

    let percentage = ((currentStep - 1) / (totalSteps - 1)) * 100;

    // Don't fill past Step 5
    if (currentStep === totalSteps) {
        percentage = ((totalSteps - 2) / (totalSteps - 1)) * 100;
    }

    if (fillBar) {
        if (window.innerWidth <= 576) {
            fillBar.style.height = percentage + '%';
            fillBar.style.width = '4px';
        } else {
            fillBar.style.width = percentage + '%';
            fillBar.style.height = '4px';
        }
    }


    // Show/hide the correct step content box
    stepBoxes.forEach((box, index) => {
        box.classList.toggle('active', index + 1 === currentStep);
    });

    // Enable/Disable Back button and update Next button text
    document.getElementById('prevBtn').disabled = currentStep === 1;
    document.getElementById('nextBtn').innerText = currentStep === totalSteps ? 'Finish' : 'Next';
}

function nextStep() {
    // Validate current step before proceeding
    if (currentStep === 3) {
        // Get service data from step 1
        const serviceData = JSON.parse(sessionStorage.getItem('selectedService'));

        // Get design file from step 2
        const designFile = sessionStorage.getItem('uploadedDesign');

        // Get size and quantity data from step 3
        const items = Array.from(document.querySelectorAll('#manualTableBody tr')).map(row => {
            const size = row.querySelector('select[name="size[]"]').value;
            const quantity = parseInt(row.querySelector('input[name="quantity[]"]').value) || 0;
            const cost = row.querySelector('.cost-cell').textContent;
            return {
                size,
                quantity,
                pricePerUnit: sizePrices[size],
                cost: cost.replace('₱', '')
            };
        });

        // Calculate totals
        const itemsTotal = items.reduce((sum, item) => sum + parseFloat(item.cost), 0);
        const servicePrice = parseFloat(serviceData.price);
        const grandTotal = itemsTotal + servicePrice;

        // Create complete order data
        const orderData = {
            service: serviceData,
            designFile: designFile,
            items: items,
            totals: {
                itemsTotal,
                servicePrice,
                grandTotal
            }
        };

        // Store in sessionStorage
        sessionStorage.setItem('orderSummaryData', JSON.stringify(orderData));

        // Validate required data
        if (!serviceData || items.length === 0) {
            alert('Please complete all required fields before proceeding');
            return;
        }

        // Proceed to next step
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepper();
            // If moving to step 4, update the summary
            if (currentStep === 4) {
                displayOrderSummary();
            }
        }
    } else if (currentStep === 4) {
        // Store payment method before proceeding
        const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;
        const paymentProof = document.getElementById('paymentProof')?.files[0];

        sessionStorage.setItem('paymentMethod', paymentMethod);
        if (paymentProof) {
            // Handle payment proof upload if needed
            const formData = new FormData();
            formData.append('payment_proof', paymentProof);
            // You can add upload logic here
        }

        if (currentStep < totalSteps) {
            currentStep++;
            updateStepper();
        }
    } else if (currentStep === 5) {
        // Submit final order and proceed to step 6
        submitFinalOrder().then(() => {
            currentStep++;
            updateStepper();
        }).catch(error => {
            console.error('Order submission failed:', error);
            alert('Failed to submit order. Please try again.');
        });
    } else {
        // Handle other steps
        if (currentStep < totalSteps) {
            currentStep++;
            updateStepper();
        }
    }
}

// Update submitFinalOrder to return a Promise
function submitFinalOrder() {
    return new Promise((resolve, reject) => {
        // Get all required data
        const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
        const paymentProof = document.getElementById('paymentProof')?.files[0];
        const referenceNumber = document.getElementById('referenceNumber')?.value.trim();

        if (!orderData) {
            reject('Missing order data');
            return;
        }

        if (!paymentProof) {
            reject('Please upload payment proof to continue');
            return;
        }

        // Create FormData
        const formData = new FormData();
        formData.append('orderData', JSON.stringify(orderData));

        if (paymentProof) {
            formData.append('payment_proof', paymentProof);
        }

        if (referenceNumber) {
            formData.append('reference_number', referenceNumber);
        }

        // Show loading state
        const submitBtn = document.getElementById('submitOrderBtn');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Processing...';
        }

        // Updated path to point to the controller
        fetch('../../../controller/customerController/submit_order.php', {
            method: 'POST',
            body: formData
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Server response:', data);
                if (data.success) {
                    // Clear session storage after successful order
                    sessionStorage.removeItem('orderSummaryData');
                    sessionStorage.removeItem('selectedService');
                    sessionStorage.removeItem('uploadedDesign');
                    resolve(data);
                } else {
                    reject(data.error || 'Failed to submit order');
                }
            })
            .catch(error => {
                console.error('Submit error:', error);
                reject(error.message || 'Network error occurred');
            })
            .finally(() => {
                // Reset button states
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Complete Order';
                }
            });
    });
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateStepper();
    }
}

document.addEventListener('DOMContentLoaded', updateStepper);

// Function to populate order summary in step 5
function populateStep5OrderSummary() {
    try {
        const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
        if (!orderData) return;

        // Update service details
        document.getElementById('selectedService').textContent = orderData.service.name;
        document.getElementById('servicePrice').textContent = `₱${orderData.totals.servicePrice.toFixed(2)}`;
        document.getElementById('serviceFee').textContent = `₱${orderData.totals.servicePrice.toFixed(2)}`;

        // Clear existing items table
        const tableBody = document.getElementById('orderItemsTable');
        tableBody.innerHTML = '';

        // Populate items table
        orderData.items.forEach(item => {
            if (item.quantity > 0) {
                const row = document.createElement('tr');
                const itemPrice = 100; // Base price per item
                const subtotal = item.quantity * itemPrice;

                row.innerHTML = `
                    <td>${item.size}</td>
                    <td>${item.quantity}</td>
                    <td>₱${itemPrice.toFixed(2)}</td>
                    <td>₱${subtotal.toFixed(2)}</td>
                `;
                tableBody.appendChild(row);
            }
        });

        // Update totals
        document.getElementById('totalItems').textContent = orderData.totals.totalItems;
        document.getElementById('itemsTotal').textContent = `₱${orderData.totals.shirtTotal.toFixed(2)}`;
        document.getElementById('grandTotal').textContent = `₱${orderData.totals.grandTotal.toFixed(2)}`;

        // Update payment amount
        const amountToPayElement = document.getElementById('amountToPay');
        if (amountToPayElement) {
            amountToPayElement.textContent = `₱${orderData.totals.grandTotal.toFixed(2)}`;
        }
    } catch (error) {
        console.error('Error populating order summary:', error);
    }
}

// Add to the existing handleStep function
function handleStep(stepNumber) {
    // ...existing code...

    if (stepNumber === 5) {
        populateStep5OrderSummary();
    }

}



// Update the updatePaymentAmount function
function updatePaymentAmount() {
    try {
        const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
        if (orderData && orderData.totals) {
            // Fetch service price and shirt total from session storage
            const servicePrice = orderData.totals.servicePrice || 0;
            const shirtTotal = orderData.totals.shirtTotal || 0;

            // Calculate the grand total
            const grandTotal = servicePrice + shirtTotal;

            // Update the displayed amount in Step 5
            const amountToPayElement = document.getElementById('amountToPay');
            if (amountToPayElement) {
                amountToPayElement.textContent = `₱${grandTotal.toFixed(2)}`;
            }
        }
    } catch (error) {
        console.error('Error updating payment amount:', error);
    }
}

// Clear or update orderSummaryData when a new order is initiated
function initializeNewOrder() {
    sessionStorage.removeItem('orderSummaryData');
}

document.addEventListener('DOMContentLoaded', () => {
    // Call initializeNewOrder when the user starts a new order
    if (document.querySelector('#step1.active')) {
        initializeNewOrder();
    }
});

// Update submitOrder function
function submitOrder() {
    const orderData = JSON.parse(sessionStorage.getItem('orderSummaryData'));
    const paymentProof = document.getElementById('paymentProof').files[0];
    const designFile = document.getElementById('image').files[0]; 
    const referenceNumber = document.getElementById('referenceNumber').value.trim();

    // Validate data
    if (!orderData || !orderData.service || !orderData.items) {
        showOrderStatus('error', 'Invalid order data');
        return;
    }

    if (!paymentProof) {
        showOrderStatus('error', 'Please upload payment proof');
        return;
    }

    if (!designFile) {
        showOrderStatus('error', 'Please upload a design file');
        return;
    }

    // Create FormData with proper structure
    const formData = new FormData();
    formData.append('orderData', JSON.stringify({
        service: {
            id: orderData.service.id,
            name: orderData.service.name,
            price: parseFloat(orderData.service.price)
        },
        items: orderData.items.map(item => ({
            size: item.size,
            quantity: parseInt(item.quantity),
            pricePerUnit: parseFloat(item.pricePerUnit)
        })),
        totals: {
            servicePrice: parseFloat(orderData.totals.servicePrice),
            shirtTotal: parseFloat(orderData.totals.shirtTotal),
            grandTotal: parseFloat(orderData.totals.grandTotal)
        }
    }));

    formData.append('payment_proof', paymentProof);
    formData.append('design_file', designFile);
    
    if (referenceNumber) {
        formData.append('reference_number', referenceNumber);
    }

    // Submit the order
    fetch('../../../controller/customerController/submit_order.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showOrderStatus('success', 'Order submitted successfully!');
            // Clear storage and redirect
            sessionStorage.clear();
            window.location.href = '../../../dashboards/customer/place_order_steps/step6_success.php';
        } else {
            throw new Error(data.error || 'Failed to submit order');
        }
    })
    .catch(error => {
        showOrderStatus('error', error.message);
    });
}