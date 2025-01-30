<style>
    th{
        font-size: .8vw;
    }
    td{
        font-size: .8vw;
    }
    .text{
        margin-left: .3vw;
    }
    .legende{
        font-size: .5vw;
    } 

     /*To display the block as level element*/ 
    table.scrolldown tbody,
    table.scrolldown thead {
        display: block;
    }

    table.scrolldown tbody {

         /*Set the height of table body*/ 
        height: 15vh;

         /*Set vertical scroll*/ 
        overflow-y: auto;

         /*Hide the horizontal scroll*/ 
        overflow-x: hidden;
    }
        
    </style>
<?php
require_once './functions/ansichten.php';
require_once './functions/sqlSelect.php';

$valuesAktionsboard= doSelectForActionsboard($link);
?>
<section>
<div class='mt-2'></div>
<center><h2>Aktionsboard</h2></center>
<center><h3>Anwärter*in</h3></center>
<center>
    
   <table border="2px solid black" frame="box" class="scrolldown">  
       <thead class="header">
    <tr bgcolor='#A4A4A4'> 
        <th style="width: 1vw"><center></center></th>
        <th style="width: 8vw"><center>Nachname</center></th>
        <th style="width: 8vw"><center>Vorname</center></th>
        <th style="width: 3vw"><center>Alter</center></th>
        <th style="width: 11vw"><center>Heimatverein</center></th>
        <th style="width: 10vw"><center>Anwärterlehrgang</center></th>
        <th style="width: 5.5vw"><center>DFBnet Kennung</center></th>
        <th style="width: 5vw"><center>Einsätze</center></th>
        <th style="width: 3vw"><center>Talent</center></th>
        <th style="width: 5vw"><center>durchlaufen?</center></th>
        <th style="width: 4.5vw"><center>Übergabe</center></th>
        <th style="width: 5vw"><center>Qmax - SR</center></th>
        <th style="width: 5vw"><center>Aktion</center></th>
        <th style="width: 20vw"><center>Bemerkung</center></th>
        <th style="width: 1.2vw"><center></center></th>
    
    </tr></thead>
   <tbody>
    <?php
    foreach($valuesAktionsboard as $result){
        $ID=htmlspecialchars($result['ID']);
        $status=htmlspecialchars($result['stat']);
        $vorname=htmlspecialchars($result['vor']);
        $nachname=htmlspecialchars($result['nach']);
        $datum=htmlspecialchars($result['soalt']);
        $team=htmlspecialchars($result['verein']);
        $ort=htmlspecialchars($result['wohnort']);
        $dfb=htmlspecialchars($result['schaltung']);
        $talent=htmlspecialchars($result['talent']);
        $pool=htmlspecialchars($result['ueber']);
        $rueckgaben=htmlspecialchars($result['rueck']);
	$kommentar=htmlspecialchars($result['kom']);        
	$lehrgang=substr(htmlspecialchars($result['lehrgang']),17);
        $heute = new DateTime(date('Y-m-d'));
        $quali=htmlspecialchars($result['qmax']);
        $einsaetzeGeplant=doSelectAnzahlEinsaetzeAnwaerter($ID,0,$link);
        $einsaetzeBerichtOffen=doSelectAnzahlEinsaetzeAnwaerter($ID,1,$link);
        $einsaetzeStattGefunden=$einsaetzeBerichtOffen+doSelectAnzahlEinsaetzeAnwaerter($ID,2,$link);
        $farbeGreen='#7FFFD4';
        $farbeRed='#F88379';
        $farbeOrange='#FFA500';
        $farbeYellow='#FFFAA0';
        $farbeWhite='#FFFFFF';
        if($einsaetzeStattGefunden>=3){
            $datSpiel=doSelectLetztesSpielDatumAnwaerter($ID,$link);
            $dat = new DateTime($datSpiel);
            $DatumletztesSpiel=$dat->format('d.m.Y');
            $farbeDurch=$farbeGreen;
        }else{
            $DatumletztesSpiel="nein";
            $farbeDurch=$farbeRed;
        }
        $einsaetze=$einsaetzeGeplant+$einsaetzeStattGefunden;
?>
    <tr>
        <td style="width: 1vw" bgcolor='<?php if($status==1){ echo $farbeGreen;}elseif($status==0){echo $farbeRed;}elseif($status==2){echo $farbeOrange;}?>'></td>
        <td style="width: 8vw" bgcolor='<?php if($status==0){echo $farbeRed;}elseif($status==2){echo $farbeOrange;}elseif($einsaetze>=3 AND $einsaetzeStattGefunden>=3){ echo $farbeGreen;}elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3)){ echo $farbeYellow;}else{echo $farbeWhite;}?>'><span class="text"><?php echo $nachname; ?></span></td>
        <td style="width: 8vw" bgcolor='<?php if($status==0){echo $farbeRed;}elseif($status==2){echo $farbeOrange;}elseif($einsaetze>=3 AND $einsaetzeStattGefunden>=3){ echo $farbeGreen;}elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3)){ echo $farbeYellow;}else{echo $farbeWhite;}?>'><span class="text"><?php echo $vorname; ?></span></td>
        <td style="width: 3vw"><center><?php
            echo $datum;  ?>
        </center></td>
        <td style="width: 11vw"><span class="text"><?php echo $team; ?></span></td>
        <td style="width: 10vw"><span class="text"><?php echo $lehrgang; ?></span></td>
        <td style="width: 5.5vw" bgcolor='<?php if($dfb==0){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php if($dfb==0){ echo 'offen';}else{echo 'vorhanden';}?></center></td>
        <td style="width: 5vw" bgcolor='<?php if($einsaetze>=3 AND $einsaetzeStattGefunden>=3){ echo $farbeGreen;}elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3)){ echo $farbeYellow;}else{echo $farbeWhite;}?>'><center><?php echo $einsaetzeGeplant." / ".$einsaetzeStattGefunden."(".$einsaetzeBerichtOffen.") [".$rueckgaben."]"; ?></center></td>
        <td style="width: 3vw" bgcolor='<?php if($talent==1){echo $farbeGreen;}?>'><center><?php if($talent==1){echo 'ja';} ?></center></td>
        <td style="width: 5vw" bgcolor='<?php echo $farbeDurch; ?>'><center><?php echo $DatumletztesSpiel; ?></center></td>
        <td style="width: 4.5vw" bgcolor='<?php if($pool==0){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php if($pool==0){ echo 'offen';}else{echo 'erl';} ?></center></td>
        <td style="width: 5vw" bgcolor='<?php if($quali==""){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php if($quali==""){ echo "offen";}else{echo $quali;} ?></center></td>
        <td style="width: 5vw"><center>
            <?php if ($_SESSION['ansetzer']) { ?>
        <a href="?content=AnwaerterBearbeiten&anwaerter=<?php echo $ID; ?>&aus=Aktionsboard" style="color:#000000;"><i class="fa fa-user"></i></a>&emsp;
            <?php } ?>
            <?php if ($_SESSION['ansetzer'] or $_SESSION['bericht']) { ?>
        <a href="?content=AnwaerterSpiele&anwaerter=<?php echo $ID; ?>&aus=Aktionsboard" style="color:#000000;"><i class="fa fa-futbol-o"></i></center>
            <?php } ?>
            </td>
	<td  style="width: 20vw;"><span class="text">
	<?php echo $kommentar; ?>
	</span></td>
    </tr>
	<?php
      
    }
