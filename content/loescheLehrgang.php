
<?php
require_once './functions/select.php';
require_once './functions/doLehrgang.php';
require_once './functions/doHistory.php';

if ($_POST['loeschen']) {
    doVorgang($_SESSION['lehrgang'],$link);
    echo '<br> Der Vorgang wurde ausgeführt!';
}
?>


    
<div class='container'>
    <form method='post' action='?content=loescheLehrgang'>
    <table border="1" class='table table-striped'>
                <tbody
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="card card-signin my-4">
                            <div class="card-body">
                                <h2 class="container card-title text-center btn-lg btn-warning ">L Ö S C H E N</h2>
                                <form class="form-signin">
                                    <?php
                                    if (!$_POST['erstellen']) {
                                    ?>
				    <div class="form-label-group mt-4">
                                        <label for="lehrgang">Anwärterlehrgang:&ensp;&nbsp;</label> 
                                        <select name="lehrgang" id="lehrgang" required>
                                            <option value=''>Bitte wählen</option>
                                        <?php 
                                            SelectLehrgang($link);
                                        ?>
                                        </select>
                                    </div>
				    
				    <button class="btn btn-lg btn-primary btn-block mt-4" name="erstellen" type="submit" value="erstellen">löschen</button>
                                    <?php }
                                    if ($_POST['erstellen']) {
                                    ?>
				    <div class="form-label-group mt-4">
                                        <label for="lehrgang">Anwärterlehrgang:&ensp;&nbsp;</label> 
                                        <?php 
                                            findLehrgang($_POST['lehrgang'], $link);
                                            $_SESSION['lehrgang']=$_POST['lehrgang'];
                                        ?>
                                    </div>
				    
				    <button class="btn btn-lg btn-primary btn-block mt-4" name="loeschen" type="submit" value="loeschen">wirklich löschen</button>
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
