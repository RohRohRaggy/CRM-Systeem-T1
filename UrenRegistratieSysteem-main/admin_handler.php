<?php
// Deze endpoint retourneert altijd JSON zodat de frontend de response eenduidig kan verwerken.
header('Content-Type: application/json');

// Database-instellingen voor de lokale MySQL-verbinding.
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "UrenRegistratieSysteem";
$dbport = 3307;

mysqli_report(MYSQLI_REPORT_OFF);
// Maak een nieuwe databaseverbinding aan met de opgegeven configuratie.
$conn = @new mysqli($servername, $username, $password, $dbname, $dbport);

// Stop direct als de database niet bereikbaar is om vervolgerrors te voorkomen.
if ($conn->connect_error) {
    echo json_encode([
        'success' => false,
        'error' => 'Database niet bereikbaar',
        'details' => $conn->connect_error,
        'code' => $conn->connect_errno
    ]);
    exit;
}

// Lees de gevraagde actie uit POST; bij ontbreken gebruiken we een lege string.
$action = $_POST['action'] ?? '';

// Verwerk alle beheerdersacties via een centrale switch zodat elke actie afgebakend blijft.
switch ($action) {
    case 'update_cell':
        // Haal doelgegevens op: tabel, kolom, nieuwe waarde en de identifier van de rij.
        $table = $_POST['table'] ?? '';
        $column = $_POST['column'] ?? '';
        $value = $_POST['value'] ?? '';
        $idColumn = $_POST['id_column'] ?? 'id';
        $idValue = $_POST['id_value'] ?? '';
        
        // Filter tabel- en kolomnamen op veilige tekens om SQL-injectie via identifiers te beperken.
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $column = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
        $idColumn = preg_replace('/[^a-zA-Z0-9_]/', '', $idColumn);
        
        // Gebruik een prepared statement voor waarden zodat invoer niet als SQL wordt uitgevoerd.
        $stmt = $conn->prepare("UPDATE `$table` SET `$column` = ? WHERE `$idColumn` = ?");
        $stmt->bind_param("ss", $value, $idValue);
        
        // Geef een uniforme succes/fout-response terug aan de frontend.
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        // Ruim statement-resources op na uitvoering.
        $stmt->close();
        break;
        
    case 'add_row':
        // Voeg een lege rij toe aan de opgegeven tabel (behalve auto-incrementkolommen).
        $table = $_POST['table'] ?? '';
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        
        // Lees alle kolommen op en sluit auto_increment uit zodat de database zelf het ID bepaalt.
        $columnsResult = $conn->query("SHOW COLUMNS FROM `$table`");
        $columns = [];
        while ($col = $columnsResult->fetch_assoc()) {
            if ($col['Extra'] !== 'auto_increment') {
                $columns[] = $col['Field'];
            }
        }
        
        // Bouw dynamisch de INSERT-query op op basis van het aantal gevonden kolommen.
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $columnList = implode(', ', array_map(function($c) { return "`$c`"; }, $columns));
        
        $stmt = $conn->prepare("INSERT INTO `$table` ($columnList) VALUES ($placeholders)");
        
        // Initialiseer alle velden met lege strings; types worden als string gebonden.
        $types = str_repeat('s', count($columns));
        $values = array_fill(0, count($columns), '');
        $stmt->bind_param($types, ...$values);
        
        // Retourneer bij succes ook het nieuw aangemaakte insert-id.
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'id' => $conn->insert_id]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
        
    case 'delete_row':
        // Verwijder exact een rij op basis van de meegegeven primaire sleutel/identifier.
        $table = $_POST['table'] ?? '';
        $idColumn = $_POST['id_column'] ?? 'id';
        $idValue = $_POST['id_value'] ?? '';
        
        // Sanitize identifiers zodat alleen geldige tabel- en kolomnamen overblijven.
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $idColumn = preg_replace('/[^a-zA-Z0-9_]/', '', $idColumn);
        
        // Prepared statement voorkomt injectie in de te verwijderen waarde.
        $stmt = $conn->prepare("DELETE FROM `$table` WHERE `$idColumn` = ?");
        $stmt->bind_param("s", $idValue);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $stmt->error]);
        }
        $stmt->close();
        break;
        
    case 'add_column':
        // Voeg een nieuwe kolom toe aan een bestaande tabel via ALTER TABLE.
        $table = $_POST['table'] ?? '';
        $columnName = $_POST['column_name'] ?? '';
        $columnType = $_POST['column_type'] ?? 'VARCHAR(255)';
        
        // Tabel- en kolomnamen filteren; type blijft zoals aangeleverd.
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $columnName = preg_replace('/[^a-zA-Z0-9_]/', '', $columnName);
        
        // Stel de ALTER-query samen voor het toevoegen van de kolom.
        $sql = "ALTER TABLE `$table` ADD COLUMN `$columnName` $columnType";
        
        if ($conn->query($sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        break;
        
    case 'delete_column':
        // Verwijder een kolom uit een tabel.
        $table = $_POST['table'] ?? '';
        $columnName = $_POST['column_name'] ?? '';
        
        $table = preg_replace('/[^a-zA-Z0-9_]/', '', $table);
        $columnName = preg_replace('/[^a-zA-Z0-9_]/', '', $columnName);
        
        // Stel de ALTER-query samen voor het verwijderen van de kolom.
        $sql = "ALTER TABLE `$table` DROP COLUMN `$columnName`";
        
        if ($conn->query($sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        break;
        
    case 'create_table':
        // Maak een nieuwe standaardtabel aan met basisvelden.
        $tableName = $_POST['table_name'] ?? '';
        $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);
        
        // Standaardschema: id, naam en aanmaakdatum.
        $sql = "CREATE TABLE `$tableName` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255),
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        if ($conn->query($sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        break;
        
    case 'delete_table':
        // Verwijder een volledige tabel op basis van de opgegeven naam.
        $tableName = $_POST['table_name'] ?? '';
        $tableName = preg_replace('/[^a-zA-Z0-9_]/', '', $tableName);
        
        $sql = "DROP TABLE `$tableName`";
        
        if ($conn->query($sql)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => $conn->error]);
        }
        break;
    
    case 'delete_file':
        // Verwijder een los PHP-bestand dat gekoppeld is aan een tabelweergave.
        $filename = $_POST['filename'] ?? '';

        // Accepteer alleen veilige bestandsnamen met letters/cijfers/underscore en een PHP-extensiepatroon.
        if (!preg_match('/^[a-zA-Z0-9_]+\.php$/', $filename)) {
            echo json_encode(['success' => false, 'error' => 'Ongeldige bestandsnaam']);
            break;
        }

        // Bescherm kernbestanden van het systeem tegen verwijdering.
        $protected = ['index.php', 'table_template.php', 'admin_handler.php', 
                      'generate_pages.php', 'get_schema.php', 'homepagina.php', 'support_ticket_pagina.php'];
        if (in_array($filename, $protected)) {
            echo json_encode(['success' => false, 'error' => 'Beveiligd bestand kan niet worden verwijderd']);
            break;
        }
        
        // Verwijder alleen als het bestand bestaat en verwijderbaar is.
        if (file_exists($filename) && unlink($filename)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Bestand niet gevonden of kon niet worden verwijderd']);
        }
        break;

    default:
        // Fallback als een onbekende actie wordt opgevraagd.
        echo json_encode(['success' => false, 'error' => 'Ongeldige actie']);
}

// Sluit de databaseverbinding netjes af na elke request.
$conn->close();
?>
