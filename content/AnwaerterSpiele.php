<?php
require_once './functions/fileManagement.php';
require_once './functions/sqlSelect.php';
$AID = $_GET['anwaerter'];
$aus = $_GET['aus'];
$LID = $_GET['LID'];

$values=doSelectSpielForSignelAnwaerter($AID,$link);
$anwaerterVorname=doSelectAnwaerterVorName($AID,$link);
$anwaerterNachname=doSelectAnwaerterNachName($AID,$link);
?>
<div class='container'>
    <form method='post' >
    <div class="row">
<!--EINGABE-->
        <div class=" mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    <h2 class="container card-title text-center btn-lg btn-warning ">Anwärter*in:&emsp;<?php echo $anwaerterNachname.", ".$anwaerterVorname; ?></h2>
                    <div class="mt-2">
                     
        <table border="2px solid black" frame="box">  
            <tr bgcolor='#A4A4A4'> 
                <th width=100><p align="center">Datum</p></th>
                <th width=80><p align="center">Staffel</p></th>
                <th width=200><p align="center">Pate/Patin</p></th>
                <th width=180><p align="center">Status</p></th>
                <th width=100><p align="center">Bericht</p></th>
                <th width=140><p align="center">Aktion</p></th>
            </tr>
                <?php
    foreach($values as $result) {
        $SID=htmlspecialchars($result['nr']);
        $datum=htmlspecialchars($result['datum']);
        $date = new DateTime($datum);
        $staffel=htmlspecialchars($result['staffel']);
        $Pvor=htmlspecialchars($result['Pvor']);
        $Pnach=htmlspecialchars($result['Pnach']);
        $statNr=htmlspecialchars($result['statNr']);
        switch ($statNr) {
            case 0:
                $pate=true;
                $bericht=false;
                $delete=true;
                $status=true;
                $statTitel="geplant";
                $farbe='#FFFFFF'; //White
                break;
            case 1:
                $pate=true;
                $bericht=true;
                $delete=false;
                $status=true;
                $statTitel="stattgefunden";
                $farbe='#ADD8E6'; //Blue
                break;
            case 2:
                $pate=false;
                $bericht=true;
                $delete=false;
                $status=true;
                $statTitel="stattgefunden";
                $farbe='#7FFFD4'; //Green
                break;
            case 3:
                $pate=false;
                $bericht=false;
                $delete=false;
                $status=true;
                $statTitel="Spielausfall am Spieltag";
                $farbe='#FFD580'; //Orange
                break;
            case 4:
                $pate=false;
                $bericht=false;
                $delete=false;
                $status=false;
                $statTitel="Spielausfall ohne Meldung an SR/Paten";
                $farbe='#702963'; //lila
                break;
            case 5:
                $pate=false;
                $bericht=false;
                $delete=false;
                $status=false;
                $statTitel="Pate/Patin nicht aufgetaucht";
                $farbe='#FFD580'; //Orange
                break;
        }
        
    ?>
        <tr bgcolor='<?php echo $farbe;?>'>
            <td><div align="center"><?php echo $date->format('d.m.Y'); ?></div></td>
            <td><div align="center"><?php echo $staffel; ?></div></td>
            <td><div align="center"><?php echo $Pnach.", ".$Pvor; ?></div></td>
            <td><div align="center"><?php echo $statTitel; ?></div></td>
            <td><div align="center"><?php fileDoSearchBericht($datum,$anwaerterVorname,$anwaerterNachname); ?></div></td>
            <td>
       
        <center>
<?php
              
        if($pate and $_SESSION['ansetzerPatensystem']){
?>
            <a href="?content=SpielBearbeiten&vor=AnwaerterSpiele&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>&LID=<?php echo $LID; ?>" style="color:#000000;"><i class="fa fa-user-times"></i></a>&emsp;
<?php 
        }
        if($delete and $_SESSION['ansetzerPatensystem']){
?>
            <a href="?content=SpielLoeschen&vor=AnwaerterSpiele&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>&LID=<?php echo $LID; ?>" style="color:#000000;"><i class="fa fa-trash"></i></a>&emsp;
<?php 
        }
        if($status and ($_SESSION['ansetzerPatensystem'] || $_SESSION['bericht'])){
?>
            <a href="?content=AnwaerterSpieleStatus&vor=AnwaerterSpiele&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>&LID=<?php echo $LID; ?>" style="color:#000000;"><i class="fa fa-question-circle-o"></i></a>
<?php 
        }
        if($bericht and $_SESSION['bericht']){
?>
            &emsp;<a href="?content=BerichteHochladen&vor=AnwaerterSpiele&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>&LID=<?php echo $LID; ?>" style="color:#000000;"><i class="fa fa-upload"></i></a>
        <?php } ?>
            </center>
        
            </td>
        </tr>
    <?php } ?>
    </table>
                   
                    </div>
                    <div class="mt-2">
                        <?php if($_SESSION['ansetzerPatensystem']){ ?>
                    <a href="?content=anlegenSpiel&vor=AnwaerterSpiele&anwaerter=<?php echo $AID;?>&aus=<?php echo $_GET['aus'];?>&LID=<?php echo $_GET['LID'];?>" class="btn btn-lg btn-primary btn-block mt-4" name="anlegen" type="submit" value="anlegen">weiteres Spiel hinzufügen</a>
                        <?php } ?>      
                    <?php if($aus=='Lehrgang'){ ?>
                        <a class="dropdown-item" href="?content=Lehrgang&LID=<?php echo $_GET['LID'];?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Lehrgangsübersicht</center></a>
                    <?php }else{ ?>
                        <a class="dropdown-item" href="?content=<?php echo $aus; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>
<div class='container'>
<div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
<div class="card card-signin my-5">
<div class="card-body">
    <small>
    <table>
    <tr>
        <th colspan="4">
    Legende<br><br>
        </th>
    </tr>
    <tr>
        <th colspan="4" >
            Aktion
        </th>
    </tr>
    <tr>
        <td valign="top" width="220px">
            <i class="fa fa-user-times"/>: Pate/Patin ändern <br><br>
        </td>
        <td valign="top" width="220px">
            <i class="fa fa-question-circle-o"/>: Spielstatus ändern <br><br> 
        </td>
        <td valign="top" width="220px">
            <i class="fa fa-trash"/>: Spiel löschen <br><br>
        </td>
        <td valign="top" width="220px">
            <i class="fa fa-upload"/>: Bericht hochladen <br><br>
        </td>
    </tr>
</table>      
        </small>
           
</div>
</div>
</div>
</div>
