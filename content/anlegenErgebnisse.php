<style>
    select{
        width: 23vw;
    }
    .text{
        margin-left: .3vw;
    }
    
</style>
<center>
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlDelete.php';
if($_GET['name']){    
    $values= doSelectSchiedsrichterByName($_GET['name'], $link);
}

if ($_POST['suchen']) {
    $name = $_POST['name'];
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenErgebnisse&detail=Leistungspruefung&id='.$_GET['id'].'&name='.$name.'">';

} 

if ($_POST['weiter']) {    
    $pruefung=$_POST['pruefung'];
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenErgebnisse&detail=Leistungspruefung&id='.$pruefung.'">';
}

if ($_POST['uebermitteln']) {    
    $fehlerpunkte=$_POST['fehlerpunkte'];
    $runden=$_POST['runden'] ?? null;
    $strecke=$_POST['strecke']?? null;
    $Sprint200m=$_POST['200mSprint']?? null;
    $Sprint50m=$_POST['50mSprint']?? null;
    $sprints=$_POST['sprints']?? null;
    doInsertPruefungsErgebnisse($_GET['id'], $_GET['edit'], $fehlerpunkte, $runden, $strecke, $Sprint200m, $Sprint50m, $sprints, $link); 
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenErgebnisse&detail=Leistungspruefung&id='.$_GET['id'].'&name='.$_GET['name'].'">';
}

if ($_POST['abwesend']) {    
echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenErgebnisse&detail=Leistungspruefung&id='.$_GET['id'].'&name='.$_GET['name'].'&edit='.$_POST['abwesend'].'">';

}




