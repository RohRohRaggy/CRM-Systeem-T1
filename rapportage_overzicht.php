<?php
$conn = new mysqli("127.0.0.1", "root", "", "UrenRegister", 3306);
$total_omzet = $conn->query("SELECT SUM(totale_omzet) as som FROM rapportage_overzicht")->fetch_assoc()['som'];
$avg_uren = $conn->query("SELECT AVG(totaal_uren) as gem FROM rapportage_overzicht")->fetch_assoc()['gem'];
$actieve_maanden = $conn->query("SELECT COUNT(*) as aantal FROM rapportage_overzicht WHERE totaal_uren > 0")->fetch_assoc()['aantal'];
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background: #d1d1d1; font-family: Arial, sans-serif; margin: 0; padding: 20px; }
        h1 { text-align: center; color: #555; margin-bottom: 20px; }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 1000px; margin: auto; }
        .card { background: white; padding: 15px; border-radius: 10px; box-shadow: 0 2px 5px rgba(0,0,0,0.15); height: 320px; display: flex; flex-direction: column; }
        .card h3 { text-align: center; color: #004d26; margin: 0 0 10px 0; font-size: 1.1rem; border-bottom: 2px solid #004d26; padding-bottom: 5px; }
        .stat-header { text-align: center; font-size: 1.2rem; font-weight: bold; color: #004d26; margin: 5px 0; }
        .canvas-container { flex-grow: 1; display: flex; align-items: center; justify-content: center; overflow: hidden; position: relative; }
        canvas { max-height: 200px !important; width: 100% !important; }
        .back-btn-container { text-align: center; margin-top: 30px; }
        .search-btn { background: #004d26; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; display: inline-block; }
    </style>
</head>
<body>

<h1>Management Dashboard</h1>

<div class="grid">
    <div class="card">
        <h3>Uren per maand</h3>
        <div class="canvas-container"><canvas id="barChart"></canvas></div>
    </div>
    <div class="card">
        <h3>Omzet Verdeling</h3>
        <div class="stat-header">Totaal: €<?php echo number_format($total_omzet, 2, ',', '.'); ?></div>
        <div class="canvas-container"><canvas id="pieChart"></canvas></div>
    </div>
    <div class="card">
        <h3>Uren Trend</h3>
        <div class="stat-header">Gemiddeld: <?php echo round($avg_uren); ?> uur</div>
        <div class="canvas-container"><canvas id="lineChart"></canvas></div>
    </div>
    <div class="card">
        <h3>Productiviteit</h3>
        <div class="stat-header">Actieve maanden: <?php echo $actieve_maanden; ?></div>
        <div class="canvas-container"><canvas id="horizBarChart"></canvas></div>
    </div>
</div>

<div class="back-btn-container">
    <a href="index.php" class="search-btn">Terug naar menu</a>
</div>
 <footer class="footer">
            <p>©TEAM 1 [2026]</p>
        </footer>

<script>
    const labels = [<?php $res = $conn->query("SELECT maand FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "'{$r['maand']}',"; ?>];
    const urenData = [<?php $res = $conn->query("SELECT totaal_uren FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "{$r['totaal_uren']},"; ?>];
    const omzetData = [<?php $res = $conn->query("SELECT totale_omzet FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "{$r['totale_omzet']},"; ?>];
    
    const config = { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } };

    // 1. Bar Chart
    new Chart(document.getElementById('barChart'), { type: 'bar', data: { labels: labels, datasets: [{ data: urenData, backgroundColor: '#004d26' }] }, options: config });
    
    // 2. Doughnut Chart
    new Chart(document.getElementById('pieChart'), { type: 'doughnut', data: { labels: labels, datasets: [{ data: urenData, backgroundColor: ['#004d26', '#22c55e'] }] }, options: config });
    
    // 3. Line Chart
    new Chart(document.getElementById('lineChart'), { type: 'line', data: { labels: labels, datasets: [{ data: urenData, borderColor: '#004d26', fill: true, backgroundColor: '#e2e8f0', tension: 0.3 }] }, options: config });
    
    // 4. Horizontal Bar Chart (Productiviteit)
    new Chart(document.getElementById('horizBarChart'), { 
        type: 'bar', 
        data: { labels: labels, datasets: [{ data: omzetData, backgroundColor: '#22c55e' }] }, 
        options: { 
            ...config, 
            indexAxis: 'y',
            scales: { x: { beginAtZero: true }, y: { grid: { display: false } } }
        } 
    });
</script>

</body>
</html>