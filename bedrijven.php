<?php
$currentTable = "bedrijven";
$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "urenregister"; $dbport = 3306;
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli($servername, $username, $password, $dbname, $dbport);
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
</head>
<body data-current-table="bedrijven">

<div class="wrapper">
    <nav class="topnav">
        <div class="left"><a href="index.php"></a></div>
        <div class="right">
            <?php
            echo '<a class="table-link" href="homepagina.php">Homepagina</a>';
            echo '<a class="table-link" href="support_ticket_pagina.php">Support</a>';
            
            // Automatische navigatie voor alle tabellen
            if (!$conn->connect_error) {
                $tablesResult = $conn->query("SHOW TABLES");
                if ($tablesResult) {
                    while ($tableRow = $tablesResult->fetch_array()) {
                        $tableName = $tableRow[0];
                        $displayName = ucwords(str_replace('_', ' ', $tableName));
                        echo '<a class="table-link" href="' . htmlspecialchars($tableName) . '.php">' . htmlspecialchars($displayName) . '</a>';
                    }
                }
            }
            ?>
            <div class="search-container" role="search">
                <input id="searchInput" class="search-input" type="search" placeholder="Zoeken...">
                <button id="searchBtn" class="search-btn">Zoeken</button>
            </div>
            <button id="printBtn" class="print-btn"><i class="fas fa-file-pdf"></i></button>
            <button id="adminBtn" class="admin-btn-toggle"><i class="fas fa-lock"></i></button>
        </div>
    </nav>

    <main>
        <section class="hero-section">
            <div class="text"><h2>UrenRegistratieSysteem</h2></div>
        </section>

        <section class="team-data">
            <div class="text">
                <?php
                if (!$conn->connect_error) {
                    // Query met de JOIN die nu gegarandeerd werkt met je kolommen 'id' en 'naam'
                    $query = "SELECT b.id, b.naam, COUNT(o.Opdrachten_ID) as Totaal_Opdrachten
                              FROM bedrijven b
                              LEFT JOIN opdrachten o ON b.id = o.bedrijf_id
                              GROUP BY b.id";
                    
                    $result = $conn->query($query);
                    
                    echo '<section class="Data"><h2>Klanten Overzicht</h2>';
                    echo '<div class="table-wrapper"><table class="data-table"><thead><tr>';
                    echo '<th>ID</th><th>Bedrijfsnaam</th><th>Aantal Opdrachten</th>';
                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['naam']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Totaal_Opdrachten']) . '</td>';
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