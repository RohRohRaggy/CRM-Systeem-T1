<?php
// Database verbinding
$servername = "127.0.0.1"; $username = "root"; $password = ""; $dbname = "urenregister"; $dbport = 3306;
mysqli_report(MYSQLI_REPORT_OFF);
$conn = @new mysqli($servername, $username, $password, $dbname, $dbport);

$currentTable = "klanten";
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
<body data-current-table="klanten">

<div class="wrapper">
    <nav class="topnav">
        <div class="left"><a href="index.php"></a></div>
        <div class="right">
            <?php
            echo '<a class="table-link" href="homepagina.php">Homepagina</a>';
            echo '<a class="table-link" href="support_ticket_pagina.php">Support</a>';
            
            // Automatische navigatie zoals in je andere bestanden
            if (!$conn->connect_error) {
                $tablesResult = $conn->query("SHOW TABLES");
                while ($tableRow = $tablesResult->fetch_array()) {
                    $tableName = $tableRow[0];
                    $displayName = ucwords(str_replace('_', ' ', $tableName));
                    echo '<a class="table-link" href="' . htmlspecialchars($tableName) . '.php">' . htmlspecialchars($displayName) . '</a>';
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
                <section class="Data"><h2>Klanten Overzicht</h2>
                <?php
                if (!$conn->connect_error) {
                    // De JOIN query die de brug slaat tussen klanten en bedrijven
                    $query = "SELECT k.klanten_ID, k.Voornaam, k.Tussenvoegsel, k.Achternaam, k.functie, k.email, k.PhoneNumber, b.naam AS Bedrijfsnaam
                              FROM klanten k
                              LEFT JOIN bedrijven b ON k.bedrijf_id = b.id";
                    
                    $result = $conn->query($query);
                    
                    echo '<div class="table-wrapper"><table class="data-table"><thead><tr>';
                    echo '<th>ID</th><th>Naam</th><th>Functie</th><th>Bedrijf</th><th>Email</th><th>Telefoon</th>';
                    echo '</tr></thead><tbody>';

                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($row['klanten_ID']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Voornaam'] . ' ' . $row['Tussenvoegsel'] . ' ' . $row['Achternaam']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['functie']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['Bedrijfsnaam']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['email']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['PhoneNumber']) . '</td>';
                        echo '</tr>';
                    }
                    echo '</tbody></table></div>';
                }
                ?>
                </section>
            </div>
        </section>
        <footer class="footer"><p>©TEAM 2 [2026]</p></footer>
    </main>
</div>
</body>
</html>