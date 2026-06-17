<?php
$conn = new mysqli("127.0.0.1", "root", "", "UrenRegister", 3306);

// Data ophalen voor de grafieken
$maanden = [];
$uren = [];
$omzet = [];

$res = $conn->query("SELECT * FROM rapportage_overzicht ORDER BY maand ASC");
while($row = $res->fetch_assoc()) {
    $maanden[] = "Maand " . $row['maand'];
    $uren[] = $row['totaal_uren'];
    $omzet[] = $row['totale_omzet'];
}

// Totale omzet en gemiddelde berekenen voor de tekst-labels
$totaalOmzet = array_sum($omzet);
$gemUren = count($uren) > 0 ? array_sum($uren) / count($uren) : 0;
$actieveMaanden = count($maanden);
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
        .dashboard-grid { 
            display: grid; 
            grid-template-columns: repeat(2, 1fr); 
            gap: 25px; 
            padding: 30px; 
            max-width: 1200px;
            margin: 0 auto;
        }
        .card { 
            background: rgba(255, 255, 255, 0.95); 
            padding: 20px; 
            border-radius: 15px; 
            box-shadow: 0 8px 25px rgba(0,0,0,0.2); 
            text-align: center;
        }
        .card h3 { color: #004d26; border-bottom: 2px solid #004d26; padding-bottom: 10px; margin-bottom: 15px; }
        .stat-value { font-size: 1.5em; font-weight: bold; color: #004d26; margin-bottom: 10px; }
        canvas { max-width: 100% !important; height: 200px !important; }
        .back-btn-container { text-align: center; margin-bottom: 40px; }
    </style>
</head>
<body>

<div class="wrapper">
    <main>
        <h1 style="color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.5); text-align: center; padding-top: 20px;">
            Management Dashboard
        </h1>

        <div class="dashboard-grid">
            <div class="card">
                <h3>Uren per maand</h3>
                <canvas id="chartUren"></canvas>
            </div>

            <div class="card">
                <h3>Omzet Verdeling</h3>
                <div class="stat-value">Totaal: €<?php echo number_format($totaalOmzet, 2); ?></div>
                <canvas id="chartOmzet"></canvas>
            </div>

            <div class="card">
                <h3>Uren Trend</h3>
                <div class="stat-value">Gemiddeld: <?php echo round($gemUren, 1); ?> uur</div>
                <canvas id="chartTrend"></canvas>
            </div>

            <div class="card">
                <h3>Productiviteit</h3>
                <div class="stat-value">Actieve maanden: <?php echo $actieveMaanden; ?></div>
                <canvas id="chartProductiviteit"></canvas>
            </div>
        </div>

        <script>
            // Data vanuit PHP naar JS
            const labels = <?php echo json_encode($maanden); ?>;
            const urenData = <?php echo json_encode($uren); ?>;
            const omzetData = <?php echo json_encode($omzet); ?>;

            // 1. Uren Chart (Bar)
            new Chart(document.getElementById('chartUren'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{ label: 'Uren', data: urenData, backgroundColor: '#004d26' }]
                }
            });

            // 2. Omzet Chart (Doughnut)
            new Chart(document.getElementById('chartOmzet'), {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{ data: omzetData, backgroundColor: ['#004d26', '#2ecc71', '#27ae60', '#16a085'] }]
                }
            });

            // 3. Trend Chart (Line)
            new Chart(document.getElementById('chartTrend'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{ label: 'Uren verloop', data: urenData, borderColor: '#004d26', fill: true, backgroundColor: 'rgba(0, 77, 38, 0.1)' }]
                }
            });

            // 4. Productiviteit (Horizontal Bar)
            new Chart(document.getElementById('chartProductiviteit'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{ label: 'Omzet per maand', data: omzetData, backgroundColor: '#2ecc71' }]
                },
                options: { indexAxis: 'y' }
            });
        </script>

        <div class="back-btn-container">
            <a href="homepagina.php" class="search-btn">Terug naar menu</a>
        </div>
    </main>
</div>

</body>
</html>