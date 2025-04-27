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

