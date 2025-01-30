<?php
function doDeleteTeilnahmeLehrveranstaltung($schiedsrichter, $lehrveranstaltung,$link) {    
//    $aenderung="Folgende Spiel wurde gelöscht: ".$SID."";
//    doInsertHistory($aenderung, $link);
    $query = "DELETE FROM lehrabendbesuche WHERE SchiedsrichterId=$schiedsrichter AND LehrabendId=$lehrveranstaltung;";
    $link->query($query);
}



///Müll
function doDeleteSpiel($SID,$link) {    
    $aenderung="Folgende Spiel wurde gelöscht: ".$SID."";
    doInsertHistory($aenderung, $link);
    $query = "DELETE FROM spiele WHERE SID=$SID;";
    $link->query($query);
}

