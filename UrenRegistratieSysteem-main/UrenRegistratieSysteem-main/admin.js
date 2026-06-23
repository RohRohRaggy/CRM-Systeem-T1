// Centrale statusvlaggen voor de rollen
let adminMode = false;
let employeeMode = false;

// Initialiseer de beheerknop en herstel eerdere beheerstatus vanuit localStorage.
const initAdminButton = () => {
    const adminBtn = document.getElementById('adminBtn');
    if (!adminBtn) return;

    // Herstel status vanuit localStorage bij pagina herladen
    if (localStorage.getItem('adminModeEnabled') === 'true') {
        enableAdminMode(true);
    } else if (localStorage.getItem('employeeModeEnabled') === 'true') {
        enableEmployeeMode(localStorage.getItem('loggedInUserId'), true);
    }

    adminBtn.addEventListener("click", async () => {
        if (!adminMode && !employeeMode) {
            const username = prompt("Voer je werkmail in:");
            if (!username) return;

            const password = prompt("Voer je wachtwoord in:");
            if (!password) return;

            // Stuur de gegevens naar de server voor controle in de database
            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('username', username);
            formData.append('password', password);

            try {
                const response = await fetch('admin_handler.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();

                if (result.success) {
                    // Check welke rol de database heeft teruggegeven
                    if (result.role === 'admin') {
                        enableAdminMode();
                    } else if (result.role === 'medewerker') {
                        enableEmployeeMode(result.medewerker_id);
                    }
                } else {
                    alert(result.error || "Inloggen mislukt");
                }
            } catch (error) {
                console.error("Login error:", error);
                alert("Er is iets fout gegaan bij het inloggen");
            }
        } else {
            disableModes();
        }
    });
};

// Schakel Adminmodus in (Volledige rechten)
const enableAdminMode = (skipAlert = false) => {
    adminMode = true;
    localStorage.setItem('adminModeEnabled', 'true');
    document.body.classList.add('admin-mode');

    updateButtonStyle('#27ae60', 'Beheermodus verlaten');
    makeTableEditable();
    addAdminControls(); // Krijgt alle beheertools

    if (!skipAlert) alert('Beheermodus ingeschakeld (Admin)!');
};

// Schakel Medewerkermodus in (Beperkte rechten tot eigen rij)
const enableEmployeeMode = (userId, skipAlert = false) => {
    employeeMode = true;
    localStorage.setItem('employeeModeEnabled', 'true');
    localStorage.setItem('loggedInUserId', userId); // Onthoud wie er is ingelogd
    document.body.classList.add('employee-mode');

    updateButtonStyle('#2980b9', 'Medewerkermodus verlaten');
    makeTableEditable(); 

    if (!skipAlert) alert('Medewerkermodus ingeschakeld!');
};

// Hulpfunctie voor de stijl van de lock-knop
const updateButtonStyle = (color, title) => {
    const adminBtn = document.getElementById('adminBtn');
    if (adminBtn) {
        adminBtn.innerHTML = '<i class="fas fa-lock-open"></i>';
        adminBtn.style.background = `linear-gradient(135deg, ${color} 0%, #2c3e50 100%)`;
        adminBtn.style.boxShadow = `0 4px 12px ${color}66`;
        adminBtn.title = title;
    }
};

// Schakel alle modi uit en herstel de pagina
const disableModes = () => {
    adminMode = false;
    employeeMode = false;
    localStorage.removeItem('adminModeEnabled');
    localStorage.removeItem('employeeModeEnabled');
    localStorage.removeItem('loggedInUserId'); // Wis het opgeslagen ID
    document.body.classList.remove('admin-mode', 'employee-mode');

    const adminBtn = document.getElementById('adminBtn');
    if (adminBtn) {
        adminBtn.innerHTML = '<i class="fas fa-lock"></i>';
        adminBtn.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
        adminBtn.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.4)';
        adminBtn.title = 'Inloggen';
    }

    location.reload();
};

// Markeer de toegestane tabelcellen als bewerkbaar en sla wijzigingen op.
const makeTableEditable = () => {
    const table = document.querySelector('.data-table');
    if (!table) return;

    const loggedInUserId = localStorage.getItem('loggedInUserId');
    const cells = table.querySelectorAll('tbody td');
    
    cells.forEach(cell => {
        const row = cell.closest('tr');
        const idCell = row.querySelector('td:first-child');
        const rowIdValue = idCell.textContent.trim();

        // Als je een gewone medewerker bent, mag je ALLEEN je eigen medewerker_ID bewerken
        if (employeeMode && rowIdValue !== loggedInUserId) {
            cell.contentEditable = false;
            return; // Sla deze cel over, wordt niet bewerkbaar
        }

        // Admins en de medewerker zelf krijgen wel toegang tot de cellen
        cell.contentEditable = true;
        cell.classList.add('editable-cell');

        cell.addEventListener('blur', async function () {
            const cellIndex = Array.from(row.children).indexOf(this);
            const headerCell = table.querySelector(`thead th:nth-child(${cellIndex + 1})`);
            const columnName = headerCell.dataset.column;
            const tableName = document.body.dataset.currentTable;
            const newValue = this.textContent.trim();

            const success = await updateCell(tableName, columnName, newValue, rowIdValue);
            if (success) {
                this.classList.add('cell-updated');
                setTimeout(() => this.classList.remove('cell-updated'), 1000);
            } else {
                alert('Bijwerken van cel mislukt');
            }
        });
    });
};

