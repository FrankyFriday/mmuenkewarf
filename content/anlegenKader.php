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
require_once './functions/sqlInsert.php';
require_once './functions/sqlSelect.php';
require_once './functions/sqlUpdate.php';

if($_GET['name']){    
    $values= doSelectSchiedsrichterByName($_GET['name'], $link);
}

if ($_POST['suchen']) {
    $name = $_POST['name'];
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenKader&kader='.$_GET['kader'].'&neu=1&name='.$name.'">';

} 

if($_POST['neu']){    
    echo '<meta http-equiv="refresh" content="0; url=?content=anlegenKader&kader='.$_GET['kader'].'&neu=1">';    
}
 
if ($_POST['weiter']) {
    $kader = $_POST['kader'];
    echo '<meta http-equiv="refresh" content="0; url=?content=anlegenKader&kader='.$kader.'">';    
} 

if($_POST['streichen']){
    doUpdateKaderFromSchiedsrichter($_POST['streichen'], 'delete', $link);
    echo '<meta http-equiv="refresh" content="0; url=?content=anlegenKader&kader='.$_GET['kader'].'">'; 
}
if($_POST['hinzufuegen']){
    doUpdateKaderFromSchiedsrichter($_POST['hinzufuegen'], $_GET['kader'], $link);
    echo '<meta http-equiv="refresh" content="0; url=?content=anlegenKader&kader='.$_GET['kader'].'">'; 
}

if($_GET['kader']){
    $kaderdaten = doSelectAllSchiedsrichterInKader($_GET['kader'], $link);
}
?>

