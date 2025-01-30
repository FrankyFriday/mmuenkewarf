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
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenTeilnahme&detail=lehrveranstaltung&id='.$_GET['id'].'&name='.$name.'">';

} 

if ($_POST['weiter']) {    
    $lehrveranstaltung=$_POST['lehrveranstaltung'];
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenTeilnahme&detail=lehrveranstaltung&id='.$lehrveranstaltung.'">';
}

if ($_POST['anwesend']) {    
    doDeleteTeilnahmeLehrveranstaltung($_POST['anwesend'],$_GET['id'],$link);
}

if ($_POST['abwesend']) {    
    doInsertTeilnahmeLehrveranstaltung($_POST['abwesend'],$_GET['id'],$link);
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
                                <h2 class="container card-title text-center btn-lg btn-warning ">Teilnahme anlegen</h2>

                                <form class="form-signin">
                                    <?php if(!$_GET['id']){ ?>
                                    <div class="form-label-group mt-4">
                                        <label for="lehrveranstaltung">Lehrveranstaltung: &nbsp;</label>
                                        <select name="lehrveranstaltung" id="lehrveranstaltung" required >
                                            <option value="" disabled selected>Bitte wählen</option>
                                        <?php 
                                           $results= doSelectLehrveranstaltungInformationAll($link);
                                              
                                            foreach($results as $result) {
                                                $nr=htmlspecialchars($result['LehrabendId']);
                                                $art=htmlspecialchars($result['Art']);
                                                $standort=htmlspecialchars($result['Standort']);
                                                $datum=htmlspecialchars($result['Datum']);
                                                $datumNew = new DateTime($datum);  
                                                $zeitpunkt = $datumNew->format("d.m.y-H:i");
                                                $thema=htmlspecialchars($result['Thema']);
                                                echo "<option value='$nr'>$zeitpunkt - $art in $standort ($thema)</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="weiter" type="submit" value="weiter">weiter</button>
                                    <?php
                                    
                                    } else {
                                   
                                        echo '<label for="lehrveranstaltung">Lehrveranstaltung: &nbsp;</label>';
                                        $results= doSelectLehrveranstaltungById($_GET['id'],$link);
                                        foreach($results as $result) {
                                            $art=htmlspecialchars($result['Art']);
                                            $standort=htmlspecialchars($result['Standort']);
                                            $datum=htmlspecialchars($result['Datum']);
                                            $datumNew = new DateTime($datum);  
                                            $zeitpunkt = $datumNew->format("d.m.y-H:i");
                                            $thema=htmlspecialchars($result['Thema']);
                                        }
                                        echo "$zeitpunkt - $art in $standort ($thema)";
                                    
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
                                            $anwesend = doSelectSchiedsrichterByLehrveranstaltung($row['SchiedsrichterId'],$_GET['id'], $link)
                                            ?>
                                        <tr bgcolor='<?php if($i==1){echo 'cfcfcf'; $i=0;}else{echo '#FFFFFF';$i=1;}?>' >
                                            <td><span class='text'><?php echo htmlspecialchars($row['Name']); ?></span></td>
                                            <td><span class='text'><?php echo htmlspecialchars($row['Vorname']); ?></span></td>
                                            <td><center><?php if($anwesend){
                                                ?>
                                                <button type="submit" name="anwesend" value="<?php echo $row['SchiedsrichterId'];  ?>" style="background:none;border:none;color:green;cursor:pointer;">
                                                    anwesend
                                                </button>
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






