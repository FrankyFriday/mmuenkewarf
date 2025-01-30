<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class='container pt-4'>
    <?php
    if($_SESSION['patenTempPass']){
        ?>        
            <meta http-equiv="refresh" content="0; url=?content=loginTempPass">
        <?php
    }elseif ($_SESSION['login']){
        ?>
                <meta http-equiv="refresh" content="1; url=?content=<?php echo $_SESSION['StartEbene']; ?>">
                <div class="text-center h2 text-success"><br><br>Anmeldung erfolgreich!<br><br>Sie werden in wenigen Sekunden weitergeleitet...</div><br>
                <div class="d-flex justify-content-center">
                <div class="spinner-border"style=" width: 3rem; height: 3rem;" role="status">
                <span class="sr-only"></span>
                </div>
                </div>
    <?php
    }else{
        ?>
                <meta http-equiv="refresh" content="1; url=?content=loginForm">
                <div class="text-center h2 text-danger"><br><br>Anmeldung fehlgeschlagen!<br><br>Sie werden in wenigen Sekunden zur&uuml;ck zur Anmeldung weitergeleitet...</div><br>
                <div class="d-flex justify-content-center">
                <div class="spinner-border"style=" width: 3rem; height: 3rem;" role="status">
                <span class="sr-only"></span>
                </div>
                </div>
<?php
    }
    ?>

</div>

