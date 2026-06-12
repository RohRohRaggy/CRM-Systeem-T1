<?php
// Supportformulier: verwerk POST vóór output (PRG), sla op in DB (met fallback naar tekstbestand).
ini_set('display_errors', 0);
$message = '';
$name = $email = $subject = $body = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $body = trim($_POST['message'] ?? '');

    if ($name === '' || $email === '' || $subject === '' || $body === '') {
        $message = '<div class="msg msg-error">Vul alle velden in.</div>';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = '<div class="msg msg-error">Ongeldig e-mailadres.</div>';
    } else {
        $ticket = [
            'name' => mb_substr($name, 0, 200),
            'email' => mb_substr($email, 0, 200),
            'subject' => mb_substr($subject, 0, 250),
            'message' => mb_substr($body, 0, 2000),
        ];

        $servername = "127.0.0.1";
        $username   = "root";
        $password   = "";
        $dbname     = "UrenRegister";
        $dbport     = 3306;
        mysqli_report(MYSQLI_REPORT_OFF);
        $conn = @new mysqli($servername, $username, $password, $dbname, $dbport);
        if (!$conn->connect_error) {
            $create = "CREATE TABLE IF NOT EXISTS support_tickets (
                id INT AUTO_INCREMENT PRIMARY KEY,
                created DATETIME NOT NULL,
                name VARCHAR(200) NOT NULL,
                email VARCHAR(200) NOT NULL,
                subject VARCHAR(250) NOT NULL,
                message TEXT NOT NULL,
                status VARCHAR(20) NOT NULL DEFAULT 'open'
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            $conn->query($create);

            $stmt = $conn->prepare("INSERT INTO support_tickets (created,name,email,subject,message) VALUES (NOW(),?,?,?,?)");
            if ($stmt) {
                $stmt->bind_param('ssss', $ticket['name'], $ticket['email'], $ticket['subject'], $ticket['message']);
                $stmt->execute();
                $stmt->close();
            }
            $conn->close();
            header('Location: support_ticket_pagina.php?sent=1');
            exit;
        } else {
            $line = json_encode(array_merge(['time' => date('c')], $ticket), JSON_UNESCAPED_UNICODE) . PHP_EOL;
            @file_put_contents(__DIR__ . '/support_tickets.txt', $line, FILE_APPEND | LOCK_EX);
            header('Location: support_ticket_pagina.php?sent=1');
            exit;
        }
    }
}

