// tables.js

// Generic search by row text content
function filterTableBySearch(inputId, tableId) {
    const input = document.getElementById(inputId).value.toLowerCase();
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);

    rows.forEach(row => {
        const rowText = row.textContent.toLowerCase();
        row.style.display = rowText.includes(input) ? "" : "none";
    });
}

// Filter by status column (expects <span class="status"> text)
function filterTableByStatus(selectId, tableId, statusClass = "status") {
    const selected = document.getElementById(selectId).value.toLowerCase();
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);

    rows.forEach(row => {
        const status = row.querySelector(`.${statusClass}`);
        const value = status ? status.textContent.toLowerCase() : "";
        row.style.display = selected === "" || value === selected ? "" : "none";
    });
}

// Sort table column (basic text sort)
function sortTableByColumn(tableId, columnIndex) {
    const table = document.getElementById(tableId);
    const rows = Array.from(table.rows).slice(1);
    let switching = true;
    let dir = "asc";

    while (switching) {
        switching = false;
        for (let i = 0; i < rows.length - 1; i++) {
            let x = rows[i].cells[columnIndex].innerText.toLowerCase();
            let y = rows[i + 1].cells[columnIndex].innerText.toLowerCase();
            let shouldSwitch = dir === "asc" ? x > y : x < y;

            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                break;
            }
        }
        if (!switching && dir === "asc") {
            dir = "desc";
            switching = true;
        }
    }
}

// Export to CSV
function exportTableToCSV(tableId, filename = "export.csv") {
    const rows = document.querySelectorAll(`#${tableId} tr`);
    const csv = [];

    rows.forEach(row => {
        const cols = row.querySelectorAll("th, td");
        const rowData = Array.from(cols).map(col => `"${col.innerText.trim()}"`);
        csv.push(rowData.join(","));
    });

    const blob = new Blob([csv.join("\n")], { type: "text/csv" });
    const url = URL.createObjectURL(blob);
    const a = document.createElement("a");
    a.href = url;
    a.download = filename;
    a.click();
    URL.revokeObjectURL(url);
}
