// Eenvoudige zoekfunctie: alleen jouw geplakte snippet (search -> filter rows)
document.addEventListener('DOMContentLoaded', () => {
    const search = document.getElementById('search') || document.getElementById('searchInput');
    const getRows = () => document.querySelectorAll('#dataTable tbody tr, .data-table tbody tr');

    if (search) {
        search.addEventListener('input', function () {
            const val = (this.value || '').toLowerCase();
            const rows = getRows();

            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
            });
        });
    } else {
        console.warn('Geen zoekinput gevonden: verwacht id="search" of id="searchInput"');
    }

    const printBtn = document.getElementById('printBtn');
    if (printBtn) {
        printBtn.addEventListener('click', () => {
            document.body.classList.add('print-mode');
            window.print();
            setTimeout(() => {
                document.body.classList.remove('print-mode');
            }, 100);
        });
    }
}); 