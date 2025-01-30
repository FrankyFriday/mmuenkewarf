<center><div class="mt-4">
<?php
require_once 'SimpleXLS.php'; // Bibliothek einbinden

// Datenbankverbindung
$host = 'localhost';
$dbname = 'leistungsmatrix';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Fehler bei der Datenbankverbindung: " . $e->getMessage());
}

// Prüfen, ob eine Datei hochgeladen wurde
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadFile = $_FILES['file']['tmp_name']; // Temporärer Pfad

    // Überprüfen, ob es sich um eine Excel-Datei handelt
    if ($_FILES['file']['type'] !== 'application/vnd.ms-excel') {
        die("Nur Excel-Dateien (.xls) sind erlaubt.");
    }

    // Excel-Datei mit SimpleXLS öffnen
    if ($xls = SimpleXLS::parse($uploadFile)) {
        $rows = $xls->rows(); // Alle Zeilen auslesen

        foreach ($rows as $index => $row) {
            if ($index === 0) continue; // Überspringe die Kopfzeile

            // Passe die Spalten an deine Tabelle an
            $name = $row[0] ?? null;
            $vorname = $row[1] ?? null;
            $geburtsdatum_raw = $row[9] ?? null;
            $srSeit_raw = $row[17] ?? null;
            $qmax = $row[20] ?? null;
            $geschlecht = $row[21] ?? null;
            
            $geburtsdatum = null;
            if (is_numeric($geburtsdatum_raw)) {
                // Excel-Datum (als Zahl) in ein PHP-Datum umwandeln
                $unix_timestamp = ($geburtsdatum_raw - 25569) * 86400; // 25569 = 1.1.1970 - Excel-Basisdatum
                $geburtsdatum = date('Y-m-d', $unix_timestamp);
            } elseif (strtotime($geburtsdatum_raw)) {
                // Text-Datum (bereits lesbares Format)
                $geburtsdatum = date('Y-m-d', strtotime($geburtsdatum_raw));
            }
            $srSeit = null;
            if (is_numeric($srSeit_raw)) {
                // Excel-Datum (als Zahl) in ein PHP-Datum umwandeln
                $unix_timestamp = ($srSeit_raw - 25569) * 86400; // 25569 = 1.1.1970 - Excel-Basisdatum
                $srSeit = date('Y-m-d', $unix_timestamp);
            } elseif (strtotime($srSeit_raw)) {
                // Text-Datum (bereits lesbares Format)
                $srSeit = date('Y-m-d', strtotime($srSeit_raw));
            }

            // Prüfen, ob der Eintrag bereits existiert
    $stmtCheck = $pdo->prepare("
        SELECT QMAX 
        FROM schiedsrichter 
        WHERE `Name` = :nachname 
          AND Vorname = :vorname 
          AND Geburtsdatum = :geburtsdatum 
          AND SrSeit = :sr_seit 
          AND Geschlecht = :geschlecht
    ");
    $stmtCheck->execute([
        ':nachname' => $name,
        ':vorname' => $vorname,
        ':geburtsdatum' => $geburtsdatum,
        ':sr_seit' => $srSeit,
        ':geschlecht' => $geschlecht,
    ]);

    $existingEntry = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if ($existingEntry) {
        // Eintrag existiert bereits
        if ($existingEntry['QMAX'] !== $qmax) {
            // qmax aktualisieren, wenn es sich geändert hat
            $stmtUpdate = $pdo->prepare("
                UPDATE schiedsrichter 
                SET QMAX = :qmax 
                WHERE `Name` = :nachname 
                  AND Vorname = :vorname 
                  AND Geburtsdatum = :geburtsdatum 
                  AND SrSeit = :sr_seit 
                  AND Geschlecht = :geschlecht
            ");
            $stmtUpdate->execute([
                ':qmax' => $qmax,
                ':nachname' => $name,
                ':vorname' => $vorname,
                ':geburtsdatum' => $geburtsdatum,
                ':sr_seit' => $srSeit,
                ':geschlecht' => $geschlecht,
            ]);
            echo "Eintrag für $name $vorname aktualisiert.<br>";
        } 
    } else {
        // Neuer Eintrag
        $stmtInsert = $pdo->prepare("
            INSERT INTO schiedsrichter (`Name`, Vorname, Geburtsdatum, SrSeit, QMAX, Geschlecht)  
            VALUES (:nachname, :vorname, :geburtsdatum, :sr_seit, :qmax, :geschlecht)
        ");
        $stmtInsert->execute([
            ':nachname' => $name,
            ':vorname' => $vorname,
            ':geburtsdatum' => $geburtsdatum,
            ':sr_seit' => $srSeit,
            ':geschlecht' => $geschlecht,
            ':qmax' => $qmax,
        ]);
        echo "Neuer Eintrag für $name $vorname hinzugefügt.<br>";
    }}         
        echo "Excel-Datei erfolgreich verarbeitet.";
    } else {
        die("Die Excel-Datei konnte nicht gelesen werden.");
    }
} else {
    die("Keine Datei hochgeladen oder ein Fehler ist aufgetreten.");
}
?>
</div></center>
