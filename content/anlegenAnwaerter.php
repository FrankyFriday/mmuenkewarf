<center>
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';

if ($_POST['anlegen']) {
    $vorname = filter_input(INPUT_POST, 'vorname', FILTER_SANITIZE_STRING);
    $nachname = filter_input(INPUT_POST, 'nachname', FILTER_SANITIZE_STRING);
    $geburtsdatum = $_POST['geburtsdatum'];
    $wohnort = filter_input(INPUT_POST, 'wohnort', FILTER_SANITIZE_STRING);
    $verein = $_POST['verein'];
    $lehrgang=$_GET['lehrgang'];
    
    doInsertAnwaerter($vorname,$nachname, $geburtsdatum, $wohnort, $verein,$lehrgang, $link);
} 

if ($_POST['weiter']) {    
    $lehrgang=$_POST['lehrgang'];
    echo '<meta http-equiv="refresh" content="0; URL=?content=anlegenAnwaerter&lehrgang='.$lehrgang.'">';
}



?>
</center>
<div class='container'>
    <form method='post' >
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">A N W Ä R T E R * I N &emsp; anlegen</h2>

                                <form class="form-signin">
                                    <?php if(!$_GET['lehrgang']){ ?>
                                    <div class="form-label-group mt-4">
                                        <label for="lehrgang">Lehrgang: &nbsp;&nbsp;&nbsp;</label>
                                        <select name="lehrgang" id="lehrgang" required>
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                           $results= doSelectLehrgangInformationAll($link);
                                              
                                            foreach($results as $result) {
                                                $nr=htmlspecialchars($result['ID']);
                                                $titel=htmlspecialchars($result['titel']);
                                                echo "<option value='$nr'>$titel</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="weiter" type="submit" value="weiter">weiter</button>
                                    <?php
                                    
                                    } else {
                                   
                                    echo '<label for="lehrgang">Lehrgang: &nbsp;</label>';
                                    echo doSelectLehrgangTitel($_GET['lehrgang'],$link);
                                    ?>
                                    <hr>
                                    <div class="form-label-group mt-2">
                                        <label for="Vorname">Vorname:</label>
                                        <input type="text" name="vorname" class="form-control" placeholder="Vorname"  autofokus required>
                                    </div>
                                    
                                    <div class="form-label-group mt-2">
                                        <label for="Nachname">Nachname:</label>
                                        <input type="text" name="nachname" class="form-control" placeholder="Nachname" required>
                                    </div>

                                    <div class="form-label-group mt-2">
                                        <label for="Geburtsdatum">Geburtsdatum:</label>
                                        <input type="date" name="geburtsdatum" class="form-control" placeholder="Geburtsdatum" required>
                                    </div>
                                    
                                    <div class="form-label-group mt-4">
                                        <label for="verein">Verein: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select name="verein" id="verein" required>
                                            <option value='' size="45" >Bitte wählen</option>
                                        <?php 
                                            $vereine = doSelectVereine($link);
                                            
                                            foreach($vereine as $verein) {
                                                $nr=htmlspecialchars($verein['nr']);
                                                $titel=htmlspecialchars($verein['titel']);
                                                echo "<option value='$nr'>$titel</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-label-group mt-2">
                                        <label for="wohnort">Wohnort: &nbsp;&nbsp;&nbsp;</label>
                                        <select name="wohnort" id="wohnort" required>
                                            <option value='' size="45" >Bitte wählen</option>
                                        <?php 
                                           $wohnorte = doSelectWohnorte($link); 
                                            
                                            foreach($wohnorte as $ort) {
                                                $nr=htmlspecialchars($ort['PLZ']);
                                                $titel=htmlspecialchars($ort['Stadt']);
                                                echo "<option value='$nr'>".$nr." - ".$titel."</option>";
                                                }
                                        ?>
                                        </select>
                                    </div>

                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="anlegen" type="submit" value="anlegen">anlegen</button>
                                    
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