// Verstuur een celwijziging naar de server en geef terug of het bijwerken is geslaagd.
const updateCell = async (table, column, value, idValue) => {
    try {
        const formData = new FormData();
        formData.append('action', 'update_cell');
        formData.append('table', table);
        formData.append('column', column);
        formData.append('value', value);
        formData.append('id_column', 'medewerker_ID'); // Koppeling met jouw database identifier
        formData.append('id_value', idValue);

        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        return result.success;
    } catch (error) {
        console.error('Update error:', error);
        return false;
    }
};

// Voeg de volledige beheertoolbar in aan het begin van de data-sectie.
const addAdminControls = () => {
    const dataSection = document.querySelector('section.Data');
    if (!dataSection) return;

    const controlsDiv = document.createElement('div');
    controlsDiv.className = 'admin-controls';
    controlsDiv.innerHTML = `
        <div class="admin-buttons">
            <button class="admin-btn" onclick="addNewRow()">
                <i class="fas fa-plus"></i> Rij toevoegen
            </button>
            <button class="admin-btn" onclick="showDeleteRowDialog()">
                <i class="fas fa-trash"></i> Rij verwijderen
            </button>
            <button class="admin-btn" onclick="showAddColumnDialog()">
                <i class="fas fa-columns"></i> Kolom toevoegen
            </button>
            <button class="admin-btn" onclick="showDeleteColumnDialog()">
                <i class="fas fa-minus"></i> Kolom verwijderen
            </button>
            <button class="admin-btn" onclick="showCreateTableDialog()">
                <i class="fas fa-table"></i> Nieuwe tabel
            </button>
            <button class="admin-btn danger" onclick="showDeleteTableDialog()">
                <i class="fas fa-exclamation-triangle"></i> Tabel verwijderen
            </button>
            <button class="admin-btn" onclick="regeneratePages()">
                <i class="fas fa-sync"></i> Pagina's opnieuw genereren
            </button>
        </div>
    `;

    dataSection.insertBefore(controlsDiv, dataSection.firstChild);
};

// Verwijder de beheerknoppen uit de DOM wanneer adminmodus uitgaat.
const removeAdminControls = () => {
    const controls = document.querySelector('.admin-controls');
    if (controls) {
        controls.remove();
    }
};

// Voeg een lege rij toe aan de huidige tabel.
const addNewRow = async () => {
    const tableName = document.body.dataset.currentTable;
    if (!tableName) return;

    const formData = new FormData();
    formData.append('action', 'add_row');
    formData.append('table', tableName);

    try {
        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert('Rij toevoegen mislukt: ' + result.error);
        }
    } catch (error) {
        alert('Fout bij toevoegen van rij');
    }
};

// Vraag de gebruiker om een rij-id en bevestig verwijdering.
const showDeleteRowDialog = () => {
    const rowId = prompt('Voer de ID in van de rij die je wilt verwijderen:');
    if (!rowId) return;

    if (confirm(`Weet je zeker dat je de rij met ID ${rowId} wilt verwijderen?`)) {
        deleteRow(rowId);
    }
};

// Verwijder een specifieke rij op basis van de opgegeven id.
const deleteRow = async (idValue) => {
    const tableName = document.body.dataset.currentTable;

    const formData = new FormData();
    formData.append('action', 'delete_row');
    formData.append('table', tableName);
    formData.append('id_column', 'medewerker_ID'); 
    formData.append('id_value', idValue);

    try {
        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert('Rij verwijderen mislukt: ' + result.error);
        }
    } catch (error) {
        alert('Fout bij verwijderen van rij');
    }
};

// Dialoog voor toevoegen van een nieuwe kolom inclusief datatype.
const showAddColumnDialog = () => {
    const columnName = prompt('Voer een nieuwe kolomnaam in (bijv. email, telefoon):');
    if (!columnName) return;

    const columnType = prompt('Voer kolomtype in (standaard: VARCHAR(255)):', 'VARCHAR(255)');
    if (!columnType) return;

    addColumn(columnName, columnType);
};

// Voeg een kolom toe aan de huidige tabelstructuur via backendactie.
const addColumn = async (columnName, columnType) => {
    const tableName = document.body.dataset.currentTable;

    const formData = new FormData();
    formData.append('action', 'add_column');
    formData.append('table', tableName);
    formData.append('column_name', columnName);
    formData.append('column_type', columnType);

    try {
        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert('Kolom toevoegen mislukt: ' + result.error);
        }
    } catch (error) {
        alert('Fout bij toevoegen van kolom');
    }
};

