//Step 1: Service Selection

function selectService(service, element) {
    document.getElementById('selected_service').value = service;

    document.querySelectorAll('.service-card').forEach(card => {
        card.classList.remove('selected');
    });
    element.classList.add('selected');

    document.getElementById('step1NextBtn').disabled = false;
}


//step 2: Image Preview
function previewImage() {
    const file = document.getElementById('image').files[0];
    const reader = new FileReader();

    reader.onloadend = function () {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = reader.result;
        document.getElementById('imagePreviewContainer').style.display = 'block';
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreviewContainer').style.display = 'none';
    }
}
// ⭐ Step 3: Design Type Selection Logic
function selectDesignType(type) {
    // Update the radio buttons
    document.querySelectorAll('input[name="design_type"]').forEach(el => {
        el.checked = el.id === type;
    });

    // Update card selection styles
    document.querySelectorAll('.design-type-card').forEach(card => {
        card.classList.remove('selected');
    });
    document.querySelector(`label[for="${type}"]`).classList.add('selected');

    // Show/Hide sections
    document.getElementById('customizableSection').classList.toggle('d-none', type !== 'customizable');
    document.getElementById('nonCustomizableSection').classList.toggle('d-none', type !== 'standard');
}

// ⭐ Handle Excel Upload and Convert to Editable Table
function handleExcelUpload() {
    const file = document.getElementById('excelFile').files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
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
document.getElementById('excelSearch').addEventListener('keyup', function() {
    const filter = this.value.toLowerCase();
    document.querySelectorAll('#excelPreview table tbody tr').forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(filter) ? '' : 'none';
    });
});

// ⭐ Non-Customizable Manual Table Logic
function addManualRow() {
    const tbody = document.getElementById('manualTableBody');
    const newRow = `
        <tr>
            <td><input type="text" class="form-control" name="size[]" placeholder="e.g., M"></td>
            <td><input type="number" class="form-control" name="quantity[]" min="1" placeholder="e.g., 12"></td>
            <td><button class="btn btn-outline-danger btn-sm" onclick="removeManualRow(this)">Remove</button></td>
        </tr>`;
    tbody.insertAdjacentHTML('beforeend', newRow);
}

function removeManualRow(button) {
    button.closest('tr').remove();
}


//Progress Indicator

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

    const percentage = ((currentStep - 1) / (totalSteps - 1)) * 100;
    if (fillBar) {
        fillBar.style.width = percentage + '%';
        if (window.innerWidth <= 576) {
            // If mobile (vertical), adjust height instead of width
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
    if (currentStep < totalSteps) {
        currentStep++;
        updateStepper();
    }
}

function prevStep() {
    if (currentStep > 1) {
        currentStep--;
        updateStepper();
    }
}

document.addEventListener('DOMContentLoaded', updateStepper);
