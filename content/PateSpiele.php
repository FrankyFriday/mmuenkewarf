<?php
require_once './functions/fileManagement.php';
require_once './functions/sqlSelect.php';
$PID = $_GET['pate'];

$values=doSelectSpielForSignelPate($PID,$link);
$pateVorname=doSelectPateVorName($PID,$link);
$pateNachname=doSelectPateNachName($PID,$link);
?>
<div class='container'>
    <form method='post' >
    <div class="row">
<!--EINGABE-->
        <div class=" mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    <h2 class="container card-title text-center btn-lg btn-warning ">Pate/Patin:&emsp;<?php echo $pateNachname.", ".$pateVorname; ?></h2>
                    <div class="mt-2">
                     
        <table border="2px solid black" frame="box">  
            <tr bgcolor='#A4A4A4'> 
                <th width=100><p align="center">Datum</p></th>
                <th width=80><p align="center">Staffel</p></th>
                <th width=200><p align="center">Pate/Patin</p></th>
                <th width=180><p align="center">Status</p></th>
                <th width=100><p align="center">Bericht</p></th>
            </tr>
                <?php
    foreach($values as $result) {
        $SID=htmlspecialchars($result['nr']);
        $datum=htmlspecialchars($result['datum']);
        $date = new DateTime($datum);
        $staffel=htmlspecialchars($result['staffel']);
        $Avor=htmlspecialchars($result['Avor']);
        $Anach=htmlspecialchars($result['Anach']);
        $statNr=htmlspecialchars($result['statNr']);
        switch ($statNr) {
            case 0:
                $statTitel="geplant";
                $farbe='#FFFFFF'; //White
                break;
            case 1:
                $statTitel="stattgefunden";
                $farbe='#ADD8E6'; //Blue
                break;
            case 2:
                $statTitel="stattgefunden";
                $farbe='#7FFFD4'; //Green
                break;
            case 3:
                $statTitel="Spielausfall am Spieltag";
                $farbe='#FFD580'; //Orange
                break;
            case 4:
                $statTitel="Spielausfall ohne Meldung an SR/Paten";
                $farbe='#702963'; //lila
                break;
            case 5:
                $statTitel="Pate/Patin nicht aufgetaucht";
                $farbe='#FFD580'; //Orange
                break;
        }
        
    ?>
        <tr bgcolor='<?php echo $farbe;?>'>
            <td><div align="center"><?php echo $date->format('d.m.Y'); ?></div></td>
            <td><div align="center"><?php echo $staffel; ?></div></td>
            <td><div align="center"><?php echo $Anach.", ".$Avor; ?></div></td>
            <td><div align="center"><?php echo $statTitel; ?></div></td>
            <td><div align="center"><?php fileDoSearchBericht($datum,$Avor,$Anach); ?></div></td>
           
        </tr>
    <?php } ?>
    </table>
                   
                    </div>
                    <div class="mt-2">
                        <a class="dropdown-item" href="?content=patenAuflistung"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

