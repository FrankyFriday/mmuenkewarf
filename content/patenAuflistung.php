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

$results= doSelectPaten($link);
$resultsLehrgaenge= doSelectLehrgaenge($link);
?>
<div class='mt-4'></div>
<center><h2>Dashboard Pate/Patin</h2></center>
<center>

<?php
    $i=0;
$pateMitEinsatz=0;
$pateOhneEinsatz=0;
?>

<table border="5px solid black" frame="box">  
    <tr bgcolor='#A4A4A4'> 
        
        <th rowspan="2" style="width:1vw"><center>Pos</center></th>
        <th rowspan="2" style="width:8vw"><center>Nachname</center></th>
        <th rowspan="2" style="width:8vw"><center>Vorname</center></th>
        <th rowspan="2" style="width:3vw"><center>Alter</center></th>
        <th rowspan="2" style="width:8vw"><center>Wohnort</center></th>
<th colspan="<?php echo doSelectAnzahlLehrgaeng($link)+1; ?>" ><center>Einsätze</center></th>

        <th rowspan="2" style="width: 5vw"><center>Aktion</center></th>
        <th rowspan="2" style="width:20vw"><center>Bemerkung</center></th>
    </tr>
    <tr bgcolor='#A4A4A4'> 
        <?php
        foreach($resultsLehrgaenge as $resultLehrgang) {
            $titel=substr(htmlspecialchars($resultLehrgang['titel']),17);
            echo '<th style="width:7vw"><center>'.$titel.'</center></th>';
        }
        ?>
        <th style="width:5vw"><center>Gesamt</center></th>
    </tr>
    <?php
    foreach($results as $result){
        $person=htmlspecialchars($result['ID']);
        $vorname=htmlspecialchars($result['vor']);
        $nachname=htmlspecialchars($result['nach']);
        $datum=htmlspecialchars($result['soalt']);
        $ort=htmlspecialchars($result['ort']);
        $bemerkung=htmlspecialchars($result['Bemerkung']);
        $einsaetzeGes=doSelectPatenEinsatzAnzahl($person, 'n' ,$link);
        $farbeGreen='#7FFFD4';
        $farbeRed='#F88379';
        $farbeWhite='#FFFFFF';
        
?>
    <tr bgcolor='<?php if($einsaetzeGes==0){ echo $farbeRed;}else{echo $farbeGreen;}?>'>
        <td><center><?php $i++; echo $i; ?></center></td>
        <td><span class="text"><?php echo $nachname; ?></span></td>
        <td><span class="text"><?php echo $vorname; ?></span></td>
        <td bgcolor='<?php echo $farbeWhite; ?>'><center><?php
            echo $datum;  ?>
        </center></td>
        <td bgcolor='<?php echo $farbeWhite; ?>'><span class="text"><?php echo $ort; ?></span></td>
<?php
        foreach($resultsLehrgaenge as $resultLehrgang) {
            $LID=htmlspecialchars($resultLehrgang['ID']);
            $einsaetze=doSelectPatenEinsatzAnzahl($person, $LID ,$link);
            echo "<td bgcolor=".$farbeWhite."><center>".$einsaetze."</center></td>";
        }
?>
        <td bgcolor='<?php if($einsaetzeGes==0){ echo $farbeRed;}else{echo $farbeGreen;}?>'><center><?php echo $einsaetzeGes; ?></center></td>
        <td bgcolor='<?php echo $farbeWhite; ?>'><center>
            <?php if ($_SESSION['ansetzer']) { ?>
        <a href="?content=PateBearbeiten&pate=<?php echo $person; ?>" style="color:#000000;"><i class="fa fa-user"></i></a>&emsp;
            <?php } ?>
            <?php if ($_SESSION['ansetzer'] or $_SESSION['bericht']) { ?>
        <a href="?content=PateSpiele&pate=<?php echo $person; ?>" style="color:#000000;"><i class="fa fa-futbol-o"></i></center>
            <?php } ?>
            </td>
        <td bgcolor='<?php echo $farbeWhite; ?>'><span class="text"><?php echo $bemerkung; ?></span></td>
    </tr>
	<?php
        //für die Bilanz
        if($einsaetzeGes>=1){$pateMitEinsatz++;}else{$pateOhneEinsatz++;}
        
    }
    
?>
</table>
<?php    
echo 'Paten/Patin <b>mit</b> Einsätze: '.$pateMitEinsatz.' ('.round($pateMitEinsatz*100/$i).'%)';

echo '<br>Paten/Patin <b>ohne</b> Einsätze: '.$pateOhneEinsatz.' ('.round($pateOhneEinsatz*100/$i).'%)';

?>
</center>

