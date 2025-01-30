<?php
function fileDoSearchBericht($datum, $Avor, $Anach){
    $dateiname = $Anach."_".$Avor."_".$datum;
    
    $upload_folder = './berichte/'; //Das Upload-Verzeichnis
    $filename = $dateiname;
    $extension = 'pdf';
    
    $new_path = $upload_folder.$filename.'.'.$extension;
    if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
       echo '<a href="'.$new_path.'" target="_blank" color="green"><i class="fa fa-file-pdf-o"> vorhanden</i></a>';
    } else {
        echo '<font color="red">offen</font>';
    }
}

function fileDoSearchBerichtVorhanden($datum, $Avor, $Anach){
    $dateiname = $Anach."_".$Avor."_".$datum;
    
    $upload_folder = './berichte/'; //Das Upload-Verzeichnis
    $filename = $dateiname;
    $extension = 'pdf';
    
    $new_path = $upload_folder.$filename.'.'.$extension;
    if(file_exists($new_path)) { //Falls Datei existiert, hänge eine Zahl an den Dateinamen
       return true;
    } else {
        return false;
    }
}

function fileDoCreateDateiname($SID,$link) {    
    $results = $link->query("SELECT s.Datum AS datum, a.Vorname AS Avor, a.Nachname AS Anach
                                FROM spiele s 
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID 
                                WHERE s.SID=$SID ORDER BY s.SID ASC;");
    
    if ($results) {        
        return $results;
    }
    return 'not Found'; 
}



