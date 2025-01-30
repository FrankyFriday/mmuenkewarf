
<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';
require_once './functions/fileManagement.php';
require_once './functions/mailManagement.php';

$SID=$_GET['spiel'];
$AID=$_GET['anwaerter'];
$aus=$_GET['aus'];
$LID=$_GET['LID'];
$vor=$_GET['vor'];
$spieldaten=doSelectSpielDaten($SID,$link);

if (!empty($_FILES)) {
    $upload_folder = './berichte/'; //Das Upload-Verzeichnis
    
    $filename = $spieldaten['Anach']."_".$spieldaten['Avor']."_".$spieldaten['datum'];
    $extension = strtolower(pathinfo($_FILES['datei']['name'], PATHINFO_EXTENSION));
 
 
    //Überprüfung der Dateiendung
    $allowed_extensions = array('pdf');
    if(!in_array($extension, $allowed_extensions)) {
       die("Ung&uuml;ltige Dateiendung. Nur pdf-Dateien sind erlaubt");
    }

    //Überprüfung der Dateigröße
    $max_size = 2000*1024; //2000 KB
    if($_FILES['datei']['size'] > $max_size) {
       die("Bitte keine Dateien größer 2000kb hochladen");
    }

    //Pfad zum Upload
    $new_path = $upload_folder.$filename.'.'.$extension;

    //Alles okay, verschiebe Datei an neuen Pfad
    move_uploaded_file($_FILES['datei']['tmp_name'], $new_path);


    doUpdateBerichtVorhanden($SID,$link);
    doSendMail($spieldaten['Avor'],$spieldaten['Anach'],$spieldaten['datum'],$spieldaten['Pvor'],$spieldaten['Pnach'],$spieldaten['staffel'],$link);
    }
 
    ?>

<div class='container'>
    <form method='post'  enctype="multipart/form-data">
    <div class="row">
<!--EINGABE-->
        <div class="col-lg-7 mx-auto">
            <div class="card card-signin my-4">
                <div class="card-body">
                    <form class="form-signin">
                    
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
        </table>
        </h2>
                                
				    
            <div class="form-label-group mt-4">
                aktueller Bericht: <?php fileDoSearchBericht($spieldaten['datum'],$spieldaten['Avor'],$spieldaten['Anach']); ?>
            </div>                        
            <div class="form-label-group mt-4">
                <input type="file" name="datei" class="btn btn-outline-secondary form-control"  aria-label="" aria-describedby="basic-addon1">
            </div>
            <center>
                <?php if(fileDoSearchBerichtVorhanden($spieldaten['datum'],$spieldaten['Avor'],$spieldaten['Anach'])){ ?>
                    <input type="submit" class="btn btn-lg btn-primary btn-block mt-4" name="upload" value="Datei ändern">
                <?php }else {?>
                    <input type="submit" class="btn btn-lg btn-primary btn-block mt-4" name="upload" value="Datei hochladen">

                <?php }?>
            </center>
<?php
                    if ($_POST['upload']) {
                        if(isset($_GET['vor'])){
                        ?>
                    <a class="dropdown-item" href="?content=<?php echo $vor; ?>&anwaerter=<?php echo $AID; ?>&aus=<?php echo $aus; ?>&LID=<?php echo $LID; ?>"><center><i class="fa fa-check-square-o" aria-hidden="true"></i> Aktion war erfolgreich! Hier geht es zurück</center></a>
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                </tbody>
        </table>

    </form>
    
</div>
 
   