
<?php
require_once './functions/select.php';
require_once './functions/doSpiele.php';
require_once './functions/doHistory.php';

if ($_POST['delete']) {
    $SID = $_POST['alt'];
    doDeleteSpiel($SID, $link);
    echo "Spiel wurde entfernt.";
}

if ($_POST['anlegen']) {
    $SID = $_POST['alt'];
    $anwaerter = $_POST['anwaerter'];
    $paten = $_POST['paten'];
    $staffel = $_POST['staffel'];
    $datum = $_POST['datum'];
    $spielort = filter_input(INPUT_POST, 'spielort', FILTER_SANITIZE_STRING);
    if($anwaerter==""){
        $anwaerter = FindSpieldatenEinzelt("anwaerter",$SID, $link);
    }
    if($paten==""){
        $paten = FindSpieldatenEinzelt("paten",$SID, $link);
    }
    if($staffel==""){
        $staffel = FindSpieldatenEinzelt("staffel",$SID, $link);
    }
    if($datum==""){
        $datum = FindSpieldatenEinzelt("Spieldatum",$SID, $link);
    }
    if($spielort==""){
        $spielort = FindSpieldatenEinzelt("Spielort",$SID, $link);
    }
    doKorrekturSpiel($SID,$anwaerter,$paten, $staffel, $datum, $spielort, $link);
    echo "neue Spieldaten: Anw&auml;rter: ".$anwaerter." Paten: ".$paten." Staffel: ".$staffel." Datum: ".$datum." Ort: ".$spielort;
} 


?>

<div class='container'>
    <form method='post' action='?content=anlegenSpielBearbeiten'>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning">S P I E L &emsp; bearbeiten</h2>

                                <form class="form-signin">
                                    <div class="form-label-group mt-4">
                                        <label for="alt">alte Spieldaten:&nbsp;&nbsp; </label> 
                                        <select name="alt" id="alt" required>
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            SelectSpiel(0,$link)
                                        ?>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-label-group mt-4">
                                        <label for="datum">neues Datum:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="date" name="datum" placeholder="Datum">
                                    </div>
                                    
                                    <div class="form-label-group mt-2">
                                        <label for="spielort">neuer Spielort:&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <input type="text" name="spielort" placeholder="Spielort">
                                    </div>

                                    <div class="form-label-group mt-2">
                                        <label for="staffel">neue Staffel:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select name="staffel" id="staffel">
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            SelectStaffel($link);
                                        ?>
                                        </select>
                                    </div>  
                                    
                                    <div class="form-label-group mt-2">
                                        <label for="anwaerter">neuer Anwärter:&nbsp;</label>
                                        <select name="anwaerter" id="anwaerter">
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            SelectAnwaerter($link);
                                        ?>
                                        </select>
                                    </div>
                                    
                                     <div class="form-label-group mt-2">
                                        <label for="paten">neuer Pate:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                        <select name="paten" id="paten" >
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            SelectPaten($link);
                                        ?>
                                        </select>
                                    </div>
                                    
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="anlegen" type="submit" value="anlegen">korrigieren</button>
                                    <button class="btn btn-lg btn-primary btn-block mt-4" name="delete" type="submit" value="delete">Spiel l&ouml;chen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
</div>






