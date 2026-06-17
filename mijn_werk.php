// Voorbeeld query voor in je PHP-bestand:
$medewerkerId = $_SESSION['user_id']; // Gebruik je eigen sessie-variabele
$sql = "SELECT o.opdracht_naam, w.uren, w.datum 
        FROM werkzaamheden w 
        JOIN opdrachten o ON w.opdracht_id = o.id 
        WHERE w.medewerker_id = $medewerkerId";