<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sakuragi Order Wizard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Trigger Button -->
  <div class="p-6">
    <button onclick="toggleModal(true)" class="bg-blue-600 text-white px-6 py-2 rounded">Place New Order</button>
  </div>

  <!-- Modal -->
  <div id="orderModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
      <h2 class="text-xl font-bold mb-4">Place Your Custom Order</h2>

      <!-- Stepper -->
      <div id="steps" class="space-y-6">

        <!-- Step 1 -->
        <div class="step">
          <label class="block font-semibold mb-1">Step 1: Select a Service</label>
          <select class="w-full p-2 border rounded">
            <option disabled selected>Select service</option>
            <option>Embroidery</option>
            <option>Sublimation</option>
            <option>Screen Printing</option>
            <option>Alterations</option>
            <option>Patch Creation</option>
          </select>
        </div>

        <!-- Step 2 -->
        <div class="step hidden">
          <label class="block font-semibold mb-1">Step 2: Upload PSD File</label>
          <input type="file" accept=".psd" class="w-full p-2 border rounded">
        </div>

        <!-- Step 3 -->
        <div class="step hidden">
          <label class="block font-semibold mb-1">Step 3: Is the design customizable?</label>
          <div class="flex items-center gap-4 mb-3">
            <label><input type="radio" name="customizable" value="yes" class="mr-1"> Yes</label>
            <label><input type="radio" name="customizable" value="no" class="mr-1"> No</label>
          </div>

          <div id="customTable" class="hidden overflow-auto">
            <table class="w-full border text-sm mb-2" id="customTableMain">
              <thead>
                <tr id="headerRow" class="bg-gray-100">
                  <th class="border p-2">#</th>
                  <th class="border p-2" contenteditable="true">Name</th>
                  <th class="border p-2" contenteditable="true">Position</th>
                  <th class="border p-2">Actions</th>
                </tr>
              </thead>
              <tbody id="customData"></tbody>
            </table>
            <div class="flex gap-2">
              <button onclick="addRow()" class="bg-blue-500 text-white px-3 py-1 rounded">+ Row</button>
              <button onclick="addColumn()" class="bg-indigo-500 text-white px-3 py-1 rounded">+ Column</button>
            </div>
          </div>
        </div>

        <!-- Step 4 -->
        <div class="step hidden">
          <label class="block font-semibold mb-1">Step 4: Order Summary</label>
          <div class="bg-gray-50 p-4 border rounded">
            <p><strong>Estimated Total:</strong> ₱2,499.00</p>
            <p><strong>Items:</strong> 20 Custom Officer Shirts</p>
          </div>
        </div>

        <!-- Step 5 -->
        <div class="step hidden">
          <label class="block font-semibold mb-1">Step 5: Payment Method</label>
          <select class="w-full p-2 border rounded mb-4">
            <option disabled selected>Select payment option</option>
            <option>Full Payment (GCash)</option>
            <option>Full Payment (Cash)</option>
            <option>50% Downpayment, 50% on Delivery</option>
          </select>
          <button class="bg-green-600 text-white py-2 px-4 rounded w-full">Submit Order</button>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-between items-center mt-6">
        <button id="prevBtn" onclick="prevStep()" class="px-4 py-2 bg-gray-300 rounded" disabled>Back</button>
        <button id="nextBtn" onclick="nextStep()" class="px-4 py-2 bg-blue-600 text-white rounded">Next</button>
      </div>

      <!-- Close -->
      <button onclick="toggleModal(false)" class="absolute top-2 right-4 text-gray-500 hover:text-red-600 text-xl">&times;</button>
    </div>
  </div>

  <script>
    let step = 0;
    const steps = document.querySelectorAll(".step");
    const nextBtn = document.getElementById("nextBtn");
    const prevBtn = document.getElementById("prevBtn");

    function showStep(index) {
      steps.forEach((el, i) => el.classList.toggle("hidden", i !== index));
      prevBtn.disabled = index === 0;
      nextBtn.innerText = index === steps.length - 2 ? "Review" : index === steps.length - 1 ? "Close" : "Next";
    }

    function nextStep() {
      if (step < steps.length - 1) step++;
      showStep(step);
    }

    function prevStep() {
      if (step > 0) step--;
      showStep(step);
    }

    function toggleModal(open) {
      document.getElementById("orderModal").classList.toggle("hidden", !open);
      if (open) {
        step = 0;
        showStep(step);
      }
    }

    // Show/hide table on radio click
    document.querySelectorAll('input[name="customizable"]').forEach(radio => {
      radio.addEventListener('change', () => {
        document.getElementById('customTable').style.display = radio.value === 'yes' ? 'block' : 'none';
      });
    });

    // Add row to table
    function addRow() {
      const tableBody = document.getElementById('customData');
      const columnCount = document.getElementById('headerRow').children.length - 2;
      let rowHTML = `<tr><td class="border p-2 text-center">${tableBody.rows.length + 1}</td>`;
      for (let i = 0; i < columnCount; i++) {
        rowHTML += `<td class="border p-2"><input class="w-full border p-1" placeholder="Input" /></td>`;
      }
      rowHTML += `<td class="border p-2 text-center"><button onclick="this.closest('tr').remove()">🗑️</button></td></tr>`;
      tableBody.insertAdjacentHTML('beforeend', rowHTML);
    }

    // Add column to table
    function addColumn() {
      const newColName = prompt("Enter column name:", "New Field");
      if (!newColName) return;

      const headerRow = document.getElementById('headerRow');
      const newTh = document.createElement("th");
      newTh.className = "border p-2";
      newTh.contentEditable = true;
      newTh.innerText = newColName;
      headerRow.insertBefore(newTh, headerRow.lastElementChild);

      document.querySelectorAll("#customData tr").forEach(row => {
        const newTd = document.createElement("td");
        newTd.className = "border p-2";
        newTd.innerHTML = `<input class="w-full border p-1" placeholder="Input" />`;
        row.insertBefore(newTd, row.lastElementChild);
      });
    }
  </script>

</body>
</html>
