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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 20px; padding: 20px; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); min-height: 300px; }
        .card h3 { color: #555; border-bottom: 2px solid #004d26; padding-bottom: 10px; margin-bottom: 20px; }
        .highlight { font-size: 2em; color: #004d26; font-weight: bold; }
        .back-btn-container { text-align: center; margin: 30px; }
    </style>
</head>
<body>

<div class="wrapper">
    <main>
        <h1>Dashboard Rapportage</h1>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Omzetverloop (€)</h3>
                <canvas id="lineChart"></canvas>
            </div>

            <div class="card">
                <h3>Verdeling Uren per Maand</h3>
                <canvas id="pieChart"></canvas>
            </div>

            <div class="card" style="grid-column: span 2;">
                <h3>Uren per maand</h3>
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <div class="back-btn-container">
            <a href="index.php" class="search-btn">Terug naar menu</a>
        </div>
    </main>
</div>

<script>
    // Data uit PHP halen
    const labels = [<?php $res = $conn->query("SELECT maand FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "'{$r['maand']}',"; ?>];
    const omzetData = [<?php $res = $conn->query("SELECT totale_omzet FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "{$r['totale_omzet']},"; ?>];
    const urenData = [<?php $res = $conn->query("SELECT totaal_uren FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "{$r['totaal_uren']},"; ?>];

    // 1. Lijn grafiek
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: { labels: labels, datasets: [{ label: 'Omzet', data: omzetData, borderColor: '#004d26', fill: true, backgroundColor: 'rgba(0, 77, 38, 0.1)' }] }
    });

    // 2. Cirkel grafiek
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: { labels: labels, datasets: [{ data: urenData, backgroundColor: ['#004d26', '#00753a', '#009e4d', '#4ade80', '#86efac'] }] }
    });

    // 3. Staaf grafiek
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: { labels: labels, datasets: [{ label: 'Totaal Uren', data: urenData, backgroundColor: '#004d26' }] }
    });
</script>

</body>
</html>