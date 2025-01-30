<center>
<div class="mt-4">
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

// Tabelle löschen (z. B. spielestatistik)
try {
    $pdo->exec("DELETE FROM spielestatistik");
    echo "Tabelle 'spielestatistik' erfolgreich geleert.<br>";
} catch (PDOException $e) {
    die("Fehler beim Löschen der Tabelle: " . $e->getMessage());
}

// Prüfen, ob eine Datei hochgeladen wurde
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $uploadFile = $_FILES['file']['tmp_name']; // Temporärer Pfad

    // Überprüfen, ob es sich um eine Excel-Datei handelt
    if ($_FILES['file']['type'] !== 'application/vnd.ms-excel' && $_FILES['file']['type'] !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
        die("Nur Excel-Dateien (.xls oder .xlsx) sind erlaubt.");
    }

    // Excel-Datei mit SimpleXLS öffnen
    if ($xls = SimpleXLS::parse($uploadFile)) {
        $rows = $xls->rows(); // Alle Zeilen auslesen
        
        foreach ($rows as $index => $row) {

            // Spalten aus der Excel-Tabelle auslesen
            $fullname = isset($row[0]) ? mb_convert_encoding($row[0], 'UTF-8', 'ISO-8859-1') : null;

            $gesamt = $row[2] ?? null;
            $herren = $row[3] ?? null;
            $jugend = $row[4] ?? null;
            $frauen = $row[5] ?? null;
            $assistent = $row[6] ?? null;
            $beobachter = $row[7] ?? null;
            $sontiges = $row[8] ?? null;
            $rueckgaben = $row[9] ?? null;
            $nichtAntritte = $row[10] ?? null;

            // Hole SchiedsrichterId
            $stmtCheck = $pdo->prepare("
                SELECT SchiedsrichterId
                FROM schiedsrichter 
                WHERE CONCAT_WS(' ', `Name`, Vorname) = :input_string;
            ");
            $stmtCheck->execute([':input_string' => $fullname]);

            $existingEntry = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($existingEntry) {
                // Neuer Eintrag für vorhandene Schiedsrichter
                $stmtInsert = $pdo->prepare("
                    INSERT INTO spielestatistik (SchiedsrichterId, Gesamt, Herren, Jugend, Frauen, Assistent, Beobachter, Sonstige, Rueckgabe, NichtAntritt)  
                    VALUES (:SchiedsrichterId, :Gesamt, :Herren, :Jugend, :Frauen, :Assistent, :Beobachter, :Sonstige, :Rueckgabe, :NichtAntritt)
                ");
                $stmtInsert->execute([
                    ':SchiedsrichterId' => $existingEntry['SchiedsrichterId'],
                    ':Gesamt' => $gesamt,
                    ':Herren' => $herren,
                    ':Jugend' => $jugend,
                    ':Frauen' => $frauen,
                    ':Assistent' => $assistent,
                    ':Beobachter' => $beobachter,
                    ':Sonstige' => $sontiges,
                    ':Rueckgabe' => $rueckgaben,
                    ':NichtAntritt' => $nichtAntritte,
                ]);
                echo "Neuer Eintrag für $fullname hinzugefügt.<br>";
            } else {
                echo "Kein Schiedsrichter gefunden für: $fullname.<br>";
            }
        }
        echo "Excel-Datei erfolgreich verarbeitet.";
    } else {
        die("Die Excel-Datei konnte nicht gelesen werden.");
    }
} else {
    die("Keine Datei hochgeladen oder ein Fehler ist aufgetreten.");
}
?>
</div>
</center>
