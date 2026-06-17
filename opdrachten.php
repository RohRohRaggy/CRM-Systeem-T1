
<?php
// Automatisch gegenereerd bestand voor tabel: opdrachten
// Gegenereerd op: 2026-06-11 11:55:32
$currentTable = "opdrachten";
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>UrenRegistratieSysteem</title>
    <script src="searchfunction.js" defer></script>
    <script src="admin.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php
    if (!isset($currentTable)) { die('error: template moet worden geincluceerd met een tabelnaam'); }
    $currentTableName = preg_replace('/[^a-zA-Z0-9_]/', '', $currentTable);
    if (empty($currentTableName)) { header('Location: index.php'); exit; }
    ?>
</head>
<body data-current-table="<?php echo htmlspecialchars($currentTableName); ?>">

<div class="wrapper">
    <nav class="topnav">
        <div class="left"><a href="index.php"></a></div>
        <div class="right">
            <?php
            echo '<a class="table-link" href="homepagina.php">Homepagina</a>';
            echo '<a class="table-link" href="support_ticket_pagina.php">Support</a>';
            $servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "urenregister"; $dbport = 3306;
            mysqli_report(MYSQLI_REPORT_OFF);
            $conn = @new mysqli($servername, $username, $password, $dbname, $dbport);
            if (!$conn->connect_error) {
                $tablesResult = $conn->query("SHOW TABLES");
                if ($tablesResult && $tablesResult->num_rows > 0) {
                    while ($tableRow = $tablesResult->fetch_array()) {
                        $tableName = $tableRow[0];
                        $displayName = ucwords(str_replace('_', ' ', $tableName));
                        echo '<a class="table-link" href="' . htmlspecialchars($tableName) . '.php">' . htmlspecialchars($displayName) . '</a>';
                    }
                }
            }
            ?>
            <div class="search-container" role="search" aria-label="Zoek categorieën">
                <input id="searchInput" class="search-input" type="search" placeholder="Zoeken...">
                <button id="searchBtn" class="search-btn">Zoeken</button>
            </div>
            <button id="printBtn" class="print-btn"><i class="fas fa-file-pdf"></i></button>
            <button id="adminBtn" class="admin-btn-toggle"><i class="fas fa-lock"></i></button>
        </div>
    </nav>

    <main>
        <section class="hero-section<?php echo $currentTableName === 'homepagina' ? ' homepage-hero' : ''; ?>">
            <div class="text">
                <h2>UrenRegistratieSysteem</h2>
            </div>
        </section>

        <section class="team-data">
            <div class="text">
                <?php
                if (!$conn->connect_error && $currentTableName !== 'homepagina') {
                    $tableParam = $currentTableName;
                    // Kolom 'Factuur' toegevoegd aan de lijst
                    $columns = ["Opdrachten_ID", "Titel", "naam", "Factuur"];
                    
                    $result = $conn->query("SELECT o.Opdrachten_ID, o.Titel, b.naam FROM opdrachten as o
                        JOIN bedrijven as b ON b.id=o.bedrijf_id
                    ");
                    
                    echo '<section class="Data"><h2>' . htmlspecialchars($tableParam) . '</h2>';
                    echo '<div class="table-wrapper"><table class="data-table"><thead><tr>';
                    foreach ($columns as $column) { echo '<th>' . htmlspecialchars($column) . '</th>'; }
                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($columns as $column) { 
                            if ($column === 'Factuur') {
                                // De knop die koppelt aan factuur.php via opdracht_id
                                echo '<td><a href="factuur.php?opdracht_id=' . urlencode($row['Opdrachten_ID']) . '"><i class="fas fa-file-invoice"></i></a></td>';
                            } else {
                                echo '<td>' . htmlspecialchars($row[$column] ?? '') . '</td>';
                            }
                        }                
                        echo '</tr>';
                    }
                    echo '</tbody></table></div></section>';
                }
                ?>
            </div>
        </section>

        <footer class="footer"><p>©TEAM 2 [2026]</p></footer>
    </main>
</div>
</body>
</html>