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
