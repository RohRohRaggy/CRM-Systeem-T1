<?php
mysqli_report(MYSQLI_REPORT_OFF);

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "urenregister";
$dbport = 3306;

$conn = @new mysqli($servername, $username, $password, $dbname, $dbport);

$selectedCustomerId = (int)($_GET['klant_id'] ?? 0);
$selectedOrderId = (int)($_GET['opdracht_id'] ?? 0);
$invoiceDate = date('d-m-Y');
$invoiceNumber = 'INV-' . date('Ymd') . '-' . ($selectedCustomerId > 0 ? $selectedCustomerId : '000');
$errorMessage = '';
$customer = null;
$orders = [];
$invoiceRows = [];
$subtotal = 0.0;
$vatRate = 0.21;
$vatAmount = 0.0;
$total = 0.0;

function formatEuro(float $amount): string
{
    return '€ ' . number_format($amount, 2, ',', '.');
}

function bindParams(mysqli_stmt $stmt, string $types, array $params): void
{
    $references = [];

    foreach ($params as $key => $value) {
        $references[$key] = &$params[$key];
    }

    $stmt->bind_param($types, ...$references);
}

if ($conn->connect_error) {
    $errorMessage = 'Database niet bereikbaar: ' . $conn->connect_error;
} else {
    $customersResult = $conn->query("SELECT klanten_ID, Voornaam, Tussenvoegsel, Achternaam, bedrijfsnaam, email FROM klanten ORDER BY bedrijfsnaam, Achternaam, Voornaam");
    $customers = [];
    if ($customersResult) {
        while ($row = $customersResult->fetch_assoc()) {
            $customers[] = $row;
        }
    }

    if ($selectedCustomerId > 0) {
        $stmt = $conn->prepare("SELECT klanten_ID, Voornaam, Tussenvoegsel, Achternaam, bedrijfsnaam, email FROM klanten WHERE klanten_ID = ? LIMIT 1");
        $stmt->bind_param('i', $selectedCustomerId);
        $stmt->execute();
        $customerResult = $stmt->get_result();
        $customer = $customerResult ? $customerResult->fetch_assoc() : null;
        $stmt->close();

        if ($customer) {
            $stmt = $conn->prepare("SELECT Opdrachten_ID, Titel, uurloon, Aanvraagdatum FROM opdrachten WHERE Klantnaam = ? ORDER BY Aanvraagdatum DESC, Opdrachten_ID DESC");
            $stmt->bind_param('s', $customer['bedrijfsnaam']);
            $stmt->execute();
            $ordersResult = $stmt->get_result();
            while ($row = $ordersResult->fetch_assoc()) {
                $orders[] = $row;
            }
            $stmt->close();

            $sql = "SELECT w.opdracht_id, MAX(COALESCE(NULLIF(TRIM(w.opdracht_titel), ''), o.Titel)) AS opdracht_titel, MIN(w.datum) AS eerste_datum, MAX(w.datum) AS laatste_datum, SUM(w.gewerkte_uren) AS totaal_uren, COALESCE(o.uurloon, 65) AS uurloon, SUM(w.gewerkte_uren * COALESCE(o.uurloon, 65)) AS bedrag FROM werkzaamheden w LEFT JOIN opdrachten o ON o.Opdrachten_ID = w.opdracht_id WHERE o.Klantnaam = ?";
            $types = 's';
            $params = [$customer['bedrijfsnaam']];

            if ($selectedOrderId > 0) {
                $sql .= " AND w.opdracht_id = ?";
                $types .= 'i';
                $params[] = $selectedOrderId;
            }

            $sql .= " GROUP BY w.opdracht_id, uurloon ORDER BY eerste_datum ASC, opdracht_titel ASC";

            $stmt = $conn->prepare($sql);
            bindParams($stmt, $types, $params);
            $stmt->execute();
            $rowsResult = $stmt->get_result();

            while ($row = $rowsResult->fetch_assoc()) {
                $row['totaal_uren'] = (float)$row['totaal_uren'];
                $row['uurloon'] = (float)$row['uurloon'];
                $row['bedrag'] = (float)$row['bedrag'];
                $invoiceRows[] = $row;
                $subtotal += $row['bedrag'];
            }
            $stmt->close();

            $vatAmount = $subtotal * $vatRate;
            $total = $subtotal + $vatAmount;

            if ($selectedOrderId > 0 && empty($invoiceRows)) {
                $errorMessage = 'Geen werkzaamheden gevonden voor deze opdracht.';
            } elseif (empty($invoiceRows)) {
                $errorMessage = 'Geen werkzaamheden gevonden voor deze klant.';
            }
        } else {
            $errorMessage = 'Geselecteerde klant niet gevonden.';
        }
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Factuur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="src/searchfunction.js" defer></script>
    <style>
        body.invoice-page {
            background: linear-gradient(180deg, #f7f3ec 0%, #ebe2d6 100%);
            color: #1f2937;
            font-family: 'Poppins', sans-serif;
        }

        .invoice-shell {
            width: min(1120px, calc(100% - 32px));
            margin: 24px auto 56px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(124, 93, 63, 0.12);
            border-radius: 24px;
            box-shadow: 0 24px 60px rgba(71, 41, 14, 0.12);
            overflow: hidden;
        }

        .invoice-topbar {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            padding: 24px 28px;
            background: linear-gradient(135deg, #2f3a49 0%, #1f2937 100%);
            color: #fff;
            flex-wrap: wrap;
        }

        .invoice-topbar h1 {
            font-size: 30px;
            margin-bottom: 6px;
        }

        .invoice-topbar p {
            color: rgba(255, 255, 255, 0.82);
        }

        .invoice-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            justify-content: flex-end;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 0;
            border-radius: 999px;
            padding: 11px 16px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
        }

        .action-btn.primary {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);
            color: #fff;
            box-shadow: 0 10px 24px rgba(238, 90, 111, 0.28);
        }

        .action-btn.secondary {
            background: #fff;
            color: #1f2937;
        }

        .invoice-body {
            padding: 28px;
        }

        .invoice-grid {
            display: grid;
            grid-template-columns: 1.3fr 0.7fr;
            gap: 20px;
            margin-bottom: 22px;
        }

        .panel {
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 20px;
            background: #fff;
        }

        .panel h2,
        .panel h3 {
            margin-bottom: 12px;
        }

        .invoice-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .invoice-form label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #374151;
        }

        .invoice-form select {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            padding: 12px 14px;
            font-size: 15px;
            background: #fff;
        }

        .invoice-form .full {
            grid-column: 1 / -1;
        }

        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            margin-top: 16px;
        }

        .meta-card {
            border-radius: 14px;
            background: linear-gradient(180deg, #faf7f2 0%, #f2ebe2 100%);
            padding: 14px;
        }

        .meta-card span {
            display: block;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #7c6b5a;
            margin-bottom: 6px;
        }

        .meta-card strong {
            font-size: 18px;
        }

        .invoice-table-wrap {
            overflow-x: auto;
            margin-top: 10px;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
            background: #fff;
        }

        .invoice-table th,
        .invoice-table td {
            padding: 14px 16px;
            border-bottom: 1px solid #eef2f7;
            text-align: left;
            vertical-align: top;
        }

        .invoice-table thead th {
            background: #f8fafc;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #475569;
        }

        .invoice-summary {
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 20px;
            margin-top: 22px;
        }

        .totals-box {
            background: linear-gradient(180deg, #1f2937 0%, #111827 100%);
            color: #fff;
            border-radius: 18px;
            padding: 20px;
        }

        .totals-box .line {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .totals-box .total {
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            margin-top: 14px;
            padding-top: 14px;
            font-size: 20px;
            font-weight: 800;
        }

        .note {
            margin-top: 16px;
            padding: 14px 16px;
            border-radius: 14px;
            background: #fff8eb;
            border: 1px solid #f3d7a6;
            color: #7c4d11;
        }

        .empty-state,
        .error-state {
            padding: 18px 20px;
            border-radius: 16px;
            font-weight: 600;
        }

        .empty-state {
            background: #eef6ff;
            color: #1d4ed8;
        }

        .error-state {
            background: #fff1f2;
            color: #be123c;
        }

        @media print {
            body.invoice-page {
                background: #fff;
            }

            .invoice-shell {
                width: 100%;
                margin: 0;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .invoice-topbar,
            .invoice-actions,
            .note,
            .form-panel,
            .no-print {
                display: none !important;
            }

            .invoice-body {
                padding: 0;
            }

            .panel,
            .totals-box {
                break-inside: avoid;
            }
        }

        @media (max-width: 900px) {
            .invoice-grid,
            .invoice-summary,
            .meta-grid,
            .invoice-form {
                grid-template-columns: 1fr;
            }

            .invoice-topbar {
                align-items: flex-start;
            }
        }
    </style>
</head>
<body class="invoice-page">
    <div class="invoice-shell">
        <div class="invoice-topbar">
            <div>
                <h1>Factuur</h1>
                <p>Bereken uren per klant of opdracht en print direct naar PDF.</p>
            </div>
            <div class="invoice-actions">
                <button id="printBtn" class="action-btn primary" type="button"><i class="fas fa-file-pdf"></i> Print / PDF</button>
                <?php if ($customer && !empty($customer['email'])): ?>
                    <?php
                        $mailtoSubject = rawurlencode('Factuur ' . $invoiceNumber . ' voor ' . $customer['bedrijfsnaam']);
                        $mailtoBody = rawurlencode("Hallo,\n\nIn de bijlage staat de factuur " . $invoiceNumber . ".\nPrint eerst de factuur als PDF en voeg die daarna handmatig toe aan deze e-mail.\n\nMet vriendelijke groet");
                    ?>
                    <a class="action-btn secondary" href="mailto:<?php echo htmlspecialchars($customer['email']); ?>?subject=<?php echo $mailtoSubject; ?>&body=<?php echo $mailtoBody; ?>"><i class="fas fa-envelope"></i> E-mail openen</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="invoice-body">
            <div class="panel form-panel no-print">
                <h2>Selecteer klant en opdracht</h2>
                <form method="get" class="invoice-form">
                    <div>
                        <label for="klant_id">Klant</label>
                        <select id="klant_id" name="klant_id" onchange="this.form.submit()">
                            <option value="">Kies een klant</option>
                            <?php if (!empty($customers)): ?>
                                <?php foreach ($customers as $item): ?>
                                    <option value="<?php echo (int)$item['klanten_ID']; ?>" <?php echo $selectedCustomerId === (int)$item['klanten_ID'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars(trim(($item['bedrijfsnaam'] ?? '') . ' - ' . trim(($item['Voornaam'] ?? '') . ' ' . ($item['Tussenvoegsel'] ?? '') . ' ' . ($item['Achternaam'] ?? '')))); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div>
                        <label for="opdracht_id">Opdracht</label>
                        <select id="opdracht_id" name="opdracht_id" <?php echo empty($orders) ? 'disabled' : ''; ?>>
                            <option value="">Alle opdrachten</option>
                            <?php foreach ($orders as $order): ?>
                                <option value="<?php echo (int)$order['Opdrachten_ID']; ?>" <?php echo $selectedOrderId === (int)$order['Opdrachten_ID'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($order['Titel']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="full">
                        <button class="action-btn primary" type="submit"><i class="fas fa-calculator"></i> Factuur tonen</button>
                    </div>
                </form>
            </div>

            <?php if ($errorMessage !== ''): ?>
                <div class="error-state"><?php echo htmlspecialchars($errorMessage); ?></div>
            <?php elseif ($customer): ?>
                <div class="invoice-grid">
                    <div class="panel">
                        <h2>Factuurgegevens</h2>
                        <p><strong>Factuurnummer:</strong> <?php echo htmlspecialchars($invoiceNumber); ?></p>
                        <p><strong>Factuurdatum:</strong> <?php echo htmlspecialchars($invoiceDate); ?></p>
                        <p><strong>Klant:</strong> <?php echo htmlspecialchars(trim(($customer['bedrijfsnaam'] ?? '') . ' - ' . trim(($customer['Voornaam'] ?? '') . ' ' . ($customer['Tussenvoegsel'] ?? '') . ' ' . ($customer['Achternaam'] ?? '')))); ?></p>
                        <p><strong>E-mail:</strong> <?php echo htmlspecialchars($customer['email'] ?? ''); ?></p>
                    </div>

                    <div class="panel">
                        <h3>Overzicht</h3>
                        <p>Gebruik de printknop hierboven om dit scherm als PDF op te slaan. Verstuur die PDF daarna handmatig per e-mail.</p>
                    </div>
                </div>

                <div class="meta-grid">
                    <div class="meta-card">
                        <span>Subtotaal</span>
                        <strong><?php echo formatEuro($subtotal); ?></strong>
                    </div>
                    <div class="meta-card">
                        <span>Btw 21%</span>
                        <strong><?php echo formatEuro($vatAmount); ?></strong>
                    </div>
                    <div class="meta-card">
                        <span>Totaal</span>
                        <strong><?php echo formatEuro($total); ?></strong>
                    </div>
                </div>

                <div class="invoice-table-wrap">
                    <table class="invoice-table">
                        <thead>
                            <tr>
                                <th>Opdracht</th>
                                <th>Periode</th>
                                <th>Uren</th>
                                <th>Uurloon</th>
                                <th>Bedrag</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($invoiceRows as $row): ?>
                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($row['opdracht_titel'] ?? 'Onbekend'); ?>
                                        <?php if (!empty($row['opdracht_id'])): ?>
                                            <div style="color:#6b7280; font-size:13px; margin-top:4px;">Opdracht #<?php echo (int)$row['opdracht_id']; ?></div>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                            $startDate = !empty($row['eerste_datum']) ? date('d-m-Y', strtotime($row['eerste_datum'])) : '-';
                                            $endDate = !empty($row['laatste_datum']) ? date('d-m-Y', strtotime($row['laatste_datum'])) : '-';
                                            echo htmlspecialchars($startDate . ' t/m ' . $endDate);
                                        ?>
                                    </td>
                                    <td><?php echo number_format((float)$row['totaal_uren'], 2, ',', '.'); ?></td>
                                    <td><?php echo formatEuro((float)$row['uurloon']); ?></td>
                                    <td><?php echo formatEuro((float)$row['bedrag']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="invoice-summary">
                    <div class="panel">
                        <h3>Versturen per e-mail</h3>
                        <p>Open je e-mailprogramma via de knop rechtsboven, voeg de zojuist geprinte PDF handmatig toe en verstuur die naar de klant.</p>
                        <div class="note">
                            Handige volgorde: 1. print naar PDF, 2. sla het bestand op, 3. voeg het handmatig toe als bijlage, 4. verzend de e-mail.
                        </div>
                    </div>

                    <div class="totals-box">
                        <div class="line"><span>Subtotaal</span><strong><?php echo formatEuro($subtotal); ?></strong></div>
                        <div class="line"><span>Btw (21%)</span><strong><?php echo formatEuro($vatAmount); ?></strong></div>
                        <div class="line total"><span>Totaal</span><span><?php echo formatEuro($total); ?></span></div>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state">Selecteer hierboven een klant om een factuur te berekenen.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>