// Dialoog voor het verwijderen van een kolom met extra bevestiging.
const showDeleteColumnDialog = () => {
    const columnName = prompt('Voer de naam in van de kolom die je wilt verwijderen:');
    if (!columnName) return;

    if (confirm(`Weet je zeker dat je kolom "${columnName}" wilt verwijderen? Dit kan niet ongedaan worden gemaakt!`)) {
        deleteColumn(columnName);
    }
};

// Verwijder kolom uit de huidige tabel.
const deleteColumn = async (columnName) => {
    const tableName = document.body.dataset.currentTable;

    const formData = new FormData();
    formData.append('action', 'delete_column');
    formData.append('table', tableName);
    formData.append('column_name', columnName);

    try {
        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        if (result.success) {
            location.reload();
        } else {
            alert('Kolom verwijderen mislukt: ' + result.error);
        }
    } catch (error) {
        alert('Fout bij verwijderen van kolom');
    }
};

// Vraag een nieuwe tabelnaam en bevestig de creatie.
const showCreateTableDialog = () => {
    const tableName = prompt('Voer een nieuwe tabelnaam in (bijv. projecten, klanten):');
    if (!tableName) return;

    if (confirm(`Nieuwe tabel "${tableName}" maken met standaardkolommen (id, naam, aangemaakt_op)?`)) {
        createTable(tableName);
    }
};

// Maak een nieuwe tabel aan en navigeer daarna naar de nieuw aangemaakte pagina.
const createTable = async (tableName) => {
    const formData = new FormData();
    formData.append('action', 'create_table');
    formData.append('table_name', tableName);

    try {
        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        if (result.success) {
            await regeneratePagesQuietly();
            alert('Tabel gemaakt! In beheermodus kunnen rijen en kolommen worden beheerd.');
            window.location.href = `${tableName}.php`;
        } else {
            alert('Tabel maken mislukt: ' + result.error);
        }
    } catch (error) {
        alert('Fout bij maken van tabel');
    }
};

// Voer paginaregeneratie uit zonder extra meldingen; nuttig voor interne flows.
const regeneratePagesQuietly = async () => {
    try {
        const response = await fetch('generate_pages.php', {
            method: 'POST'
        });
        const result = await response.json();
        return result.success;
    } catch (error) {
        console.error('Stille regeneratiefout:', error);
        return false;
    }
};

// Bevestigingsstap voor verwijderen van complete tabel.
const showDeleteTableDialog = () => {
    const tableName = document.body.dataset.currentTable;

    const confirmation = prompt(`Typ "${tableName}" om het verwijderen van deze tabel te bevestigen:`);
    if (confirmation !== tableName) {
        alert('Tabelnaam komt niet overeen. Verwijderen geannuleerd.');
        return;
    }

    deleteTable(tableName);
};

// Verwijder de tabel in de database, regenereer pagina's en ga terug naar de startpagina.
const deleteTable = async (tableName) => {
    const formData = new FormData();
    formData.append('action', 'delete_table');
    formData.append('table_name', tableName);

    try {
        const response = await fetch('admin_handler.php', {
            method: 'POST', body: formData
        });

        const result = await response.json();
        if (result.success) {
            await regeneratePagesQuietly();

            await deletePhysicalFile(tableName);

            alert('Tabel succesvol verwijderd!');
            window.location.href = 'index.php';
        } else {
            alert('Tabel verwijderen mislukt: ' + result.error);
        }
    } catch (error) {
        alert('Fout bij verwijderen van tabel');
    }
};

// Probeer het fysieke paginabestand te verwijderen dat bij de tabel hoort.
const deletePhysicalFile = async (tableName) => {
    try {
        const formData = new FormData();
        formData.append('action', 'delete_file');
        formData.append('file_name', `${tableName}.php`);

        await fetch('admin_handler.php', {method: 'POST', body: formData});
    } catch (error) {
        console.error('Fout bij verwijderen van bestand:', error);

    }
};

// Initialiseer beheermodusfunctionaliteit zodra de DOM beschikbaar is.
document.addEventListener('DOMContentLoaded', () => {
    initAdminButton();
});

// Handmatige beheertaak: alle tabelpagina's opnieuw opbouwen en verweesde bestanden opruimen.

const regeneratePages = async () => {
    if (!confirm('Dit genereert alle tabelpagina\'s opnieuw en ruimt ongebruikte bestanden op. Doorgaan?')) {
        return;
    }

    try {
        const response = await fetch('generate_pages.php', {
            method: 'POST'
        });

        const result = await response.json();

        if (result.success) {
            let message = `Gelukt!\n\n${result.count} paginabestand(en) gegenereerd:\n${result.files.join('\n')}`;

            if (result.deletedCount > 0) {
                message += `\n\n${result.deletedCount} ongebruikt(e) bestand(en) opgeschoond:\n${result.deleted.join('\n')}`;
            }

            alert(message);
            location.reload();
        } else {
            alert('Pagina\'s opnieuw genereren mislukt: ' + result.error);
        }
    } catch (error) {
        console.error('Regeneration error:', error);
        alert('Fout bij opnieuw genereren van pagina\'s');
    }
};