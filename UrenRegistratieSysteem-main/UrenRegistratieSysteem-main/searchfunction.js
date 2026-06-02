// Eenvoudige zoekfunctie: alleen jouw geplakte snippet (search -> filter rows)
document.addEventListener('DOMContentLoaded', () => {
    const search = document.getElementById('search') || document.getElementById('searchInput');
    if (!search) {
        console.warn('Geen zoekinput gevonden: verwacht id="search" of id="searchInput"');
        return;
    }

    const getRows = () => document.querySelectorAll('#dataTable tbody tr, .data-table tbody tr');

    search.addEventListener('input', function () {
        const val = (this.value || '').toLowerCase();
        const rows = getRows();

        rows.forEach(row => {
            row.style.display = row.textContent.toLowerCase().includes(val) ? '' : 'none';
        });
    });
});