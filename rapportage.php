<?php
// Database verbinding
$conn = new mysqli("127.0.0.1", "root", "", "UrenRegister", 3306);

// Controleer of de verbinding werkt
if ($conn->connect_error) {
    die("Verbindingsfout: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container { padding: 20px; font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Dashboard Overzicht</h1>
        
        <table>
            <tr>
                <th>Maand</th>
                <th>Totaal Uren</th>
                <th>Totale Omzet</th>
            </tr>
            <?php
            // We halen nu de data direct uit de View die je net hebt gemaakt!
            $query = "SELECT * FROM rapportage_overzicht";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $row['maand'] . "</td>
                            <td>" . $row['totaal_uren'] . "</td>
                            <td>€ " . number_format($row['totale_omzet'], 2) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Geen gegevens gevonden.</td></tr>";
            }
            ?>
        </table>
        <br>
        <a href="index.php">Terug naar Home</a>
    </div>
</body>
</html>
<?php $conn->close(); ?>