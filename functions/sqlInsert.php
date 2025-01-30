<?php
function doInsertLehrveranstaltung($art,$thema, $datum, $startzeit, $standort,$referent,$link){
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $zeitpunkt = date('Y-m-d H:i:s', strtotime("$datum $startzeit"));
    $query = "INSERT INTO lehrabende (Art,Thema,Datum,Standort,Referent,erstelltVon,letzteAenderungVon)
                VALUEs ('$art','$thema', '$zeitpunkt', '$standort','$referent','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    if ($regitSuccess){
        $aenderungsText="neuer Lehrveranstaltung angelegt: ".$zeitpunkt."-".$art.": ".$thema;
        doInsertHistory($aenderungsText, $link);
        echo "<br>Lehrveranstaltung erfolgreich angelegt: ".$art." - ".$thema." (".$datum.")";
    }else{
        echo "<br>Es trat ein Fehler auf. Wiederholen Sie den Vorgang!";
    }  
}
function doInsertPruefung($art,$test, $datum, $startzeit, $standort,$pruefer,$link){
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $zeitpunkt = date('Y-m-d H:i:s', strtotime("$datum $startzeit"));
    $query = "INSERT INTO pruefungen (Art,Test,Datum,Standort,pruefer,erstelltVon,letzteAenderungVon)
                VALUEs ('$art','$test', '$zeitpunkt', '$standort','$pruefer','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    if ($regitSuccess){
        $aenderungsText="neue Prüfung angelegt: ".$art." - ".$test." (".$datum.")";
        doInsertHistory($aenderungsText, $link);
        echo "<br>Prüfung erfolgreich angelegt: ".$art." - ".$test." (".$datum.")";
    }else{
        echo "<br>Es trat ein Fehler auf. Wiederholen Sie den Vorgang!";
    }  
}
function doInsertTeilnahmeLehrveranstaltung($schiedsrichter,$lehrveranstaltung,$link) {
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO lehrabendbesuche (SchiedsrichterId,LehrabendId,erstelltVon,letzteAenderungVon)
                VALUEs ('$schiedsrichter','$lehrveranstaltung', '$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    if ($regitSuccess){
        $aenderungsText="neuer Teilnehmer für Lehrveranstaltung (".$lehrveranstaltung.") angelegt: ".$schiedsrichter;
        doInsertHistory($aenderungsText, $link);
    } 
}
function doInsertPruefungsErgebnisse($pruefung, $schiedsrichter, $fehlerpunkte, $runden, $strecke,$Sprint200m, $Sprint50m, $sprints, $link) {
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO pruefungsteilnahme (PruefungsId, SchiedsrichterId, Testpunkte, HelsenTestRunde, CooperTestMeter, CooperTest50mSprint, CooperTest200mSprint, HelsenTestKurzstrecke, erstelltVon,letzteAenderungVon)
                VALUEs ('$pruefung','$schiedsrichter', '$fehlerpunkte', '$runden','$strecke','$Sprint50m','$Sprint200m','$sprints','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    if ($regitSuccess){
        $aenderungsText="neuer Ergebnisse für Prüfung (".$pruefung.") angelegt: ".$schiedsrichter;
        doInsertHistory($aenderungsText, $link);
    }else{
        echo "<br>Es trat ein Fehler auf. Wiederholen Sie den Vorgang!";
    } 
}

function doInsertHistory($aenderungsText, $link){
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO history (Bearbeiter,Aenderung)
                VALUEs ('$bearbeiterId','$aenderungsText');";
    doInsert($query, $link);
}

function doInsertAnwaerter($vorname, $nachname, $geburtsdatum, $wohnort, $verein, $lehrgang, $link) {
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO anwaerter (Vorname,Nachname,Geburtsdatum,Wohnort,Verein,LID,erstelltVon,letzteAenderungVon) 
                VALUEs ('$vorname','$nachname', '$geburtsdatum', '$wohnort','$verein','$lehrgang','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    
    if ($regitSuccess){
        $aenderungsText="neuer Anwärter angelegt: ".$vorname." ".$nachname;
        doInsertHistory($aenderungsText, $link);
        echo "<br>Anw&auml;rter*in erfolgreich angelegt: ".$nachname.", ".$vorname;
    }else{
        echo "<br>Es trat ein Fehler auf. Wiederholen Sie den Vorgang!";
    }    
}

function doInsertPate($vorname, $nachname, $geburtsdatum, $wohnort, $link) {
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO paten (Vorname, Nachname, Geburtsdatum, Wohnort,erstelltVon,letzteAenderungVon)
                VALUEs ('$vorname','$nachname', '$geburtsdatum', '$wohnort','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    
    if ($regitSuccess){
        $aenderungsText="neuer Pate angelegt: ".$vorname." ".$nachname;
        doInsertHistory($aenderungsText, $link);
        echo "<br>Paten erfolgreich angelegt: ".$nachname.", ".$vorname;
    }else{
        echo "<br>Es trat ein Fehler auf. Wiederholen Sie den Vorgang!";
    }    
}

function doInsertLehrgang($titel, $termin, $link) {
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO lehrgang (Lehrgangsname, `Prüfungsdatum`,erstelltVon,letzteAenderungVon)
                VALUEs ('$titel','$termin','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    
    if ($regitSuccess){
        $aenderungsText="neuer Lehrgang angelegt: ".$titel;
        doInsertHistory($aenderungsText, $link);
        return true;
    }else{
        return false;
    }    
}

function doInsertSpiel($anwaerter, $paten, $staffel, $datum, $link) {
    $bearbeiterId=$_SESSION['bearbeiterId'];
    $query = "INSERT INTO spiele (Anwaerter,Pate, Staffel, Datum,erstelltVon,letzteAenderungVon)
                VALUEs ('$anwaerter','$paten', '$staffel', '$datum','$bearbeiterId','$bearbeiterId');";
    $regitSuccess = doInsert($query, $link);
    
    if ($regitSuccess){
        $aenderungsText="neues Spiel angelegt: ".$datum." - ".$anwaerter;
        doInsertHistory($aenderungsText, $link);
        return true;
    }else{
        return false;
    }    
}


