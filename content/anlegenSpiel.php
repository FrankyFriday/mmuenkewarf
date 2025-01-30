<style>
    select{
        width:20vw;
    }
    </style>
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';

$anwaerterdaten=doSelectAnwaerterDaten($_GET['anwaerter'],$link);

if ($_POST['anlegen']) {
    $anwaerter = $_GET['anwaerter'];    
    $paten = $_POST['paten'];
    $staffel = $_POST['staffel'];
    $datum = $_POST['datum'];
    doInsertSpiel($anwaerter,$paten, $staffel, $datum, $link);
    if(isset($_GET['vor'])){
        ?>
    <meta http-equiv="refresh" content="0; url=?content=<?php echo $_GET['vor']; ?>&anwaerter=<?php echo $_GET['anwaerter']; ?>&aus=<?php echo $_GET['aus']; ?>&LID=<?php echo $_GET['LID']; ?>">
    <?php
        }else{
            ?>
    <meta http-equiv="refresh" content="0; url=?content=<?php echo $_GET['aus']; ?>">
    <?php
        }
} 
?>

<div class='container'>
    <form method='post' action=''>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class=" mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">S P I E L &emsp; anlegen</h2>
                                <form class="form-signin">
                                    
                                    <div class="form-label-group mt-4">
                                        <label for="anwaerter">Anwärter*in: &nbsp;&nbsp;</label>
                                        <?php 
                                         echo $anwaerterdaten['vor']." ".$anwaerterdaten['nach'];
                                        ?>
                                    </div>
                                    
                                    <div class="form-label-group mt-2">
                                        <label for="datum">Datum: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                                        <input type="date" name="datum" placeholder="Datum" required>
                                    </div>

                                    <div class="form-label-group mt-2">
                                        <label for="staffel">Staffel: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </label>
                                        <select name="staffel" id="staffel" required>
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            doSelectStaffel(0,$link);
                                        ?>
                                        </select>
                                    </div>  
                                    
                                     <div class="form-label-group mt-2">
                                        <label for="paten">Pate/Patin: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select name="paten" id="paten" required>
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

                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="anlegen" type="submit" value="anlegen">anlegen</button>
                                    <div class="mt-2">
                                       <?php
                                       if(isset($_GET['vor'])){
                                       ?>
                                    <a class="dropdown-item" href="?content=<?php echo $_GET['vor']; ?>&anwaerter=<?php echo $_GET['anwaerter']; ?>&aus=<?php echo $_GET['aus']; ?>&LID=<?php echo $_GET['LID']; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                                       <?php
                                       }else{
                                           ?>
                                    <a class="dropdown-item" href="?content=<?php echo $_GET['aus']; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                                       
                                    <?php
                                       }
                                       ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






