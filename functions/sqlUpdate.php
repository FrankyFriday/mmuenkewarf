<?php
function doUpdateKaderFromSchiedsrichter($ID, $wert, $link){
    $bearbeiter=$_SESSION['bearbeiterId'];  
    if($wert=="delete"){
        $insertQuery = "UPDATE schiedsrichter SET Kader = NULL, letzteAenderungVon = $bearbeiter WHERE SchiedsrichterId=$ID;";
    }else{
          $insertQuery = "UPDATE schiedsrichter SET Kader = $wert, letzteAenderungVon = $bearbeiter WHERE SchiedsrichterId=$ID;";
    }
//    $aenderung="Der Status für den Anwärter ".$ID." wurde geändert.";
//    doInsertHistory($aenderung, $link); 
    doInsert($insertQuery, $link);
}



///MÜll
function doUpdateAnwaerterStatus($ID,$wert,$link) { 
    $aenderung="Der Status für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link); 
    $bearbeiter=$_SESSION['bearbeiterId'];  
    $insertQuery = "UPDATE anwaerter SET Status = $wert, letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterKommentar($ID,$wert,$link) { 
    $aenderung="Der Kommentar für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];   
    $insertQuery = "UPDATE anwaerter SET Kommentar = '$wert', letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterDFBnet($ID,$wert,$link) {   
    $aenderung="Die Freischaltung für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link); 
    $bearbeiter=$_SESSION['bearbeiterId'];
    $insertQuery = "UPDATE anwaerter SET Freischaltung = $wert, letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterTalent($ID,$wert,$link) { 
    $aenderung="Das Talent für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];   
    $insertQuery = "UPDATE anwaerter SET Talent = $wert, letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterPool($ID,$wert,$link) {   
    $aenderung="Die Poolübergabe für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId']; 
    $insertQuery = "UPDATE anwaerter SET uebergabe = $wert, letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterQualifikation($ID,$wert,$link) {
    $aenderung="Die Qmax für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];    
    $insertQuery = "UPDATE anwaerter SET `QMax-SR` = '$wert', letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterVerein($ID,$wert,$link) {
    $aenderung="Der Verein für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];    
    $insertQuery = "UPDATE anwaerter SET Verein = '$wert', letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterWohnort($ID,$wert,$link) {
    $aenderung="Der Wohnort für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];    
    $insertQuery = "UPDATE anwaerter SET Wohnort = '$wert', letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdateSpielStatus($SID,$status,$link) { 
    $aenderung="Der Status wurde für folgendes Spiel geändert ".$SID."";
    doInsertHistory($aenderung, $link);  
    $bearbeiter=$_SESSION['bearbeiterId']; 
    $insertQuery = "UPDATE spiele SET `Status`=$status, letzteAenderungVon = $bearbeiter WHERE SID=$SID;";
    doInsert($insertQuery, $link);
}

function doUpdateSpielPate($SID,$PID,$link) { 
    $aenderung="Der Pate wurde für folgendes Spiel geändert ".$SID."";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];
    $insertQuery = "UPDATE spiele SET Pate=$PID, letzteAenderungVon = $bearbeiter WHERE SID=$SID;";
    doInsert($insertQuery, $link);
}

function doUpdateAnwaerterRueckgabe($ID,$wert,$link) {  
    $aenderung="Die Rückgaben für den Anwärter ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];
    $insertQuery = "UPDATE anwaerter SET Rueckgaben = $wert, letzteAenderungVon = $bearbeiter WHERE AID=$ID;";
    doInsert($insertQuery, $link);  
}

function doUpdateBerichtVorhanden($SID,$link) {  
    $bearbeiter=$_SESSION['bearbeiterId'];  
    $insertQuery="UPDATE spiele s SET s.`Status`=2, letzteAenderungVon = $bearbeiter WHERE s.SID=$SID;"; 
    $aenderung="Es wurde ein Bericht für Spielnr. ".$SID." angelegt";
    doInsertHistory($aenderung, $link);
    return mysqli_query($link, $insertQuery);
}

function doUpdateLoginPasswort($newPasswort,$link) {  
    $bearbeiter=$_SESSION['bearbeiterId'];  
    $insertQuery="UPDATE login l SET l.Passwort='$newPasswort', l.TempPasswortErlaubt=0 WHERE l.LID=$bearbeiter;"; 
    $aenderung="Es wurde ein neues Passwort für LID ".$bearbeiter." angelegt";
    doInsertHistory($aenderung, $link);
    return mysqli_query($link, $insertQuery);
}

function doUpdatePasswortToTemp($LID,$link){  
    $insertQuery="UPDATE login SET TempPasswortErlaubt=0 WHERE l.LID=$LID;"; 
    $aenderung="Das Passwort für LID: ".$LID." wurde zurückgesetzt";
    doInsertHistory($aenderung, $link);
    return mysqli_query($link, $insertQuery);
}

function doUpdatePatenKommentar($ID,$wert,$link) { 
    $aenderung="Der Kommentar für den Paten ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];   
    $insertQuery = "UPDATE paten SET Bemerkung = '$wert', letzteAenderungVon = $bearbeiter WHERE PID=$ID;";
    doInsert($insertQuery, $link);
}

function doUpdatePatenWohnort($ID,$wert,$link) { 
    $aenderung="Der Wohnort für den Paten ".$ID." wurde geändert.";
    doInsertHistory($aenderung, $link);
    $bearbeiter=$_SESSION['bearbeiterId'];   
    $insertQuery = "UPDATE paten SET Wohnort = '$wert', letzteAenderungVon = $bearbeiter WHERE PID=$ID;";
    doInsert($insertQuery, $link);
}

