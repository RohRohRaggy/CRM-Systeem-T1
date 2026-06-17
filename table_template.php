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
    if (!isset($currentTable)) {
        die('error: template moet worden geincluceerd met een tabelnaam');
    }
    $currentTableName = preg_replace('/[^a-zA-Z0-9_]/', '', $currentTable);
    if (empty($currentTableName)) {
        header('Location: index.php');
        exit;
    }
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
                <?php if ($currentTableName === 'homepagina'): ?>
                    <div class="welcome-card"><h2>Welkom!</h2><p>Gebruik de tabbladen om naar gegevens te gaan.</p></div>
                <?php else: ?>
                    <h2>UrenRegistratieSysteem</h2>
                <?php endif; ?>
            </div>
        </section>

        <section class="team-data">
            <div class="text">
                <?php
                if (!$conn->connect_error && $currentTableName !== 'homepagina') {
                    $tableParam = $currentTableName;
                    $columnsResult = $conn->query("SHOW COLUMNS FROM `$tableParam`");
                    $columns = [];
                    while ($col = $columnsResult->fetch_assoc()) { $columns[] = $col['Field']; }

                    $result = $conn->query("SELECT * FROM `$tableParam`");
                    
                    echo '<section class="Data"><h2>' . htmlspecialchars($tableParam) . '</h2>';
                    echo '<div class="table-wrapper"><table class="data-table"><thead><tr>';
                    foreach ($columns as $column) { echo '<th>' . htmlspecialchars($column) . '</th>'; }
                    
                    // Alleen kop 'Factuur' bij medewerkers
                    if ($currentTableName === 'medewerkers') { echo '<th>Factuur</th>'; }
                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        foreach ($columns as $column) { echo '<td>' . htmlspecialchars($row[$column] ?? '') . '</td>'; }
                        
                        // Alleen knop 'Factuur' bij medewerkers
                        if ($currentTableName === 'medewerkers') {
                            echo '<td><a href="factuur.php?medewerker_ID=' . urlencode(reset($row)) . '"><i class="fas fa-file-invoice"></i></a></td>';
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