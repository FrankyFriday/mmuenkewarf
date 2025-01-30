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
    

.arrow-right {
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 20px solid black;
}
.arrow-left {
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 20px solid black;
}

    </style>
<?php
require_once './functions/sqlSelect.php';
$lehrgang=$_GET['LID'];
$results=doSelectAllLehrgangsIDs($link);
$lehrgaengsIds = array();
foreach($results as $result) {
        $id=htmlspecialchars($result['LID']);
        array_push($lehrgaengsIds,$id);
}
$index = array_search($lehrgang, $lehrgaengsIds);
?>
    
<div class='mt-4'></div>
<center>
    <table>
        <tr>
            <td style="width: 2vw">
                <?php if($index>=1){ ?>
                <a href="?content=Lehrgang&LID=<?php echo $lehrgaengsIds[$index-1]; ?>"><div class="arrow-left"></div></a>
                <?php } ?>
            </td>
            <td style="width: 88vw"><center><h3><?php echo doSelectLehrgangTitel($lehrgang,$link); ?> </h3></center></td>
            <td style="width: 2vw">
                <?php if(count($lehrgaengsIds)>$index+1){ ?>
                <a href="?content=Lehrgang&LID=<?php echo $lehrgaengsIds[$index+1]; ?>"><div class="arrow-right"></div></a>
                <?php } ?>
            </td>
        </tr>
    </table>
    
    
</center>
   
<center>

<table border="2px solid black" frame="box">  
    <tr bgcolor='#A4A4A4'> 
        <th style="width: 1vw"><center></center></th>
        <th style="width: 8vw"><center>Nachname</center></th>
        <th style="width: 8vw"><center>Vorname</center></th>
        <th style="width: 3vw"><center>Alter</center></th>
        <th style="width: 11vw"><center>Heimatverein</center></th>
        <th style="width: 8vw"><center>Wohnort</center></th>
        <th style="width: 5vw"><center>DFBnet Freischaltung</center></th>
        <th style="width: 5vw"><center>Einsätze</center></th>
        <th style="width: 3vw"><center>Talent</center></th>
        <th style="width: 6vw"><center>durchlaufen?</center></th>
        <th style="width: 4.5vw"><center>Übergabe</center></th>
        <th style="width: 4.5vw"><center>Qmax-SR</center></th>
        <th style="width: 5vw"><center>Aktion</center></th>
        <th style="width: 20vw"><center>Bemerkung</center></th>
    </tr>
    
    <?php
    $results = doSelectAnwaerterForSignelLehrgang($lehrgang,$link);
    $i=0;
    foreach($results as $result){
        $i++;
        $ID=htmlspecialchars($result['ID']);
        $status=htmlspecialchars($result['stat']);
        $vorname=htmlspecialchars($result['vor']);
        $nachname=htmlspecialchars($result['nach']);
        $alter=htmlspecialchars($result['soalt']);
        $team=htmlspecialchars($result['verein']);
        $ort=htmlspecialchars($result['wohnort']);
        $dfb=htmlspecialchars($result['schaltung']);
        $talent=htmlspecialchars($result['talent']);
        $pool=htmlspecialchars($result['ueber']);
        $quali=htmlspecialchars($result['qmax']);
        $rueckgaben=htmlspecialchars($result['rueck']);
	$kommentar=htmlspecialchars($result['kom']);
        
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
        <td bgcolor='<?php if($status==1){ echo $farbeGreen;}elseif($status==0){echo $farbeRed;}elseif($status==2){echo $farbeOrange;}?>'></td>
        <td bgcolor='<?php if($status==0){echo $farbeRed;}elseif($status==2){echo $farbeOrange;}elseif($einsaetze>=3 AND $einsaetzeStattGefunden>=3){ echo $farbeGreen;}elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3)){ echo $farbeYellow;}else{echo $farbeWhite;}?>'><span class="text"><?php echo $nachname; ?></span></td>
        <td bgcolor='<?php if($status==0){echo $farbeRed;}elseif($status==2){echo $farbeOrange;}elseif($einsaetze>=3 AND $einsaetzeStattGefunden>=3){ echo $farbeGreen;}elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3)){ echo $farbeYellow;}else{echo $farbeWhite;}?>'><span class="text"><?php echo $vorname; ?></span></td>
        <td><center><?php echo $alter; ?>
        </center></td>
        <td bgcolor='<?php if($team=="vereinslos"){ echo $farbeYellow;}?>'><span class="text"><?php echo $team; ?></span></td>
        <td><span class="text"><?php echo $ort; ?></span></td>
        <td bgcolor='<?php if($dfb==0){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php if($dfb==0){ echo 'offen';}else{echo 'vorhanden';} ?></center></td>
        <td bgcolor='<?php if($einsaetze>=3 AND $einsaetzeStattGefunden>=3){ echo $farbeGreen;}elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3)){ echo $farbeYellow;}else{echo $farbeWhite;}?>'><center><?php echo $einsaetzeGeplant." / ".$einsaetzeStattGefunden."(".$einsaetzeBerichtOffen.") [".$rueckgaben."]"; ?></center></td>
        <td bgcolor='<?php if($talent==1){echo $farbeGreen;}?>'><center><?php if($talent==1){echo 'ja';} ?></center></td>
        <td bgcolor='<?php echo $farbeDurch; ?>'><center><?php echo $DatumletztesSpiel; ?></center></td>
        <td bgcolor='<?php if($pool==0){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php if($pool==0){ echo 'offen';}else{echo 'erledigt';} ?></center></td>
        <td bgcolor='<?php if($quali==null){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php if($quali==null){ echo "offen";}else{echo $quali;} ?></center></td>
        <td><center>
            <?php if($_SESSION['ansetzerPatensystem'] || $_SESSION['verwaltung']){ ?>
        <a href="?content=AnwaerterBearbeiten&anwaerter=<?php echo $ID; ?>&aus=Lehrgang&LID=<?php echo $lehrgang; ?>" style="color:#000000;"><i class="fa fa-user"></i></a>&emsp;
            <?php } ?>
        <a href="?content=AnwaerterSpiele&anwaerter=<?php echo $ID; ?>&aus=Lehrgang&LID=<?php echo $lehrgang; ?>" style="color:#000000;"><i class="fa fa-futbol-o"></i></center>
        </td>
        
        <td><?php if($kommentar==null){ echo "";}else{echo $kommentar;} ?></td>
    </tr>
	<?php
      
    }
