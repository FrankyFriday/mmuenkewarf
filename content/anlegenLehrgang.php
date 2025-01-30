<?php
require_once './functions/sqlInsert.php';
require_once './functions/sqlSelect.php';

if ($_POST['anlegen']) {
    $titel = $_POST['anwaerter'];
    $termin = $_POST['datum'];
    doInsertLehrgang($titel,$termin, $link);  
    $lehrgangID = doSelectLehrgangID($titel, $termin, $link);
    echo '<meta http-equiv="refresh" content="0; url=?content=anlegenAnwaerter&lehrgang='.$lehrgangID.'">';
    
} 
?>

<div class='container'>
    <form method='post' action='?content=anlegenLehrgang'>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">L E H R G A N G &emsp; anlegen</h2>
                                <form class="form-signin">
                                    
                                    <div class="form-label-group mt-4">
                                        <label for="anwaerter">Titel: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" name="anwaerter" id="anwaerter" value="Anwärterlehrgang Ort [Jahreszeit 20xx]" size="40" autofokus>
                                    </div>
                                    
                                    <div class="form-label-group mt-2">
                                        <label for="datum">Prüfungstermin: &nbsp; </label>
                                        <input type="date" name="datum" placeholder="Datum" required>
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






