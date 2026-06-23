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
        body { background-color: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .dashboard-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; padding: 25px; }
        .card { background: white; padding: 25px; border-radius: 20px; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border: 1px solid #eee; transition: transform 0.3s; }
        .card:hover { transform: translateY(-5px); }
        .card h3 { color: #333; margin-bottom: 20px; font-weight: 600; font-size: 1.2rem; }
        .back-btn-container { text-align: center; margin-bottom: 50px; }
        .search-btn { background: #004d26; color: white; padding: 12px 25px; border-radius: 50px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>

<div class="wrapper">
    <main>
        <h1 style="text-align: center; color: #004d26; margin: 30px;">Dashboard Rapportage</h1>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Omzetverloop (€)</h3>
                <canvas id="lineChart" height="200"></canvas>
            </div>
            <div class="card">
                <h3>Verdeling Uren per Maand</h3>
                <canvas id="pieChart" height="200"></canvas>
            </div>
            <div class="card" style="grid-column: span 2;">
                <h3>Uren per maand</h3>
                <canvas id="barChart" height="100"></canvas>
            </div>
        </div>

        <div class="back-btn-container">
            <a href="index.php" class="search-btn">Terug naar menu</a>
        </div>
    </main>
</div>

<script>
    const labels = [<?php $res = $conn->query("SELECT maand FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "'{$r['maand']}',"; ?>];
    const omzetData = [<?php $res = $conn->query("SELECT totale_omzet FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "{$r['totale_omzet']},"; ?>];
    const urenData = [<?php $res = $conn->query("SELECT totaal_uren FROM rapportage_overzicht ORDER BY maand ASC"); while($r = $res->fetch_assoc()) echo "{$r['totaal_uren']},"; ?>];

    // Globale opties voor een rustige uitstraling
    const commonOpts = { responsive: true, plugins: { legend: { position: 'bottom' } } };

    // 1. Lijn grafiek (Gradient effect)
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: { labels: labels, datasets: [{ 
            label: 'Omzet', data: omzetData, borderColor: '#004d26', tension: 0.4, fill: true, 
            backgroundColor: 'rgba(0, 77, 38, 0.05)', borderWidth: 3 
        }] },
        options: commonOpts
    });

    // 2. Cirkel grafiek (Soft colors)
    new Chart(document.getElementById('pieChart'), {
        type: 'doughnut', // Doughnut oogt vaak moderner dan Pie
        data: { labels: labels, datasets: [{ 
            data: urenData, backgroundColor: ['#004d26', '#00753a', '#22c55e', '#86efac', '#dcfce7'] 
        }] },
        options: { ...commonOpts, cutout: '70%' } // De hole in het midden maakt het professioneel
    });

    // 3. Staaf grafiek (Afgeronde hoeken)
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: { labels: labels, datasets: [{ 
            label: 'Uren', data: urenData, backgroundColor: '#004d26', borderRadius: 10 
        }] },
        options: { ...commonOpts, scales: { y: { beginAtZero: true } } }
    });
</script>

</body>
</html>