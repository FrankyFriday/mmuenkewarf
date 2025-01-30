<style>
    .selectInput{
        width: 12vw;
    }
    </style>
    
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';
$PID = $_GET['pate'];

if ($_POST['start']) {
    $kommentarNew=$_POST['kommentar'];
    $wohnortNew=$_POST['wohnort'];
    
    if($kommentarNew<>$kommentar){
       doUpdatePatenKommentar($PID,$kommentarNew,$link);
    }
    if($wohnortNew<>$wohnort){
       doUpdatePatenWohnort($PID,$wohnortNew,$link);
    }
}

$value = doSelectPatenDatenKorrektur($PID,$link);
$vor= $value['vor'];
$nach= $value['nach'];
$kommentar= $value['Bemerkung'];
$wohnort= $value['Wohnort'];

 

?>
<div class='container'>
    <form method='post' >
    <div class="row">
<!--EINGABE-->
        <div class=" mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    <h2 class="container card-title text-center btn-lg btn-warning ">Pate/Patin:&emsp;<?php echo $nach.", ".$vor; ?></h2>
                    <form class="form-signin">
                        
                        <div class="form-label-group mt-4">
                            <label for="wohnort">Wohnort: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select name="wohnort" id="wohnort" required>
                            <?php 
                               $wohnorte = doSelectWohnorte($link); 

                                foreach($wohnorte as $ort) {
                                    $nr=htmlspecialchars($ort['PLZ']);
                                    $titel=htmlspecialchars($ort['Stadt']);
                                    if($nr==$wohnort){                                        
                                        echo "<option value='$nr' selected>".$nr." - ".$titel."</option>";
                                    } else {
                                        echo "<option value='$nr'>".$nr." - ".$titel."</option>";
                                    }
                                }
                            ?>
                            </select>
                        </div>
                        <hr>
			<div class="form-label-group mt-2">
                            <label for="kommentar">Bemerkung:&emsp; &emsp; &emsp;&emsp;</label> 
                            <input type="text" name='kommentar' id='kommentar' size="40" maxlength="100" value="<?php echo $kommentar; ?>">
                        </div>
			<hr>
                        <div class="mt-4">
                        
                        
                        <button class="btn btn-lg btn-primary btn-block" name="start" type="submit" value="start">änderen</button>
                        <?php
                        if ($_POST['start']) {
                            echo '<a class="dropdown-item" href="?content=patenAuflistung"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>';}
                        else{
                        ?>
                                
                        
                        
                            <a class="dropdown-item" href="?content=patenAuflistung"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
                        <?php } ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<!--AUSGABE-->

    </form>
    </form>
</div>

