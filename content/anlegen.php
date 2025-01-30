<center>
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
$view=$_GET['detail'];
if($view=="Lehrveranstaltung"){
    $ueberschift="Lehrveranstaltung";
    if ($_POST['anlegen']) {
        $art = $_POST['art'] ?? null;
        $thema = $_POST['thema'] ?? null;
        $datum = $_POST['datum'] ?? null;
        $startzeit = $_POST['startzeit'] ?? null;
        $standort = $_POST['standort'] ?? null;
        $referent = $_POST['referent'] ?? null;

        doInsertLehrveranstaltung($art,$thema, $datum, $startzeit, $standort,$referent,$link);
    } 
}
if($view=="Leistungspruefung"){
    $ueberschift="Leistungsprüfung";
    if ($_POST['anlegen']) {
        $art = $_POST['art'] ?? null;
        $test = $_POST['test'] ?? null;
        $datum = $_POST['datum'] ?? null;
        $startzeit = $_POST['startzeit'] ?? null;
        $standort = $_POST['standort'] ?? null;
        $pruefer = $_POST['pruefer'] ?? null;

        doInsertPruefung($art,$test, $datum, $startzeit, $standort,$pruefer,$link);
    } 
}

?>
</center>
<div class='container'>
    <form method='post' action=''>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning"> <?php echo $ueberschift; ?> anlegen</h2>

                                <form class="form-signin">
                                    <div class="form-label-group mt-4">
                                        <label for="art">Art:</label>
                                        <select id="art" name="art" class="form-control" required>
                                            <option value="" disabled selected>Bitte wählen</option>
                                            <?php if($view=="Lehrveranstaltung"){ ?>
                                            <option value="A-Abend">A-Abend</option>
                                            <option value="B-Treffen">B-Treffen</option>
                                            <option value="J-Treffen">J-Treffen</option>
                                            <option value="Paten">Paten</option>
                                            <option value="KL-Treffen">KL-Treffen</option>
                                            <?php } 
                                            if($view=="Leistungspruefung"){ ?>
                                            <option value="KLP">Kreisleistungsprüfung</option>
                                            <?php } ?>
                                        </select>                                    
                                    </div>
                                <?php if($view=="Lehrveranstaltung"){ ?>
                                    <div class="form-label-group mt-2">
                                        <label for="thema">Thema:</label>
                                        <input type="text" id="thema" name="thema" class="form-control" placeholder="Thema" required>
                                    </div>
                                <?php } ?>
                                <?php if($view=="Leistungspruefung"){ ?>
                                    <div class="form-label-group mt-2">
                                        <label for="test">Test:</label>
                                        <select id="test" name="test" class="form-control" required>
                                            <option value="" disabled selected>Bitte wählen</option>                                            
                                            <option value="Cooper-Test">Cooper-Test</option>                                            
                                            <option value="Helsen-Test">Helsen-Test</option>
                                        </select> 
                                    </div>
                                <?php } ?>
                                    <div class="form-label-group mt-2">
                                        <label for="datum">Datum:</label>
                                        <input type="date" id="datum" name="datum" class="form-control" required>
                                    </div>  

                                    <div class="form-label-group mt-2">
                                        <label for="startzeit">Startzeit:</label>
                                        <input type="time" id="startzeit" name="startzeit" class="form-control" required>
                                    </div>

                                    <div class="form-label-group mt-2">
                                        <label for="standort">Standort:</label>
                                        <input type="text" id="standort" name="standort" class="form-control" placeholder="Standort" required>
                                    </div>

                                <?php if($view=="Lehrveranstaltung"){ ?>
                                    <div class="form-label-group mt-2">
                                        <label for="referent">Referent:</label>
                                        <input type="text" id="referent" name="referent" class="form-control" placeholder="Referent" required>
                                    </div>                                    
                                <?php } ?>
                                <?php if($view=="Leistungspruefung"){ ?>
                                    <div class="form-label-group mt-2">
                                        <label for="pruefer">Prüfer:</label>
                                        <input type="text" id="pruefer" name="pruefer" class="form-control" placeholder="Prüfer" required>

                                    </div>
                                <?php } ?>

                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="anlegen" type="submit" value="anlegen">Anlegen</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