?>
</table>
<small>Es wurden <?php echo $i ?> Anwärter*Innen gefunden.</small>
</center>


<div class='container'>
<div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
<div class="card card-signin my-5">
<div class="card-body">
    <table>
    <tr>
        <th colspan="3">
    Legende
        </th>
    </tr>
    <tr>
        <th width="350px">
            <span class="legende">Farbenverzeichnis</span>
        </th>
        <th width="200px">
            <span class="legende">Einsätze</span>
        </th>
        <th width="200px">
            <span class="legende">Aktion</span>
        </th>
    </tr>
    <tr>
        <td valign="top">
            <span class="legende" style="background-color: #7FFFD4">aktive(r) SR*in</span><br>
            <span class="legende" style="background-color: #F88379">kein Interesse als SR*in</span><br>
            <span class="legende" style="background-color: #FFA500">kein Interesse am Patensystem</span><br>
            <span class="legende" style="background-color: #FFFAA0">mind. 3 geplante o. abgeschlossene Einsätze </span><br>
        </td>
        <td valign="top">
            <span class="legende">
            g / s (o) [r]<br>
            g: geplant <br>
            s: statt gefunden<br>
            o: offene Berichte<br>
            r: Rückgaben
            </span>
        </td>
        <td valign="top">            
            <i class="fa fa-user"/><span class="legende">: Personendaten ändern </span>
                <br><br>
            <i class="fa fa-futbol-o"/><span class="legende">: Spielleitungen </span>
        </td>
    </tr>
</table>      
       
           
</div>
</div>
</div>
</div>
