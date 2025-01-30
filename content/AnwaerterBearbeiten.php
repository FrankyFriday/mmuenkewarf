<style>
    .selectInput{
        width: 12vw;
    }
    </style>
    
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';
$AID = $_GET['anwaerter'];

$value = doSelectAnwaerterDaten($AID,$link);
$vor= $value['vor'];
$nach= $value['nach'];
$status= $value['stat'];
$kommentar= $value['Kommentar'];
$dfb= $value['frei'];
$talent= $value['Talent'];
$pool= $value['pool'];
$quali= $value['quali'];
$vereinAlt= $value['Verein'];
$wohnort= $value['Wohnort'];

if ($_POST['start']) {
    $statusNew=$_POST['status'];
    $kommentarNew=$_POST['kommentar'];
    $dfbNew=$_POST['dfb'];
    $talentNew=$_POST['talent'];
    $poolNew=$_POST['pool'];
    $qualiNew=$_POST['quali'];
    $vereinNew=$_POST['verein'];
    $wohnortNew=$_POST['wohnort'];

    if($statusNew<>$status){
       doUpdateAnwaerterStatus($AID,$statusNew,$link);
    }
    if($kommentarNew<>$kommentar){
       doUpdateAnwaerterKommentar($AID,$kommentarNew,$link);
    }
    if($dfbNew<>$dfb){
       doUpdateAnwaerterDFBnet($AID,$dfbNew,$link);
    }
    if($talentNew<>$talent){
       doUpdateAnwaerterTalent($AID,$talentNew,$link);
    }
    if($poolNew<>$pool){
       doUpdateAnwaerterPool($AID,$poolNew,$link);
    }
    if($qualiNew<>$quali && $qualiNew!=""){
        
       doUpdateAnwaerterQualifikation($AID,$qualiNew,$link);
    }
    if($vereinNew<>$vereinAlt){
       doUpdateAnwaerterVerein($AID,$vereinNew,$link);
    }
    if($wohnortNew<>$wohnort){
       doUpdateAnwaerterWohnort($AID,$wohnortNew,$link);
    }
  
} 

?>
<div class='container'>
    <form method='post' >
    <div class="row">
<!--EINGABE-->
        <div class=" mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    <h2 class="container card-title text-center btn-lg btn-warning ">Anwärter*in:&emsp;<?php echo $nach.", ".$vor; ?></h2>
                    <form class="form-signin">
                        <div class="form-label-group mt-2">
                            <label for="status">Status:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label> 
                            <select name="status" id="status" class="selectInput" >
                                <option <?php if($status==0){echo"selected";} ?> value='0'>nicht aktiv als SR</option>                                
                                <option <?php if($status==1){echo"selected";} ?> value='1'>aktiv als SR</option>                                
                                <option <?php if($status==2){echo"selected";} ?> value='2'>kein Interesse am Patensystem</option>
                            </select>
                        </div>
                        <div class="form-label-group mt-2">
                            <label for="verein">Verein: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <select name="verein" id="verein" required>
                            <?php 
                                $vereine = doSelectVereine($link);

                                foreach($vereine as $verein) {
                                    $nr=htmlspecialchars($verein['nr']);
                                    $titel=htmlspecialchars($verein['titel']);
                                    if($nr==$vereinAlt){                                        
                                        echo "<option value='$nr' selected>$titel</option>";
                                    }else{
                                        echo "<option value='$nr'>$titel</option>";
                                    }
                                }
                            ?>
                            </select>
                        </div>

                        <div class="form-label-group mt-2">
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
                        <div class="form-label-group mt-2">
                            <label for="dfb">DFBnet Freischaltung: &emsp;&emsp;</label> 
                            <select name="dfb" id="dfb" class="selectInput">
                                <option <?php if($dfb==0){echo"selected";} ?> value='0'>offen</option>
                                <option <?php if($dfb==1){echo"selected";} ?> value='1'>vorhanden</option>
                            </select>
                        </div>
                        <div class="form-label-group mt-2">
                            <label for="talent">Talent:&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;</label> 
                            <select name="talent" id="talent" class="selectInput">
                                <option <?php if($talent==0){echo"selected";} ?> value='0'>nein</option>
                                <option <?php if($talent==1){echo"selected";} ?> value='1'>ja</option>
                            </select>
                        </div>
                        <hr>
                        <div class="form-label-group mt-2">
                            <label for="durchlaufen">Patensystem durchlaufen? :   &emsp;</label>
                            <?php 
                            $einsaetzeStattGefunden=doSelectAnzahlEinsaetzeAnwaerter($AID,1,$link)+doSelectAnzahlEinsaetzeAnwaerter($AID,2,$link); 
                            if($einsaetzeStattGefunden>=3){
                                $datSpiel=doSelectLetztesSpielDatumAnwaerter($AID,$link);
                                $dat = new DateTime($datSpiel);
                                echo "letztes Spiel am ";
                                echo $dat->format('d.m.Y');
                            }else{
                                echo "nein";
                            }
                            ?>
                        </div>
                        <div class="form-label-group mt-2">
                            <label for="pool">Übergabe an Pool:&emsp; &emsp; &emsp;&emsp;&emsp;</label> 
                            <select name="pool" id="pool" class="selectInput">
                                <option <?php if($pool==0){echo"selected";} ?> value='0'>offen</option>
                                <option <?php if($pool==1){echo"selected";} ?> value='1'>erfolgreich</option>
                            </select>
                        </div>
                        <div class="form-label-group mt-2">
                            <label for="quali">höchste Qualifikation:&emsp;&emsp;&emsp;&emsp; </label> 
                            <select name="quali" id="quali" class="selectInput">
                                <?php if($quali==0){ ?>
                                    <option  selected value=''>Bitte wählen</option>
                                <?php 
                                }
                                doSelectStaffel($quali,$link);
                            ?>
                            </select>
                        </div>
                        <div class="mt-4">
                        
                        
                        <button class="btn btn-lg btn-primary btn-block" name="start" type="submit" value="start">änderen</button>
                        <?php
                        if ($_POST['start']) {
                            echo '<a class="dropdown-item" href="?content='.$_GET['aus'].'&LID='.$_GET['LID'].'"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>';}
                        else{
                        ?>
                                
                        
                        
                            <a class="dropdown-item" href="?content=<?php echo $_GET['aus']; ?>&LID=<?php echo $_GET['LID']; ?>"><center><i class="fa fa-undo" aria-hidden="true"></i> Hier geht es zurück zur Übersicht</center></a>
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

