<?php
function doSelectAllFormKader($link) {
    $results = $link->query("SELECT * FROM kader k ORDER BY k.KaderId ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectAllFormLehrveranstaltung($link) {
    $results = $link->query("SELECT * FROM lehrabende l ORDER BY l.Datum ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectAllFormPruefungen($link) {
    $results = $link->query("SELECT * FROM pruefungen p ORDER BY p.Datum ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectAllSchiedsrichterOhneEinsatz($link) {
    $results = $link->query("SELECT s.SchiedsrichterId, s.`Name`, s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht, k.`Name` AS kaderName, s.Bemerkung
                                FROM schiedsrichter s
                                LEFT JOIN spielestatistik ss ON s.schiedsrichterId = ss.SchiedsrichterId
                                LEFT JOIN kader k ON k.KaderId=s.Kader
                                WHERE ss.SchiedsrichterId IS NULL;
                                ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectAllSchiedsrichterUe50($link) {
    $results = $link->query("SELECT s.SchiedsrichterId, s.`Name`, s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht, k.`Name` AS kaderName, s.Bemerkung, ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt
                                FROM schiedsrichter s
                                LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                                LEFT JOIN kader k ON k.KaderId=s.Kader
                                WHERE TIMESTAMPDIFF(YEAR, s.Geburtsdatum, CURDATE()) >= 50 AND s.Geschlecht='m';
                                ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectAllSchiedsrichterU50($link) {
    $results = $link->query("SELECT s.SchiedsrichterId, s.`Name`, s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht, k.`Name` AS kaderName, s.Bemerkung, ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt
                                FROM schiedsrichter s
                                LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                                LEFT JOIN kader k ON k.KaderId=s.Kader
                                WHERE TIMESTAMPDIFF(YEAR, s.Geburtsdatum, CURDATE()) < 50 AND s.Geschlecht='m';
                                ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectAllSchiedsrichterFrauen($link) {
    $results = $link->query("SELECT s.SchiedsrichterId, s.`Name`, s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht,k.`Name` AS kaderName, s.Bemerkung, ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt
                                FROM schiedsrichter s
                                LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                                LEFT JOIN kader k ON k.KaderId=s.Kader
                                WHERE s.Geschlecht='w';
                                ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectLehrveranstaltungInformationAll($link) {    
    $results = $link->query("SELECT * FROM lehrabende l ORDER BY l.Datum DESC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectLehrveranstaltungById($ID,$link) {  
    $query = "SELECT * FROM lehrabende l WHERE l.LehrabendId=$ID;";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectSchiedsrichterByName($name, $link){
    $sql = "SELECT * FROM schiedsrichter s WHERE s.Vorname LIKE ? OR s.`Name` LIKE ?";
    $stmt = $link->prepare($sql);

    if ($stmt === false) {
        die("Fehler beim Vorbereiten der SQL-Abfrage: " . $link->error);
    }

    // Wildcards (%) an den Suchbegriff anhängen
    $searchTerm = '%' . $name . '%';

    // Parameter binden (zwei Mal den gleichen Parameter binden)
    $stmt->bind_param('ss', $searchTerm, $searchTerm);

    // Abfrage ausführen
    $stmt->execute();

    // Ergebnisse holen
    $result = $stmt->get_result();
    return $result;
}
function doSelectSchiedsrichterByLehrveranstaltung($schiedsrichter,$lehrveranstaltung, $link){
    $query = "SELECT * FROM lehrabendbesuche l WHERE l.SchiedsrichterId=$schiedsrichter AND l.LehrabendId=$lehrveranstaltung;";
    $result = doQuery($query, $link); 
    if ($result) { 
        return true;
    }
    return false;
}
function doSelectPruefungInformationAll($link) {    
    $results = $link->query("SELECT * FROM pruefungen p ORDER BY p.Datum DESC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectPruefungById($ID,$link) {  
    $query = "SELECT * FROM pruefungen p WHERE p.PruefungsId=$ID;";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectSchiedsrichterById($id, $link){
    $query = "SELECT * FROM schiedsrichter s WHERE s.SchiedsrichterId=$id;";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectSchiedsrichterByPruefung($schiedsrichter,$pruefung, $link){
    $query = "SELECT * FROM pruefungsteilnahme p WHERE p.SchiedsrichterId=$schiedsrichter AND p.PruefungsId=$pruefung;";
    $result = doQuery($query, $link); 
    if ($result) { 
        return true;
    }
    return false;
}
function doSelectAnzahlLehrgangTeilnahme($schiedsrichter, $link){
    $query = "SELECT COUNT(*) AS anzahl FROM lehrabendbesuche l WHERE l.SchiedsrichterId=$schiedsrichter;";
    $result = doQuery($query, $link); 
    if ($result) { 
        $row = mysqli_fetch_assoc($result);
        return $row['anzahl'];
    }
    return 0;
}
function doSelectLastKLP($schiedsrichter, $link){
    $query = "SELECT pt.Testpunkte, pt.CooperTestMeter, pt.HelsenTestRunde, p.Test FROM pruefungsteilnahme pt 
                INNER JOIN pruefungen p ON p.PruefungsId=pt.PruefungsId
                WHERE pt.SchiedsrichterId=$schiedsrichter
                ORDER BY p.Datum DESC
                LIMIT 1";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectKaderById($id,$link) {
    $results = $link->query("SELECT * FROM kader k WHERE k.KaderId=$id;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectAllSchiedsrichterInKader($kaderId, $link) {
    $results = $link->query("SELECT s.SchiedsrichterId,s.`Name`,s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht,ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt FROM schiedsrichter s 
                        INNER JOIN kader k ON k.KaderId=s.Kader                        
                        LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                        WHERE k.KaderId=$kaderId;
                        ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectSchiedsrichterByKader($schiedsrichter,$kader, $link){
    $query = "SELECT * FROM schiedsrichter s WHERE s.SchiedsrichterId=$schiedsrichter AND s.Kader=$kader;";
    $result = doQuery($query, $link); 
    if ($result) { 
        return true;
    }
    return false;
}
function doSelectAllSchiedsrichterInLehrveranstaltung($id, $link) {
    $results = $link->query("SELECT s.SchiedsrichterId,s.`Name`,s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht,ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt FROM schiedsrichter s 
                        INNER JOIN lehrabendbesuche l ON l.SchiedsrichterId=s.SchiedsrichterId  
                        LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId   
                        WHERE l.LehrabendId=$id;
                        ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectAllSchiedsrichterInPruefung($id, $link) {
    $results = $link->query("SELECT s.SchiedsrichterId, s.`Name`,s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht,s.Kader, s.Bemerkung, p.Testpunkte, p.CooperTestMeter,p.HelsenTestRunde, pr.Test, ss.Gesamt, ss.NichtAntritt, ss.Rueckgabe
                                FROM pruefungsteilnahme p
                                INNER JOIN schiedsrichter s ON s.SchiedsrichterId=p.SchiedsrichterId
                                INNER JOIN pruefungen pr ON pr.PruefungsId=p.PruefungsId
                                LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                                WHERE p.PruefungsId=$id
                                ORDER BY s.`Name`, s.Vorname;
                        ");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}
function doSelectAktuelleKLP($schiedsrichter,$pruefungsId, $link){
    $query = "SELECT pt.Testpunkte, pt.CooperTestMeter, pt.HelsenTestRunde, p.Test, pt.CooperTest50mSprint, pt.CooperTest200mSprint, pt.HelsenTestKurzstrecke FROM pruefungsteilnahme pt 
                INNER JOIN pruefungen p ON p.PruefungsId=pt.PruefungsId
                WHERE pt.SchiedsrichterId=$schiedsrichter AND p.PruefungsId=$pruefungsId;
                ";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectSchiedsrichterByFilterAlter($start,$ende, $link){
    $query = "SELECT s.SchiedsrichterId, s.`Name`, s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht, k.`Name` AS kaderName, s.Bemerkung, ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt
                                FROM schiedsrichter s
                                LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                                LEFT JOIN kader k ON k.KaderId=s.Kader
                                WHERE TIMESTAMPDIFF(YEAR, s.Geburtsdatum, CURDATE()) >= $start AND TIMESTAMPDIFF(YEAR, s.Geburtsdatum, CURDATE()) <= $ende;
                ";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectSchiedsrichterByFilterQuali($qmax, $link){
    $query = "SELECT s.SchiedsrichterId, s.`Name`, s.Vorname,s.Geburtsdatum,s.SrSeit,s.QMAX,s.Geschlecht, k.`Name` AS kaderName, s.Bemerkung, ss.Gesamt, ss.Herren, ss.Jugend, ss.Frauen, ss.Assistent, ss.Beobachter, ss.Sonstige, ss.Rueckgabe, ss.NichtAntritt
                                FROM schiedsrichter s
                                LEFT JOIN spielestatistik ss ON ss.SchiedsrichterId=s.SchiedsrichterId
                                LEFT JOIN kader k ON k.KaderId=s.Kader
                                WHERE s.QMAX='$qmax';
                ";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}
function doSelectAllQualifikationen($link){
    $query = "SELECT DISTINCT s.QMAX
                FROM schiedsrichter s
                ORDER BY s.QMAX;
                ";
    $result = doQuery($query, $link); 
    if ($result) { 
        return $result;
    }
    return 'not Found';
}

function doSelectLehrgangID($titel,$datum,$link) {  
    $query = "SELECT l.LID FROM lehrgang l WHERE l.Lehrgangsname='$titel' AND l.`Prüfungsdatum`='$datum';";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['LID'];
    }
    return 'not Found';
}

function doSelectAnwaerterForSignelLehrgang($LID,$link) {  
    $results = $link->query("SELECT a.`Status` AS stat, a.AID AS ID, a.Nachname AS nach, a.Vorname AS vor, (YEAR(CURRENT_DATE)-YEAR(a.Geburtsdatum))- (RIGHT(CURRENT_DATE,5)<RIGHT(a.Geburtsdatum,5)) AS soalt,a.Geburtsdatum AS geb, v.Vereinsname AS verein, o.Stadt AS wohnort, a.Freischaltung AS schaltung, a.Talent AS talent, a.uebergabe AS ueber, s.Kuerzel AS qmax, a.Rueckgaben AS rueck, a.Kommentar AS kom
                FROM anwaerter a
                INNER JOIN vereine v ON a.Verein=v.VID
                INNER JOIN ort o ON a.Wohnort=o.PLZ
                LEFT JOIN staffeln s ON a.`QMax-SR`=s.SID
                WHERE a.LID=$LID
                ORDER BY a.Nachname, a.Vorname;");
    if ($results) {
        
        return $results;
    }
    return 'not Found';
}

function doSelectAnzahlEinsaetzeAnwaerter($person,$status,$link) {    
    $query= "SELECT COUNT(s.SID) AS anzahl FROM spiele s WHERE s.Anwaerter=$person AND s.`Status`=$status;";    
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['anzahl'];
    }
    return 'not Found';
}

function doSelectLetztesSpielDatumAnwaerter($AID,$link){
    $query= "SELECT s.Datum AS datum FROM spiele s WHERE s.Anwaerter=$AID AND (s.`Status`=1 OR s.`Status`=2) ORDER BY s.SID DESC LIMIT 1;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['datum'];
    }
    return 'not Found';    
}

function doSelectPateVorName($PID,$link) {    
    $results = $link->query("SELECT p.Vorname AS vor FROM paten p WHERE p.PID=$PID;");
    
    foreach($results as $result) {
        return htmlspecialchars($result['vor']);
        }
}

function doSelectPateNachName($PID,$link) {    
    $results = $link->query("SELECT p.Nachname AS nach FROM paten p WHERE p.PID=$PID;");
    
    foreach($results as $result) {
        return htmlspecialchars($result['nach']);
        }
}

function doSelectAnwaerterVorName($AID,$link) {    
    $results = $link->query("SELECT a.Vorname AS vor FROM anwaerter a WHERE a.AID=$AID;");
    
    foreach($results as $result) {
        return htmlspecialchars($result['vor']);
        }
}

function doSelectAnwaerterNachName($AID,$link) {    
    $results = $link->query("SELECT a.Nachname AS nach FROM anwaerter a WHERE a.AID=$AID;");
    
    foreach($results as $result) {
        return htmlspecialchars($result['nach']);
        }
}

function doSelectAnwaerterKommentar($AID,$link) {
    $results = $link->query("SELECT a.Kommentar FROM anwaerter a WHERE a.AID=$AID;");
    foreach($results as $result){
        return htmlspecialchars($result['Kommentar']);
    }
}

function doSelectAnwaerterDaten($AID,$link) {  
    $query = "SELECT a.Vorname AS vor, a.Nachname AS nach, a.`Status` AS stat, a.Kommentar, a.Freischaltung AS frei, a.Talent, a.uebergabe AS pool, a.`QMax-SR` AS quali,a.Verein, a.Wohnort
                FROM anwaerter a 
                WHERE a.AID=$AID;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
    return 'not Found';
}

function doSelectStaffel($qualiAlt,$link) {    
    $results = $link->query("SELECT s.SID AS ID, s.Kuerzel AS kurz FROM staffeln s ORDER BY s.SID ASC;");
    
    foreach($results as $result) {
        $ID=htmlspecialchars($result['ID']);
        $kurz=htmlspecialchars($result['kurz']);
        if($ID==$qualiAlt){
            echo "<option selected value='$ID'>$kurz</option>";
            
        }else{
            echo "<option value='$ID'>$kurz</option>";            
        }
        }
}

function doSelectSpielForSignelAnwaerter($AID,$link) {  
    $results = $link->query("SELECT s.SID AS nr, s.Datum AS datum, b.Kuerzel AS staffel, p.Vorname AS Pvor, p.Nachname AS Pnach, s.`Status` AS statNr
                                FROM spiele s
                                INNER JOIN paten p ON s.Pate=p.PID
                                INNER JOIN staffeln b ON s.Staffel=b.SID
                                WHERE s.anwaerter=$AID
                                ORDER BY s.Datum;");
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectSpielForSignelPate($PID,$link) {  
    $results = $link->query("SELECT s.SID AS nr, s.Datum AS datum, b.Kuerzel AS staffel, a.Vorname AS Avor, a.Nachname AS Anach, s.`Status` AS statNr
                                FROM spiele s
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                                INNER JOIN staffeln b ON s.Staffel=b.SID
                                WHERE s.Pate=$PID
                                ORDER BY s.Datum;");
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectSpielDaten($SID,$link) {  
    $query = "SELECT s.Datum AS datum, t.Kuerzel AS staffel, a.Vorname AS Avor, a.Nachname AS Anach, p.Vorname AS Pvor, p.Nachname AS Pnach 
                                FROM spiele s 
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                                INNER JOIN paten p ON s.Pate=p.PID
                                INNER JOIN staffeln t ON t.SID=s.Staffel
                                WHERE s.SID=$SID;";
    $result = doQuery($query, $link); 
    if ($result) {
        return mysqli_fetch_assoc($result);
    }
    return 'not Found';
}

function doSelectStatusForSpieldaten($SID, $link) {
$query = "SELECT s.`status` AS erg FROM spiele s
                            WHERE s.SID=$SID;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['erg'];
    }
    return 'not Found';
}

function doSelectPatenSelect($link) {    
    $results = $link->query("SELECT p.PID AS nr, p.Vorname AS vor, p.Nachname AS nach, o.Stadt AS Wohnort 
                                FROM paten p 
                                INNER JOIN ort o ON p.Wohnort=o.PLZ
                                ORDER BY p.Nachname ASC, p.Vorname ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
    
}


function doSelectAnwaerterRueckgabe($ID,$link) {        
    $query = "SELECT a.Rueckgaben as anzahl FROM anwaerter a WHERE a.AID=$ID;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['anzahl'];
    }
    return 'not Found';
}

function doSelectForActionsboard($link) {  
    $results = $link->query("SELECT a.`Status` AS stat, a.AID AS ID, a.Nachname AS nach, a.Vorname AS vor, (YEAR(CURRENT_DATE)-YEAR(a.Geburtsdatum))- (RIGHT(CURRENT_DATE,5)<RIGHT(a.Geburtsdatum,5)) AS soalt,
                                    a.Geburtsdatum AS geb, v.Vereinsname AS verein, o.Stadt AS wohnort, a.Freischaltung AS schaltung, 
                                    a.Talent AS talent, a.uebergabe AS ueber, s.Kuerzel AS qmax, 
                                    a.Rueckgaben AS rueck, a.Kommentar AS kom, l.Lehrgangsname AS lehrgang
                                FROM anwaerter a
                                INNER JOIN vereine v ON a.Verein=v.VID
                                INNER JOIN ort o ON a.Wohnort=o.PLZ
                                LEFT JOIN staffeln s ON a.`QMax-SR`=s.SID
                                INNER JOIN lehrgang l ON a.LID=l.LID
                                WHERE (a.Freischaltung=0 AND a.`Status`=1) OR (a.Freischaltung=1 AND (SELECT COUNT(*) FROM spiele g WHERE g.Anwaerter= a.AID AND (g.`Status`=1 OR g.`Status`=2))>=3 AND a.uebergabe=0)
                                ORDER BY a.Freischaltung DESC, a.Nachname, a.Vorname ASC;");
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectForAnsetzungsboard($link) {  
    $results = $link->query("SELECT a.AID AS nr,a.Vorname AS vor,a.Nachname AS nach, (YEAR(CURRENT_DATE)-YEAR(a.Geburtsdatum))- (RIGHT(CURRENT_DATE,5)<RIGHT(a.Geburtsdatum,5)) AS soalt, a.Geburtsdatum AS geb,v.Vereinsname AS team,w.Stadt AS ort,l.Lehrgangsname AS ltitel,l.`Prüfungsdatum` AS ldatum, a.Kommentar AS kommentar, a.rueckgaben AS rueckgaben
                                FROM anwaerter a
                                INNER JOIN vereine v ON a.Verein=v.VID
                                INNER JOIN lehrgang l ON a.LID=l.LID
                                LEFT JOIN staffeln o ON a.`QMax-SR`=o.SID
                                INNER JOIN ort w ON a.Wohnort=w.PLZ
                                WHERE a.Freischaltung=1 AND a.uebergabe=0 AND (SELECT COUNT(*) FROM spiele g WHERE g.Anwaerter= a.AID AND (g.`Status`=1 OR g.`Status`=2))<=3 AND a.`Status`=1 
                                ORDER BY l.`Prüfungsdatum` ASC, a.Nachname ASC, a.Vorname ASC;");
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectPaten($link) {  
    $results = $link->query("SELECT p.PID as ID, p.Vorname as vor, p.Nachname as nach, (YEAR(CURRENT_DATE)-YEAR(p.Geburtsdatum))- (RIGHT(CURRENT_DATE,5)<RIGHT(p.Geburtsdatum,5)) AS soalt, p.Geburtsdatum as geb, o.Stadt as ort, p.Bemerkung 
                            FROM paten p 
                            INNER JOIN ort o ON p.Wohnort=o.PLZ
                            ORDER BY p.Nachname, p.Vorname;");
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectAnzahlLehrgaeng($link) {
    
    $query = "SELECT COUNT(*) AS anzahl FROM lehrgang l ORDER BY l.`Prüfungsdatum` ASC;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['anzahl'];
    }
    return 'not Found';
}

function doSelectLehrgaenge($link) {
    $results = $link->query("SELECT l.LID AS ID, l.Lehrgangsname AS titel
                                FROM lehrgang l ORDER BY l.`Prüfungsdatum` ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';    
}

function doSelectPatenEinsatzAnzahl($person, $LID ,$link) {
if($LID=='n'){    
    $results = $link->query("SELECT Count(*) as anzahl 
                                FROM spiele s 
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                                WHERE s.Pate=$person AND s.status=2;");
}else{
    $results = $link->query("SELECT Count(*) as anzahl 
                                FROM spiele s 
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                                WHERE s.Pate=$person AND a.LID=$LID AND s.status=2;");
}
    if ($results) {   
        foreach($results as $result) {
            return htmlspecialchars($result['anzahl']);
        }
    }
    return 'not Found';
}

function doSelectAbrechung($start,$ende,$link) {
    $results = $link->query("SELECT p.PID AS nr
                            FROM paten p 
                            INNER JOIN ort o ON p.Wohnort=o.PLZ
                            INNER JOIN spiele s ON p.PID=s.Pate
                            INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                            INNER JOIN staffeln b ON s.Staffel=b.SID
                            WHERE s.Datum>='$start' AND s.Datum<='$ende' AND (s.`Status`=0 OR s.`Status`=1 OR s.`Status`=2 OR s.`Status`=5)
                            ORDER BY p.Nachname, p.Vorname, s.Datum;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';    
}

function doSelectLehrgangInformationAll($link) {    
    $results = $link->query("SELECT l.LID AS ID, l.Lehrgangsname AS titel, l.`Prüfungsdatum` AS datum FROM lehrgang l ORDER BY l.`Prüfungsdatum` DESC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';
}

function doSelectPatenDaten($PID,$link) {
    $query="SELECT p.PID, p.Vorname AS pVor, p.Nachname AS pNach, (YEAR(CURRENT_DATE)-YEAR(p.Geburtsdatum))- (RIGHT(CURRENT_DATE,5)<RIGHT(p.Geburtsdatum,5)) AS soalt, p.Geburtsdatum AS geb, o.Stadt AS wohnort 
                            FROM paten p 
                            INNER JOIN ort o ON o.PLZ=p.Wohnort  
                            WHERE p.PID=$PID;";
    $result = doQuery($query, $link); 
    if ($result) {            
        return mysqli_fetch_assoc($result);
    }
    return 'not Found';    
}

function doSelectSpieleForSinglePaten($PID,$start,$ende,$link) {
    $results = $link->query("SELECT s.Datum AS datum, b.Kuerzel AS staffel, a.Vorname AS Avor, a.Nachname AS Anach, s.`Status` AS stat
                                FROM spiele s
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                                INNER JOIN staffeln b ON s.Staffel=b.SID
                                WHERE s.Pate=$PID AND s.Datum>='$start' AND s.Datum<='$ende' AND (s.`Status`=0 OR s.`Status`=1 OR s.`Status`=2 OR s.`Status`=5)
                                ORDER BY s.Datum;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';    
}

function doSelectVereine($link) {    
    $results = $link->query("SELECT v.VID AS nr, v.Vereinsname AS titel FROM vereine v ORDER BY v.Vereinsname ASC;");    
    
    if ($results) {        
        return $results;
    }
    return 'not Found';  
}

function doSelectWohnorte($link) {    
    $results = $link->query("SELECT o.PLZ, o.Stadt FROM ort o ORDER BY o.PLZ ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found';  
}

function doSelectLoginListe($link) {   
$results = $link->query("SELECT l.LID, s.`Name` AS nach, s.Vorname AS vor, s.Geburtsdatum AS geb, l.letzterLogin AS logi, l.Nutzername AS nutzer, l.TempPasswortErlaubt AS pass
                        FROM login l
                        LEFT JOIN schiedsrichter s ON s.SchiedsrichterId=l.PID
                        WHERE l.LID>0
                        ORDER BY l.letzterLogin DESC;");

    if ($results) {        
        return $results;
    }
    return 'not Found';  
}



function doSelectHistoryListe($link) {   
$results = $link->query("SELECT h.HID, h.Zeitpunkt, h.Aenderung, s.`Name` AS Nachname, s.Vorname, l.Nutzername
                            FROM history h 
                            INNER JOIN login l ON l.LID=h.Bearbeiter
                            LEFT JOIN schiedsrichter s ON s.SchiedsrichterId=l.PID 
                            ORDER BY h.HID DESC
                            LIMIT 25;");

    if ($results) {        
        return $results;
    }
    return 'not Found';  
}

function doSelectAnwaerterSpiele($id, $link) {   
$results = $link->query("SELECT t.Kuerzel FROM spiele s 
                            INNER JOIN staffeln t ON t.SID=s.Staffel
                            WHERE s.Anwaerter=$id AND (s.`Status`=1 OR s.`Status`=2)
                            ORDER BY s.Datum ASC;");

    if ($results) {        
        return $results;
    }
    return 'not Found';  
}
function doSelectLehrgangTitel($ID,$link) {  
    $query = "SELECT l.Lehrgangsname AS titel FROM lehrgang l WHERE l.LID=$ID;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['titel'];
    }
    return 'not Found';
}


function doSelectAllLehrgangsIDs($link) {   
$results = $link->query("SELECT l.LID FROM lehrgang l ORDER BY l.`Prüfungsdatum` ASC");

    if ($results) {        
        return $results;
    }
    return 'not Found';  
}

function doSelectPatenDatenKorrektur($PID,$link) {  
    $query = "SELECT p.Vorname AS vor, p.Nachname AS nach, p.Bemerkung, p.Wohnort
                FROM paten p
                WHERE p.PID=$PID;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    }
    return 'not Found';
}

function doSelectBearbeiter($BID, $link){
    $query = "SELECT p.Vorname,p.Nachname FROM login l LEFT JOIN paten p ON p.PID=l.PID WHERE l.LID=$BID;";
    $result = doQuery($query, $link); 
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['Vorname']." ".$row['Nachname'];
    }
    return 'not Found';
}