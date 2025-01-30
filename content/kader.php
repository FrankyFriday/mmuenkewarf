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
if($_POST['suchen']){
    $kaderId=$_POST['kader'];
    $results= doSelectAllSchiedsrichterInKader($kaderId,$link);
    $kaderNameInfos = doSelectKaderById($kaderId, $link);   
    foreach($kaderNameInfos as $kaderNameInfo){
        $titel=htmlspecialchars($kaderNameInfo['Name']);
    }
}
    

$i=1;
?>

<div class="container">
<form method='post' >
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-5 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
<h2 class="container card-title text-center btn-lg btn-warning ">Schiedsrichter*Innen sortiert nach: </h2>

                                <form class="form-signin">
                                    <div class="form-label-group mt-4">
                                        <label for="kader">Kader: &nbsp;</label>
                                        <select name="kader" id="kader" required >
                                            <option value="" disabled selected>Bitte wählen</option>
                                        <?php 
                                           $kaderAll= doSelectAllFormKader($link);
                                              
                                            foreach($kaderAll as $kader) {
                                                $kaderEinzel=htmlspecialchars($kader['Name']);
                                                $id=htmlspecialchars($kader['KaderId']);
                                                if($_POST['kader']==$id){
                                                echo "<option selected value='$id'>$kaderEinzel</option>";
                                                }else{
                                                    
                                                echo "<option value='$id'>$kaderEinzel</option>";
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
</div>
<?php if($_POST['suchen']){ ?>
<center><h2><?php echo $titel; ?></h2></center>
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
        <th style='width: 15vw'><center>Bemerkung</center></th>
        <th style='width: 5vw'><center>Einsätze</center></th>
        <th style='width: 5vw'><center>Rückgaben</center></th>
        <th style='width: 5vw'><center>n. Antritte</center></th>
        <th style='width: 5vw'><center>Lehrabende</center></th>
        <th style='width: 7vw'><center>letzte KLP</center></th>
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
        $klp=doSelectLastKLP($schiedsrichterId, $link);
        $letzeKLP="";
        if($klp!='not Found'){
            foreach($klp as $result){
                $fehlerpunkte=htmlspecialchars($result['Testpunkte']);
                $cooperTestMeter=htmlspecialchars($result['CooperTestMeter']);
                $helsenTestRunde=htmlspecialchars($result['HelsenTestRunde']);
                $test=htmlspecialchars($result['Test']);
            }
            if($test=="Cooper-Test"){
                $letzeKLP="CT ".$cooperTestMeter."m (".$fehlerpunkte.")";
            }
            
            if($test=="Helsen-Test"){
                $letzeKLP="HT ".$helsenTestRunde." R (".$fehlerpunkte.")";
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
        <td><span class='text'><?php echo $bemerkung; ?></span></td>
   
        <td <?php if($gesamt<15){   echo 'bgcolor="yellow"'; }?>><center><?php echo $gesamt;  ?></center></td>
        <td <?php if($rueckgaben==0){   echo 'bgcolor="green"'; }else if($rueckgaben>=20){   echo 'bgcolor="red"'; }?>><center><?php echo $rueckgaben;  ?></center></td>
        <td <?php if($nichtAntritte>0){   echo 'bgcolor="red"'; }?>><center><?php echo $nichtAntritte;  ?></center></td>
            
        <td <?php if($lehrveranstaltungen>=2){   echo 'bgcolor="green"'; }?>><center><?php echo $lehrveranstaltungen;  ?></center></td>
        <td <?php if($klp!='not Found'){   echo 'bgcolor="green"'; }?>><center><?php echo $letzeKLP;  ?></center></td>
        
    </tr>
	<?php           
    }
?>
</table>
    <br><br>
<?php }