<div class='container'>
    <form method='post' action=''>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">Kader bearbeiten</h2>
                                <form class="form-signin">
                                    
                                    <?php if(!$_GET['kader']){ ?>
                                    <div class="form-label-group mt-4">
                                        <label for="kader">Kader: &nbsp;</label>
                                        <select name="kader" id="kader" required >
                                            <option value="" disabled selected>Bitte wählen</option>
                                        <?php 
                                           $results= doSelectAllFormKader($link);
                                              
                                            foreach($results as $result) {                                                
                                                $kaderId=htmlspecialchars($result['KaderId']);
                                                $name=htmlspecialchars($result['Name']);
                                                echo "<option value='$kaderId'>$name</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="weiter" type="submit" value="weiter">weiter</button>
                                    <?php
                                    
                                    } else if(!$_GET['neu']){
                                        ?>
                                    <div class="form-label-group mt-4">
                                        <label for="kader">Kader: &nbsp;</label>
                                        <?php 
                                        $kader=doSelectKaderById($_GET['kader'],$link);
                                        foreach($kader as $result) {
                                            $kaderName=htmlspecialchars($result['Name']);                                                
                                        }
                                        echo $kaderName;
                                        ?>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="neu" type="submit" value="neu">Schiedsrichter*in hinzufügen/suchen</button>
                                    <a class="dropdown-item" href="?content=anlegenKader"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Auswahl</center></a>

                                        <table border="5px solid black" frame="box" style="place-self: center; width: 74vw">  
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
                                                <th style='width: 7vw'><center>letzte KLP</center></th>
                                                <th style='width: 5vw'><center>Aktion</center></th>
                                            </tr>
                                            <?php
                                            $i=1;
                                            foreach($kaderdaten as $result) {
                                               $schiedsrichterId=htmlspecialchars($result['SchiedsrichterId']);
                                                $nachname=htmlspecialchars($result['Name']);
                                                $vorname=htmlspecialchars($result['Vorname']);
                                                $geburtsdatum=htmlspecialchars($result['Geburtsdatum']);
                                                $srSeit=htmlspecialchars($result['SrSeit']);
                                                $qmax=htmlspecialchars($result['QMAX']);
                                                $geschlecht=htmlspecialchars($result['Geschlecht']); 
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
                                                    <td><span class='text'><?php echo $nachname; ?></span></td>
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
                                               <?php 
                                                        if($gesamt){
                                                   ?>
                                                    <td <?php if($gesamt<15){   echo 'bgcolor="yellow"'; }?>><center><?php echo $gesamt;  ?></center></td>
                                               <td <?php if($rueckgaben==0){   echo 'bgcolor="green"'; }else if($rueckgaben>=20){   echo 'bgcolor="red"'; }?>><center><?php echo $rueckgaben;  ?></center></td>
                                                    <td <?php if($nichtAntritte>0){   echo 'bgcolor="red"'; }?>><center><?php echo $nichtAntritte;  ?></center></td>
                                                        <?php }else{
                                                           ?>
                                               <th colspan="3"><center>keine Einsätze</center></th>
                                                            <?php
                                                            } 
                                                    ?> 
                                                            <td <?php if($lehrveranstaltungen>=2){   echo 'bgcolor="green"'; }?>><center><?php echo $lehrveranstaltungen;  ?></center></td>
                                                 <?php if($view!="keinSpiel"){ ?>   
                                               <td <?php if($klp!='not Found'){   echo 'bgcolor="green"'; }?>><center><?php echo $letzeKLP;  ?></center></td>
                                                   <td><center>
                                                        <button type="submit" name="streichen" value="<?php echo $schiedsrichterId;  ?>" style="background:none;border:none;color:red;cursor:pointer;">
                                                            streichen
                                                        </button>
                                                    </center></td> 
                                                   
                                                   <?php
                                                        } ?>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                        </table>
                                    <?php
                                    }else{
                                        ?>
                                    <div class="form-label-group mt-4">
                                        <label for="kader">Kader: &nbsp;</label>
                                        <?php 
                                        $kader=doSelectKaderById($_GET['kader'],$link);
                                        foreach($kader as $result) {
                                            $kaderName=htmlspecialchars($result['Name']);                                                
                                        }
                                        echo $kaderName;
                                        ?>
                                    </div>
                                    <div class="form-label-group mt-2">
                                        <label for="name">Schiedsrichter Suche:</label>
                                        <input type="text" name="name" class="form-control" placeholder="Vor- oder Nachname"  autofokus>
                                    </div>
                                    
                                    

                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="suchen" type="submit" value="suchen">suchen</button>
                                    <a class="dropdown-item" href="?content=anlegenKader&kader=<?php echo $_GET['kader']; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>

                                    
                                    
                                    <?php 
                                    if ($values) {
                                        ?>
                                    <table border="5px solid black" frame="box" style="place-self:center">  
                                        <tr bgcolor='#A4A4A4'> 
                                            <th style='width: 12vw'><center>Nachname</center></th>
                                            <th style='width: 12vw'><center>Vorname</center></th>
                                            <th style='width: 9vw'><center>Status</center></th>
                                        </tr>
                                        <?php
                                        foreach ($values as $row) {
                                            $vertreten = doSelectSchiedsrichterByKader($row['SchiedsrichterId'],$_GET['kader'], $link)
                                            ?>
                                        <tr bgcolor='<?php if($i==1){echo 'cfcfcf'; $i=0;}else{echo '#FFFFFF';$i=1;}?>' >
                                            <td><span class='text'><?php echo htmlspecialchars($row['Name']); ?></span></td>
                                            <td><span class='text'><?php echo htmlspecialchars($row['Vorname']); ?></span></td>
                                            <td><center><?php if($vertreten){
                                                ?>
                                                <button type="submit" name="streichen" value="<?php echo $row['SchiedsrichterId'];  ?>" style="background:none;border:none;color:red;cursor:pointer;">
                                                    streichen
                                                </button>
                                                <?php
                                            }else{
                                                ?>
                                                <button type="submit" name="hinzufuegen" value="<?php echo $row['SchiedsrichterId'];  ?>" style="background:none;border:none;color:green;cursor:pointer;">
                                                    hinzufügen
                                                </button>
                                                <?php
                                            } ?>
                                            </center></td>
                                        </tr>
                                            <?php
                                        }
                                        ?>
                                        </table>
                                        <?php
                                    } else {
                                        echo "Keine Ergebnisse gefunden.";
                                    }
                                    ?>
                                    
                                    <?php
                                    }
                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