?>
    </tbody>
</table>
</center><br>
</section>
<section>
<center><h3>Patenspiele</h3></center>
<center><h5>stattgefunden - Bericht offen</h5></center>
<center>
<?php
    doAnsichtAktionsboardPatenspiele(1,$link);
?>
</center><br>
</section>
<section>
<center><h5>geplante Einteilungen</h5></center>
<center>
<?php
    doAnsichtAktionsboardPatenspiele(0,$link);
?>
</center><br><br>
</section>
<div class='container'>
<div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
<div class="card card-signin my-5">
<div class="card-body">
    <small>
    <table>
    <tr>
        <th colspan="4">
    Legende<br>
        </th>
    </tr>
    <tr>
        <th colspan="3" >
            <span class="legende"> Aktion</span>
        </th>
    </tr>
    <tr>
        <td valign="top" width="220px">
            <i class="fa fa-user-times"/>: <span class="legende">Pate/Patin ändern</span> <br><br>
	    <i class="fa fa-question-circle-o"/>: <span class="legende">Spielstatus ändern</span>
        </td>

        <td valign="top" width="220px">
            <i class="fa fa-trash"/>: <span class="legende">Spiel löschen</span> <br><br>
	    <i class="fa fa-upload"/>: <span class="legende">Bericht hochladen</span>
        </td>
        
	<td valign="top" width="220px">
            <i class="fa fa-user"/>: <span class="legende">Personendaten ändern</span> <br><br>
            <i class="fa fa-futbol-o"/>: <span class="legende">Spielleitungen</span> 
        </td>
    </tr>
</table>      
        </small>
           
</div>
</div>
</div>
</div>