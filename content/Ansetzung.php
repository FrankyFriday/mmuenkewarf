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
    </style>
<?php
require_once './functions/sqlSelect.php';
$values = doSelectForAnsetzungsboard($link);
?>
<div class='mt-2'></div>
<center><h2>Ansetzung Anwärter*in</h2></center>
<center>
<?php
    foreach($values as $result){
        $ID=htmlspecialchars($result['nr']);
        $vorname=htmlspecialchars($result['vor']);
        $nachname=htmlspecialchars($result['nach']);
        $datum=htmlspecialchars($result['soalt']);
        $team=htmlspecialchars($result['team']);
        $ort=htmlspecialchars($result['ort']);
        $ltitel=htmlspecialchars($result['ltitel']);
        $ldatum=htmlspecialchars($result['ldatum']);
	$kommentar=htmlspecialchars($result['kommentar']);
        $rueckgaben=htmlspecialchars($result['rueckgaben']);
        
        $restzeit = new DateTime($ldatum);
        $pruefungDat=new DateTime($ldatum);
        
        $heute = new DateTime(date('Y-m-d'));
        $restzeit -> add(new DateInterval("P6M"));
        $differenzRestzeit = $heute->diff($restzeit);
        $einsaetzeGeplant= doSelectAnzahlEinsaetzeAnwaerter($ID,0,$link);
        $einsaetzeBerichtOffen=doSelectAnzahlEinsaetzeAnwaerter($ID,1,$link);
        $einsaetzeStattGefunden=$einsaetzeBerichtOffen+doSelectAnzahlEinsaetzeAnwaerter($ID,2,$link);
        $einsaetze=$einsaetzeGeplant+$einsaetzeStattGefunden;
        $spiele= doSelectAnwaerterSpiele($ID,$link);
        $farbeGreen='#7FFFD4';
	$farbeGreenDunkel='#006400';
        $farbeRed='#F88379';
        $farbeYellow='#FFFAA0';
        $farbeWhite='#FFFFFF';
        if($einsaetze>=3 AND $einsaetzeStattGefunden>=3)
        { $farbe=$farbeGreenDunkel;}
        elseif($einsaetze>=3 AND !($einsaetzeStattGefunden>=3))
        { $farbe=$farbeGreen;}
	elseif($einsaetze==2)
        { $farbe=$farbeYellow;}
        elseif($einsaetze==0)
        { $farbe=$farbeRed;}
        else
        {$farbe=$farbeWhite;}
        
        if(!($alt_ltitel==$ltitel)){
            $alt_ltitel=$ltitel;
            if($ende){
                echo '</table><br>';
                $ende=true;
            }else{
            $ende=true;
            }
            echo '<h6><p align="center">'.$ltitel.' &emsp;Prüfungsdatum: '.$pruefungDat->format('d.m.y').' &emsp;>>&emsp;';
if ($restzeit ->getTimestamp() < time()) {
   echo 'überfällig seit: ';
} else { echo 'Restzeit: ' ;}
echo $differenzRestzeit->format('%m').' Monate '.$differenzRestzeit->format('%d').' Tage</p></h6>';

?>
<table border="2px solid black" frame="box">  
    <tr bgcolor='#A4A4A4'> 
        <th style="width: 8vw"><center>Nachname</center></th>
        <th style="width: 8vw"><center>Vorname</center></th>
        <th style="width: 3vw"><center>Alter</center></th>
        <th style="width: 11vw"><center>Heimatverein</center></th>
        <th style="width: 8vw"><center>Wohnort</center></th>
        <th style="width: 4.7vw"><center>Einsätze</center></th>
        <th style="width: 16vw"><center>stattgefundene spiele</center></th>
        <th style="width: 5vw"><center>Aktion</center></th>
        <th style="width: 20vw"><center>Bemerkung</center></th>
    </tr>
    <?php
        }
    ?>
    <tr bgcolor='<?php echo $farbe; ?>'>
        <td><span class="text"><?php echo $nachname; ?></span></td>
        <td><span class="text"><?php echo $vorname; ?></span></td>
        <td><center><?php
            echo $datum;  ?>
        </center></td>
        <td><span class="text"><?php echo $team; ?></span></td>
        <td><span class="text"><?php echo $ort; ?></span></td>
        <td><span class="text"><?php echo $einsaetzeGeplant." / ".$einsaetzeStattGefunden."(".$einsaetzeBerichtOffen.") [".$rueckgaben."]"; ?></span></td>
        <td><span class="text"><?php 
        foreach ($spiele as $spiel){            
        $spielinfo=htmlspecialchars($spiel['Kuerzel']);
            echo $spielinfo."&nbsp;&nbsp;"; }
        
        ?></span></td>        
        <td><center>
        <a href="?content=AnwaerterSpiele&aus=Ansetzung&anwaerter=<?php echo $ID; ?>" style="color:#000000;"><i class="fa fa-futbol-o"></i></a> &emsp;
        <a href="?content=anlegenSpiel&aus=Ansetzung&anwaerter=<?php echo $ID; ?>" style="color:#000000;"><i class="fa fa-plus-square"></i></center>
        </td>
        <td ><span class="text">
	<?php echo $kommentar; ?>
            </span></td>
    </tr>
<?php
           
	
   
    }
    ?>
    </table>

</center>
<div class='container'>
<div class="col-sm-9 col-md-7 col-lg-8 mx-auto">
<div class="card card-signin my-5">
<div class="card-body">
    <small>
    <table>
    <tr>
        <th colspan="3">
    Legende<br>
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
            <span class="legende" style="background-color: #7FFFD4">3 angesetzte Spiele<br></span>
            <span class="legende" style="background-color: #FFFAA0">2 angesetzte Spiele<br></span>
            <span class="legende" style="background-color: #F88379">0 angesetzte Spiele<br></span>
        </td>
        <td valign="top">
            <span class="legende">g / s (o)<br>
            g: geplant <br>
            s: statt gefunden<br>
            o: offene Berichte</span>
        </td>
        <td valign="top">
            <i class="fa fa-plus-square"/>: <span class="legende">Spiel hinzufügen</span> <br><br>
                <i class="fa fa-futbol-o"/>: <span class="legende">Spielleitungen</span>
        </td>
    </tr>
</table>      
        </small>
           
</div>
</div>
</div>
</div>