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
</style>

<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';
$pruefung=$_GET['id'];
    $results= doSelectAllSchiedsrichterInPruefung($pruefung,$link);
    $pruefungNameInfos = doSelectPruefungById($pruefung, $link);   
    foreach($pruefungNameInfos as $pruefungNameInfo){
        $test=htmlspecialchars($pruefungNameInfo['Test']);
        $art=htmlspecialchars($pruefungNameInfo['Art']);
        $datum=htmlspecialchars($pruefungNameInfo['Datum']);
        $datumNew = new DateTime($datum);  
        $zeitpunkt = $datumNew->format("d.m.y-H:i");
        $standort=htmlspecialchars($pruefungNameInfo['Standort']);
        $pruefer=htmlspecialchars($pruefungNameInfo['Pruefer']);
    }

$i=1;
?>

<div class='mt-4'></div>
<center><h2><?php echo $zeitpunkt." - ".$art." in ".$standort." (".$test.") Prüfer: ".$pruefer; ?></h2></center>
<center>
   <table border="5px solid black" frame="box">  
    <tr bgcolor='#A4A4A4'> 
        <th style='width: 3vw'><center>Pos</center></th>
        <th style='width: 8vw'><center>Name</center></th>
        <th style='width: 8vw'><center>Vorname</center></th>
        <th style='width: 6.5vw'><center>Geburtsdatum</center></th>
        <th style='width: 6.5vw'><center>SR seit</center></th>
        <th style='width: 4vw'><center>QMAX</center></th>
        <th style='width: 6vw'><center>Geschlecht</center></th>
        <th style='width: 5vw'><center>Einsätze</center></th>
        <th style='width: 5vw'><center>Rückgaben</center></th>
        <th style='width: 5vw'><center>n. Antritte</center></th>
        <th style='width: 5vw'><center>Lehrabende</center></th>
        <th style='width: 20vw'><center>aktuelle KLP</center></th>
    </tr>
    <?php
    foreach($results as $result){
        $schiedsrichterId=htmlspecialchars($result['SchiedsrichterId']);
        $name=htmlspecialchars($result['Name']);
        $vorname=htmlspecialchars($result['Vorname']);
        $geburtsdatum=htmlspecialchars($result['Geburtsdatum']);
        $srSeit=htmlspecialchars($result['SrSeit']);
        $qmax=htmlspecialchars($result['QMAX']);
        $geschlecht=htmlspecialchars($result['Geschlecht']);
        $bemerkung=htmlspecialchars($result['Bemerkung']);
        $gesamt=htmlspecialchars($result['Gesamt']);
        $rueckgaben=htmlspecialchars($result['Rueckgabe']);
        $nichtAntritte=htmlspecialchars($result['NichtAntritt']);
        
        $heute = new DateTime();
        $geburtsdatumObj = new DateTime($geburtsdatum);      
        $alter = $heute->diff($geburtsdatumObj)->y;
        
        $srSeitObj = new DateTime($srSeit);      
        $aktiv = $heute->diff($srSeitObj)->y;
        
        $lehrveranstaltungen=doSelectAnzahlLehrgangTeilnahme($schiedsrichterId, $link);
        $klp=doSelectAktuelleKLP($schiedsrichterId,$pruefung, $link);
        $aktuelleKLP="";
        if($klp!='not Found'){
            foreach($klp as $result){
                $fehlerpunkte=htmlspecialchars($result['Testpunkte']);
                $cooperTestMeter=htmlspecialchars($result['CooperTestMeter']);
                $helsenTestRunde=htmlspecialchars($result['HelsenTestRunde']);
                $helsenKurz=htmlspecialchars($result['HelsenTestKurzstrecke']);
                $cooper200m=htmlspecialchars($result['CooperTest200mSprint']);
                $cooper50m=htmlspecialchars($result['CooperTest50mSprint']);
                $test=htmlspecialchars($result['Test']);
            }
            if($test=="Cooper-Test"){
                $aktuelleKLP="Strecke: ".$cooperTestMeter."m / 200m: ".$cooper200m."s / 50m: ".$cooper50m."s (F: ".$fehlerpunkte.")";
            }
            
            if($test=="Helsen-Test"){
                $aktuelleKLP="Lang-St.: ".$helsenTestRunde." Runden / Kurz-St.: ".$helsenKurz." Sprints  (F: ".$fehlerpunkte.")";
            }
        }
    ?>
    <tr bgcolor='<?php if($i%2==0){echo 'cfcfcf'; }else{echo '#FFFFFF';}?>' >
        <td><center><?php echo $i; $i++?></center></td>
        <td><span class='text'><?php echo $name; ?></span></td>
        <td><span class='text'><?php echo $vorname; ?></span></td>
        <td><span class='text'><?php
            $datum = new DateTime($geburtsdatum);
            echo $datum->format('d.m.Y')." (".$alter.")";  ?>
        </span></td>
        <td><span class='text'><?php
            $datum = new DateTime($srSeit);
            echo $datum->format('d.m.Y')." (".$aktiv.")";  ?>
        </span></td>
        <td><center><?php echo $qmax; ?></center></td>
        <td><center><?php echo $geschlecht; ?></center></td>
   
        <td <?php if($gesamt<15){   echo 'bgcolor="yellow"'; }?>><center><?php echo $gesamt;  ?></center></td>
        <td <?php if($rueckgaben==0){   echo 'bgcolor="green"'; }else if($rueckgaben>=20){   echo 'bgcolor="red"'; }?>><center><?php echo $rueckgaben;  ?></center></td>
        <td <?php if($nichtAntritte>0){   echo 'bgcolor="red"'; }?>><center><?php echo $nichtAntritte;  ?></center></td>
            
        <td <?php if($lehrveranstaltungen>=2){   echo 'bgcolor="green"'; }?>><center><?php echo $lehrveranstaltungen;  ?></center></td>
        <td <?php if($fehlerpunkte>=5){   echo 'bgcolor="red"'; }?>><center><?php echo $aktuelleKLP;  ?></center></td>
        
    </tr>
	<?php           
    }
?>
</table>
    <br><br>

