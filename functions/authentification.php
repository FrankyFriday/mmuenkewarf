<?php
function doLogin($nutzername, $eingabePasswort, $link) {  
    $temp_passwort="paten";
    $query = "SELECT *
                FROM login l 
                LEFT JOIN schiedsrichter s ON s.SchiedsrichterId=l.PID
                WHERE l.Nutzername = '$nutzername';";
    $result = doQuery($query, $link);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $hash = $row['Passwort'];
        
        $PID= $row['PID'];
        
        $tempPassErlaubt = $row['TempPasswortErlaubt'];
            if ($eingabePasswort == $temp_passwort && $tempPassErlaubt=="1"){
                $tempPassSuccess=true;
            } else {
                $tempPassSuccess=false;

            }
// Passwort überprüfen
        if (password_verify($eingabePasswort, $hash) || $tempPassSuccess) {
            $timestamp = time();
            $datum = date("Y-m-d H:i:s", $timestamp);
            $queryTime = "UPDATE login  SET letzterLogin='".$datum."' WHERE PID='$PID';";
            doInsert($queryTime, $link);
            
             if ($tempPassSuccess){
                $_SESSION['patenTempPass'] = true;
            } else {
                $_SESSION['login'] = true;
            }

            $_SESSION['bearbeiterId'] = $row['LID'];

            $_SESSION['Benutzer'] = $row['Vorname']." ".$row['Name'];
            if($row['RolleLehrwart']==1){
                $_SESSION['lehrwart'] = true;
            }
            if($row['RolleAnsetzer']==1){
                $_SESSION['ansetzer'] = true;
            }
            if($row['RolleAnsetzerPatensystem']==1){
                $_SESSION['ansetzerPatensystem'] = true;
            }
            if($row['RolleBericht']==1){
                $_SESSION['bericht'] = true;
            }
            if($row['RolleVerwaltung']==1){
                $_SESSION['verwaltung'] = true;
            }
            if($row['RolleAdmin']==1){
                $_SESSION['admin'] = true;
            }
            if($row['StartEbene']){
                $_SESSION['StartEbene']=$row['StartEbene'];
            }else{            
                $_SESSION['StartEbene']="start";
            }


            return true;
        } else {
            echo "Falsches Passwort!";
        }        
    } else {
        return false;
    }
}