$sent = isset($_GET['sent']) && $_GET['sent'] === '1';
if ($sent) $message = '<div class="msg msg-success">Bedankt — jouw ticket is aangemaakt.</div>';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <title>Support - UrenRegistratieSysteem</title>
    <script src="searchfunction.js" defer></script>
    <script src="admin.js" defer></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <style>
        .support-card {
            background: #fff;
            border-radius: 22px;
            padding: 34px;
            max-width: 880px;
            margin: 0 auto;
            box-shadow: 0 24px 70px rgba(17, 32, 66, 0.12);
            border: 1px solid rgba(114, 147, 209, 0.12);
        }

        .support-card-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 24px;
            padding-bottom: 18px;
            border-bottom: 1px solid #eef2fa;
        }

        .support-card-header .title {
            font-size: 24px;
            font-weight: 800;
            color: #162039;
            letter-spacing: -0.02em;
            margin: 0;
        }

        .support-card-header .subtitle {
            max-width: 590px;
            color: #55617e;
            line-height: 1.7;
            margin: 0;
        }

        .support-meta {
            display: inline-flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            padding: 14px 18px;
            border-radius: 14px;
            background: rgba(56, 110, 255, 0.08);
            color: #1f3b78;
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
        }

        .support-note {
            grid-column: 1/-1;
            background: #f4f7ff;
            border: 1px solid #dbe5f6;
            border-radius: 16px;
            padding: 18px 20px;
            color: #324060;
            font-size: 15px;
            line-height: 1.7;
        }

        .admin-note {
            grid-column: 1/-1;
            margin-bottom: 16px;
            font-size: 0.95rem;
            color: #4b5563;
            line-height: 1.6;
        }

        .admin-note a {
            color: #1d4ed8;
            text-decoration: none;
            font-weight: 700;
        }

        .admin-note a:hover {
            text-decoration: underline;
        }

        .support-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 20px;
        }

        .support-form .full {
            grid-column: 1/-1;
        }

        .support-form .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .support-form label {
            display: block;
            text-align: left;
            font-weight: 600;
            color: #2a3340;
        }

        .support-form input[type="text"],
        .support-form input[type="email"],
        .support-form textarea {
            width: 100%;
            padding: 15px 18px;
            border: 1px solid #d6dbe8;
            border-radius: 16px;
            background: #f8fbff;
            font-size: 15px;
            color: #1f3148;
            transition: box-shadow 0.2s ease, border-color 0.2s ease;
        }

        .support-form input[type="text"],
        .support-form input[type="email"] {
            height: 52px;
        }

        .support-form textarea {
            min-height: 200px;
            resize: vertical;
        }

        .support-form .actions {
            grid-column: 1/-1;
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .support-form button {
            background: linear-gradient(90deg, #1d4ed8, #3b82f6);
            color: #fff;
            border: none;
            padding: 14px 28px;
            border-radius: 16px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 16px 30px rgba(29, 78, 216, 0.22);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .support-form button:hover {
            transform: translateY(-2px);
            box-shadow: 0 18px 34px rgba(29, 78, 216, 0.26);
        }

        .support-form input[type="text"]:focus,
        .support-form input[type="email"]:focus,
        .support-form textarea:focus {
            border-color: #7da7ff;
            box-shadow: 0 0 0 4px rgba(99, 144, 255, 0.18);
            outline: none;
        }

        .msg {
            max-width: 840px;
            margin: 0 auto 22px;
            padding: 14px 18px;
            border-radius: 16px;
            font-weight: 700;
        }

        .msg-success {
            background: #effaf4;
            color: #137754;
            border: 1px solid #c6ebd8;
        }

        .msg-error {
            background: #fff2f2;
            color: #b42318;
            border: 1px solid #f9d0d2;
        }

        .hero-section {
            margin: 1.5rem 0 1rem;
            padding: 0;
        }

        .hero-section .text h2 {
            font-size: 34px;
            color: #1f2937;
            margin-bottom: 10px;
        }

        .hero-section .text p {
            color: #4b5563;
            font-size: 16px;
            max-width: 760px;
            margin: auto;
        }

        .content {
            margin-top: -1rem;
        }

        @media (max-width: 860px) {
            .support-form {
                grid-template-columns: 1fr;
            }

            .support-card {
                padding: 26px;
            }
        }

        @media (max-width: 620px) {
            .support-card-header {
                flex-direction: column;
                gap: 12px;
            }

            .support-form .actions {
                justify-content: center;
            }

            .support-form button {
                width: 100%;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <nav class="topnav">
            <div class="left"><a href="index.php"></a></div>
            <div class="right">
                <?php
                echo '<a class="table-link" href="homepagina.php">Homepagina</a>';
                echo '<a class="table-link" href="support_ticket_pagina.php">Support</a>';

                $servername = "127.0.0.1";
                $username   = "root";
                $password   = "";
                $dbname     = "testdatabase2";
                $dbport     = 3306;
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
                    $conn->close();
                }
                ?>

                <div class="search-wrapper">
                    <div class="search-container" role="search" aria-label="Zoek categorieën">
                        <input id="searchInput" class="search-input" type="search" placeholder="Zoeken (bijv. medewerkers, uren, etc)...">
                        <button id="searchBtn" class="search-btn" aria-label="Zoeken">Zoeken</button>
                    </div>
                    <span id="suggestion" class="suggestion" aria-live="polite"></span>
                </div>
                <button id="printBtn" class="print-btn" type="button" aria-label="Afdrukken naar PDF" title="Afdrukken naar PDF"><i class="fas fa-file-pdf"></i></button>
                <button id="adminBtn" class="admin-btn-toggle" type="button" aria-label="Beheermodus" title="Beheermodus"><i class="fas fa-lock"></i></button>
            </div>
        </nav>

        <main>
            <section class="hero-section">
                <div class="text"><h2>Support Tickets</h2><p>Vul onderstaand formulier in om een supportticket aan te maken. Ons team reageert zo snel mogelijk.</p></div>
            </section>

            <section class="content">
                <?php if ($message) echo $message; ?>
                <div class="support-card">
                    <div class="support-card-header">
                        <div>
                            <h3 class="title">Open een supportticket</h3>
                            <p class="subtitle">Beschrijf je vraag kort en duidelijk. Dit formulier wordt direct naar onze supportafdeling gestuurd zodat je snel antwoord krijgt.</p>
                        </div>
                        <div class="support-meta"><strong>Snelle reactie</strong><br>Binnen 24 uur</div>
                    </div>
                    <p class="admin-note">Je ticket wordt automatisch opgeslagen in de database.</p>
                    <form method="post" action="support_ticket_pagina.php" class="support-form">
                        <div class="support-note full">Vul alle velden in. Gebruik duidelijke termen bij het onderwerp zodat we jouw ticket direct goed kunnen verwerken.</div>

                        <div class="field">
                            <label for="name">Naam</label>
                            <input id="name" type="text" name="name" value="<?php echo htmlspecialchars($name ?? ''); ?>" required>
                        </div>
                        <div class="field">
                            <label for="email">E-mail</label>
                            <input id="email" type="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
                        </div>
                        <div class="field full">
                            <label for="subject">Onderwerp</label>
                            <input id="subject" type="text" name="subject" value="<?php echo htmlspecialchars($subject ?? ''); ?>" required>
                        </div>
                        <div class="field full">
                            <label for="message">Bericht</label>
                            <textarea id="message" name="message" required><?php echo htmlspecialchars($body ?? ''); ?></textarea>
                        </div>
                        <div class="actions">
                            <button type="submit">Verstuur ticket</button>
                        </div>
                    </form>
                </div>
            </section>

            <footer class="footer"><p>©TEAM 1 [2026]</p></footer>
        </main>
    </div>
</body>
</html>