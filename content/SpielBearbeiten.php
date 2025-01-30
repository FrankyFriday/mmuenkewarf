<?php
require_once './functions/sqlUpdate.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlSelect.php';
$SID = $_GET['spiel'];
$AID = $_GET['anwaerter'];
$aus =$_GET['aus'];
$vor =$_GET['vor'];
$LID =$_GET['LID'];
$spieldaten=doSelectSpielDaten($SID,$link);
if ($_POST['start']) {
    $PID=$_POST['pate'];
    doUpdateSpielPate($SID,$PID,$link);
    if(isset($_GET['vor'])){
        ?>
    <meta http-equiv="refresh" content="0; url=?content=<?php echo $vor; ?>&anwaerter=<?php echo $AID; ?>&aus=<?php echo $aus; ?>&LID=<?php echo $LID; ?>">
    <?php
        }else{
            ?>
    <meta http-equiv="refresh" content="0; url=?content=<?php echo $aus; ?>">
    <?php
        }
}
?>
<div class='container'>
    <form method='post' >
    <div class="row">
<!--EINGABE-->
        <div class="col-lg-7 mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    <h2 class="container card-title text-center btn-lg btn-warning ">
                    <table>
            <tr>
                <td width="30%">
                    <?php 
                    $spieldatum = new DateTime($spieldaten['datum']);
                    echo $spieldatum->format('d.m.Y'); ?>
                </td>
                <td width="5%"></td>
                <td width="65%">
                    <?php echo "Anwärter*in: ".$spieldaten['Avor']." ".$spieldaten['Anach']; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo $spieldaten['staffel']; ?>
                </td>
                <td>
                    
                </td>
                <td>
                    <?php echo "Pate/Patin: ".$spieldaten['Pvor']." ".$spieldaten['Pnach']; ?>
                </td>
            </tr>
                    </table></h2>
                    <div class="mt-4">
                    <label for="pate">neue(r) Pate/Patin:&emsp;&emsp;&emsp;</label> 
                    <select name="pate" id="pate" required>
                        <option value=''>Bitte wählen</option>
                    <?php 
                    $results=doSelectPatenSelect($link);
                        foreach($results as $result) {
                            $nr=htmlspecialchars($result['nr']);
                            $vorname=htmlspecialchars($result['vor']);
                            $nachname=htmlspecialchars($result['nach']);
                            $ort=htmlspecialchars($result['Wohnort']);
                            echo "<option value='$nr'>$nachname, $vorname ($ort)</option>";
                        }
                    ?>
                    </select>
                    </div>
                    <div class="mt-4">
                    <button class="btn btn-lg btn-primary btn-block" name="start" type="submit" value="start">änderen</button>
                    </div>
                    <?php
                    if ($_POST['start']) {
                        if(isset($_GET['vor'])){
                        ?>
                    <a class="dropdown-item" href="?content=<?php echo $vor; ?>&anwaerter=<?php echo $AID ?>&aus=<?php echo $aus ?>&LID=<?php echo $LID; ?>"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>
                    <?php
                        }else{
                           ?>
                    <a class="dropdown-item" href="?content=<?php echo $aus; ?>"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>
                    <?php
                        }
                    }else{
                        if(isset($_GET['vor'])){
                        ?>
                    <div class="mt-2">
                    <a class="dropdown-item" href="?content=<?php echo $vor; ?>&anwaerter=<?php echo $AID; ?>&aus=<?php echo $aus; ?>&LID=<?php echo $LID; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                    </div>
                    <?php
                        }else{
                            ?> 
                        <a class="dropdown-item" href="?content=<?php echo $aus; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>        
                            <?php
                        }
                    }
                        ?>
                </div>
            </div>
        </div>
    </div>
    </form>
</div>

