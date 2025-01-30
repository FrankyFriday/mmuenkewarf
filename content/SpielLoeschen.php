<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';
require_once './functions/sqlDelete.php';
$SID = $_GET['spiel'];
$AID = $_GET['anwaerter'];
$aus =$_GET['aus'];
$spieldaten=doSelectSpielDaten($SID,$link);
if ($_POST['start']) {
    if($_POST['grund']==1){
        $wert=doSelectAnwaerterRueckgabe($AID,$link)+1;
        doUpdateAnwaerterRueckgabe($AID,$wert,$link);
    }
    doDeleteSpiel($SID,$link);
    if(isset($_GET['vor'])){
    ?>
<meta http-equiv="refresh" content="0; URL=?content=<?php echo $_GET['vor']; ?>&aus=<?php echo $_GET['aus']; ?>&anwaerter=<?php echo $_GET['anwaerter']; ?>&spiel=<?php echo $_GET['SID']; ?>&LID=<?php echo $_GET['LID']; ?>">
<?php
    }else{
       ?>
<meta http-equiv="refresh" content="0; URL=?content=<?php echo $_GET['aus']; ?>">
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
                        
                        wirklich Spiel löschen?<br>
                    <label for="grund">Grund:&emsp;&emsp;&emsp;</label> 
                    <select name="grund" id="grund" required>
                        <option value='0'>abgesetzt</option>
                        <option value="1">zurückgegeben</option>
                    </select>
                    </div>
                    <div class="mt-4">
                    <button class="btn btn-lg btn-primary btn-block" name="start" type="submit" value="start">änderen</button>
                    </div>
                    <?php
                    if ($_POST['start']) {
                        if(isset($_GET['vor'])){
                        ?>
                    <a class="dropdown-item" href="?content=<?php echo $_GET['vor'];?>&anwaerter=<?php echo $AID ?>&aus=<?php echo $aus ?>&LID=<?php echo $_GET['LID'];?>"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>
                    <?php
                        }else{
                            ?>
                    <a class="dropdown-item" href="?content=<?php echo $_GET['aus'];?>"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>
                    <?php
                        }
                    }else{
                        if(isset($_GET['vor'])){
                        ?>
                    <div class="mt-2">
                    <a class="dropdown-item" href="?content=<?php echo $_GET['vor'];?>&anwaerter=<?php echo $AID; ?>&aus=<?php echo $aus; ?>&LID=<?php echo $_GET['LID'];?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                    </div>
                    <?php
                        }else{
                            ?>
                    <a class="dropdown-item" href="?content=<?php echo $_GET['aus'];?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
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