?>
</center>
<div class='container'>
    <form method='post' >
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 mx-auto breite">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">Ergebnisse anlegen</h2>

                                <form class="form-signin">
                                    <?php if(!$_GET['id']){ ?>
                                    <div class="form-label-group mt-4">
                                        <label for="pruefung">Prüfung: &nbsp;</label>
                                        <select name="pruefung" id="pruefung" required >
                                            <option value="" disabled selected>Bitte wählen</option>
                                        <?php 
                                           $results= doSelectPruefungInformationAll($link);
                                              
                                            foreach($results as $result) {
                                                $nr=htmlspecialchars($result['PruefungsId']);
                                                $art=htmlspecialchars($result['Art']);
                                                $standort=htmlspecialchars($result['Standort']);
                                                $datum=htmlspecialchars($result['Datum']);
                                                $datumNew = new DateTime($datum);  
                                                $zeitpunkt = $datumNew->format("d.m.y-H:i");
                                                $test=htmlspecialchars($result['Test']);
                                                echo "<option value='$nr'>$zeitpunkt - $art in $standort ($test)</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="weiter" type="submit" value="weiter">weiter</button>
                                    <?php
                                    
                                    } else if(!$_GET['edit']) {
                                   
                                        echo '<label for="pruefung">Prüfung: &nbsp;</label>';
                                        $results= doSelectPruefungById($_GET['id'],$link);
                                        foreach($results as $result) {
                                            $art=htmlspecialchars($result['Art']);
                                            $standort=htmlspecialchars($result['Standort']);
                                            $datum=htmlspecialchars($result['Datum']);
                                            $datumNew = new DateTime($datum);  
                                            $zeitpunkt = $datumNew->format("d.m.y-H:i");
                                            $test=htmlspecialchars($result['Test']);
                                        }
                                        echo "$zeitpunkt - $art in $standort ($test)";
                                    
                                    ?>
                                    <hr>
                                    <div class="form-label-group mt-2">
                                        <label for="name">Schiedsrichter Suche:</label>
                                        <input type="text" name="name" class="form-control" placeholder="Vor- oder Nachname"  autofokus>
                                    </div>
                                    
                                    

                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="suchen" type="submit" value="suchen">suchen</button>
                                    
                                    
                                    
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
                                            $anwesend = doSelectSchiedsrichterByPruefung($row['SchiedsrichterId'],$_GET['id'], $link)
                                            ?>
                                        <tr bgcolor='<?php if($i==1){echo 'cfcfcf'; $i=0;}else{echo '#FFFFFF';$i=1;}?>' >
                                            <td><span class='text'><?php echo htmlspecialchars($row['Name']); ?></span></td>
                                            <td><span class='text'><?php echo htmlspecialchars($row['Vorname']); ?></span></td>
                                            <td><center><?php if($anwesend){
                                                ?>
                                                <span style="color:green;">
                                                    Ergebnis vorhanden
                                                </span>
                                                <?php
                                            }else{
                                                ?>
                                                <button type="submit" name="abwesend" value="<?php echo $row['SchiedsrichterId'];  ?>" style="background:none;border:none;color:red;cursor:pointer;">
                                                    abwesend
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
                                    
                                        }else{
                                            
                                            echo '<label for="pruefung">Prüfung: &nbsp;</label>';
                                        $results= doSelectPruefungById($_GET['id'],$link);
                                        foreach($results as $result) {
                                            $art=htmlspecialchars($result['Art']);
                                            $standort=htmlspecialchars($result['Standort']);
                                            $datum=htmlspecialchars($result['Datum']);
                                            $datumNew = new DateTime($datum);  
                                            $zeitpunkt = $datumNew->format("d.m.y-H:i");
                                            $test=htmlspecialchars($result['Test']);
                                        }
                                        echo "$zeitpunkt - $art in $standort ($test)";
                                    
                                        
                                        $schiedsrichter = doSelectSchiedsrichterById($_GET['edit'], $link);
                                        foreach($schiedsrichter as $result) {
                                            $schiedsrichterFullName=htmlspecialchars($result['Name']).", ".htmlspecialchars($result['Vorname']);
                                        }
                                    ?>
                                    <hr>
                                    <div class="form-label-group mt-2">
                                        <label for="name">Schiedsrichter Suche:</label>
                                        <input type="text" name="name" class="form-control" placeholder="Vor- oder Nachname" value="<?php echo $schiedsrichterFullName; ?>"  disabled>
                                    </div>
                                    
                                    <hr>
                                    <div class="form-label-group mt-2">
                                        <label for="fehlerpunkte">Fehlerpunkte:</label>
                                        <input type="number" step="1" min="0" max="30" name="fehlerpunkte" class="form-control" placeholder="Fehlerpunkte" required autofokus>
                                    </div>
                                    <?php if($test=="Cooper-Test"){ ?>
                                    <div class="form-label-group mt-2">
                                        <label for="strecke">gelaufende Strecke:</label>
                                        <input type="number" step="50" min="0" max="5000" name="strecke" class="form-control" placeholder="gelaufende Strecke" required autofokus>
                                    </div>
                                    <div class="form-label-group mt-2">
                                        <label for="strecke">200m Sprint in sec:</label>
                                        <input type="number" step="0.1" min="0" name="200mSprint" class="form-control" placeholder="200m Sprint in sec" required autofokus>
                                    </div>
                                    <div class="form-label-group mt-2">
                                        <label for="strecke">50m Sprint in sec:</label>
                                        <input type="number" step="0.1" min="0" name="50mSprint" class="form-control" placeholder="50m Sprint in sec" required autofokus>
                                    </div>
                                    <?php } if($test=="Helsen-Test"){ ?>
                                    <div class="form-label-group mt-2">
                                        <label for="runden">gelaufende Runden (Lang-Strecke):</label>
                                        <input type="number" step="0.5" min="0" max="15" name="runden" class="form-control" placeholder="gelaufende Runden" required autofokus>
                                    </div>
                                    <div class="form-label-group mt-2">
                                        <label for="runden">bestandene Sprints (Kurz-Strecke):</label>
                                        <input type="number" step="1" min="0" max="6" name="sprints" class="form-control" placeholder="bestandene Sprints" required autofokus>
                                    </div>
                                    <?php } ?>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="uebermitteln" type="submit" value="uebermitteln">übermitteln</button>

                                    <?php
                                        } ?>
                                    
                                    
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






