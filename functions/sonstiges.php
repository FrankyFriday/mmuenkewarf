<?php
function generateSelectOptionsStatusSpiel($lastStatus) {    
    switch ($lastStatus) {
        case 0:
echo "<option value='1'>stattgefunden (Bericht offen)</option>";
echo "<option value='3'>Spielausfall am Spieltag (Spiel bleibt)</option>";
echo "<option value='4'>Spielausfall ohne Meldung an SR/Paten</option>";
echo "<option value='5'>Pate/Patin nicht aufgetaucht</option>";
            break;
        case 1:
echo "<option value='0'>geplant</option>";
echo "<option value='3'>Spielausfall am Spieltag (Spiel bleibt)</option>";
echo "<option value='4'>Spielausfall ohne Meldung an SR/Paten</option>";
echo "<option value='5'>Pate/Patin nicht aufgetaucht</option>";
            break;
        case 2:
echo "<option value='3'>Spielausfall am Spieltag (Spiel bleibt)</option>";
echo "<option value='4'>Spielausfall ohne Meldung an SR/Paten</option>";
echo "<option value='5'>Pate/Patin nicht aufgetaucht</option>";
            break;
        case 3:  
echo "<option value='4'>Spielausfall ohne Meldung an SR/Paten</option>";
echo "<option value='0'>geplant</option>";
            break;
        default:
            break;
    }    
}



