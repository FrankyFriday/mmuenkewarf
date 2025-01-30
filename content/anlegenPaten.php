<center>
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';

if ($_POST['anlegen']) {
    $vorname = filter_input(INPUT_POST, 'vorname', FILTER_SANITIZE_STRING);
    $nachname = filter_input(INPUT_POST, 'nachname', FILTER_SANITIZE_STRING);
    $geburtsdatum = $_POST['geburtsdatum'];
    $wohnort = $_POST['wohnort'];
    
    doInsertPate($vorname,$nachname, $geburtsdatum, $wohnort, $link);
} 
?>
</center>
<div class='container'>
    <form method='post' action='?content=anlegenPaten'>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning">P A T E / P A T I N &emsp; anlegen</h2>

                                <form class="form-signin">
                                    <div class="form-label-group mt-4">
                                        <label for="Vorname">Vorname:</label>
                                        <input type="text" name="vorname" class="form-control" placeholder="Vorname" required>
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
                                    
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






