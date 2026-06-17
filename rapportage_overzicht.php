<?php
$conn = new mysqli("127.0.0.1", "root", "", "UrenRegister", 3306);
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Dashboard Rapportage</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Specifieke dashboard styling die bovenop je style.css komt */
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px; padding: 20px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .card h3 { color: #555; border-bottom: 2px solid #004d26; padding-bottom: 10px; }
        .highlight { font-size: 2em; color: #004d26; font-weight: bold; margin: 10px 0; }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .data-table th { background-color: #004d26; color: white; padding: 12px; text-align: left; }
        .data-table td { padding: 12px; border-bottom: 1px solid #ddd; }
        .back-btn-container { text-align: center; margin: 30px; }
        .footer {position: fixed; bottom: 0; width: 100%;  text-align: center; padding: 10px 0;}
    </style>
</head>
<body>

<div class="wrapper">
    <main>
        <h1>Dashboard Rapportage</h1>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Uren per maand</h3>
                <table class="data-table">
                    <tr><th>Maand</th><th>Uren</th><th>Omzet</th></tr>
                    <?php
                    $res = $conn->query("SELECT * FROM rapportage_overzicht ORDER BY maand ASC");
                    while($r = $res->fetch_assoc()) {
                        echo "<tr><td>{$r['maand']}</td><td>{$r['totaal_uren']}</td><td>€{$r['totale_omzet']}</td></tr>";
                    }
                    ?>
                </table>
            </div>

            <div class="card">
                <h3>Totale Jaaromzet</h3>
                <?php
                $res = $conn->query("SELECT SUM(totale_omzet) as total FROM rapportage_overzicht");
                $r = $res->fetch_assoc();
                echo "<div class='highlight'>€ " . number_format($r['total'], 2) . "</div>";
                ?>
            </div>

            <div class="card">
                <h3>Gemiddelde uren p/m</h3>
                <?php
                $res = $conn->query("SELECT AVG(totaal_uren) as avg_u FROM rapportage_overzicht");
                $r = $res->fetch_assoc();
                echo "<div class='highlight'>" . round($r['avg_u'], 1) . " uur</div>";
                ?>
            </div>

            <div class="card">
                <h3>Aantal actieve maanden</h3>
                <?php
                $res = $conn->query("SELECT COUNT(*) as count FROM rapportage_overzicht");
                $r = $res->fetch_assoc();
                echo "<div class='highlight'>" . $r['count'] . "</div>";
                ?>
            </div>

            
        </div>

        <div class="back-btn-container">
            <a href="homepagina.php" class="search-btn">Terug naar menu</a>
        </div>
        
    </main>
    
</div>
<footer class="footer"><p>©TEAM 1 [2026]</p></footer>

</body>
</html>