
<?php
require_once './functions/sqlSelect.php';
require_once './functions/fileManagement.php';

if(isset($_POST['return'])){
    $dateStart= substr($_POST['startzeit'], 0, -3);
    $dateEnd=substr($_POST['endzeit'], 0, -3);
    $currentPate=$_POST['pate'];
}
?>
<div class='container'>
    <form method='post' action='?content=Abrechnung'>
 <?php
if (!$_POST['suchen']) {
?>       
    <table border="1" class='table table-striped'>
        
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-lg-auto mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">A B R E C H N U N G E N</h2>
                                <form class="form-signin">
                                    <div class="form-label-group mt-4">
                                        <label for="start">Start: &ensp;&ensp;&nbsp;</label> 
                                            <input type="month" name="start" required value="<?php echo $dateStart; ?>">
                                            <br><small>es wird der 1. Tag des Monats gewertet</small>
                                    </div>
                                    <div class="form-label-group mt-4">
                                        <label for="ende">Ende:&ensp;&ensp;&nbsp;</label> 
                                            <input type="month" name="ende" required value="<?php echo $dateEnd; ?>">
                                            <br><small>es wird der letzte Tag des Monats gewertet</small>
                                    </div>
                                    <div class="form-label-group mt-4">
                                        <label for="paten">Pate/Patin: &nbsp;</label>
                                        <select name="paten" id="paten" required>
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            $results=doSelectPatenSelect($link);
                                                foreach($results as $result) {
                                                    $nr=htmlspecialchars($result['nr']);
                                                    $vorname=htmlspecialchars($result['vor']);
                                                    $nachname=htmlspecialchars($result['nach']);
                                                    $ort=htmlspecialchars($result['Wohnort']);
                                                    if($nr==$currentPate){
                                                    echo "<option selected value='$nr'>$nachname, $vorname ($ort)</option>";                                                        
                                                    }else{
                                                    echo "<option value='$nr'>$nachname, $vorname ($ort)</option>";
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
				    
				    <button class="btn btn-lg btn-primary btn-block mt-4" name="suchen" type="submit" value="suchen">suchen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
    <center>
<?php

}else{
    $PID=$_POST['paten'];
    $start=$_POST['start'].'-01';
    $ende=$_POST['ende'];
    $datumende=date('Y-m-t', strtotime($ende));
    
    $patendaten= doSelectPatenDaten($PID,$link);
            ?>
        
        <div class="mt-4"></div>
        <div class="col-lg-9 mx-auto">
            <div class="card card-signin">
                <div class="card-body">
                    <h2 class=" text-center btn-sm btn-info ">
                        <span style="font-size: 1.5vw"><?php echo $patendaten['pNach'].", ".$patendaten['pVor']."&ensp;(".$patendaten['wohnort'].")"."&ensp;Alter: ".$patendaten['soalt']?></span><br>
                        <span style="font-size: 1vw">ausgewähler Zeitraum: 
                            <?php 
                                $startAusgabe = new DateTime($start);
                                $datumendeAnzeige = new DateTime($datumende);
                                echo $startAusgabe->format('d.m.Y')." - ".$datumendeAnzeige->format('d.m.Y'); 
                            ?> </span>
                    </h2>
                    <div class="mt-4">
                    <?php 
                    $results= doSelectSpieleForSinglePaten($PID, $start, $datumende, $link);
                    ?>
                    <table border="2px solid black" frame="box">  
            <tr bgcolor='#A4A4A4'> 
                <th width=130><p align="center">Datum</p></th>
                <th width=100><p align="center">Staffel</p></th>
                <th width=220><p align="center">Anw&auml;rter</p></th>                
                <th width=180><p align="center">Status</p></th>
                <th width=140><p align="center">Bericht</p></th>
            </tr>
                <?php
    foreach($results as $result) {
        $datum=htmlspecialchars($result['datum']);        
        $date = new DateTime($datum);
        $staffel=htmlspecialchars($result['staffel']);
        $Avor=htmlspecialchars($result['Avor']);
        $Anach=htmlspecialchars($result['Anach']);
        $statNr=htmlspecialchars($result['stat']);
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
                $statTitel="Spielausfall am Spieltag <br>(Spiel bleibt)";
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
            <td><div align="center"><?php fileDoSearchBericht($datum, $Avor, $Anach); ?></div></td>
        </tr>
    <?php } ?>
    </table>
                    </div>
                    <button class="btn btn-lg btn-primary btn-block mt-4" name="return" type="submit" value="return">zurück</button>
                    <input type="hidden" name="startzeit" value="<?php echo $start ?>">
                    <input type="hidden" name="endzeit" value="<?php echo $datumende ?>">
                    <input type="hidden" name="pate" value="<?php echo $PID ?>">
                </div>
            </div>
        </div>
        <?php
} 

?>
        </center>
</div>

