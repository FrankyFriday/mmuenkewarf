<?php
require_once './functions/sqlUpdate.php';
require_once './functions/sqlInsert.php';
$err=false;
if(isset($_POST['senden'])){
    if($_POST['passwort1']==$_POST['passwort2']){
        $hash = password_hash($_POST['passwort1'], PASSWORD_ARGON2ID); // Argon2 wird hier verwendet
        doUpdateLoginPasswort($hash,$link);
        $_SESSION['login'] = true;
        $_SESSION['patenTempPass']=false;
        ?>
            <meta http-equiv="refresh" content="0; url=?content=login">
        <?php
    }else{
        $err=true;
    }
}
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div class='container'>
            <form method="post">
                <table border="1" class='table table-striped'>
                    <tbody
                       <div class="container">
                        <div class="row">
                        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
                        <div class="card card-signin my-5">
                        <div class="card-body">
                            <h2 class="container card-title text-center">A N M E L D U N G</h2>
                        
                        <form class="form-signin">
                        <div class="form-label-group mt-4">
                            <label for="username">neues Passwort:</label>
                        <input type="password" name="passwort1" class="form-control" placeholder="Passwort" required>
                        </div>

                        <div class="form-label-group mt-4">
                         <label for="Password">neues Passwort wiederholen:</label>
                        <input type="password" name="passwort2" class="form-control" placeholder="Passwort wiederholen" required>
                         
                        </div>
                        <?php 
                        if($err){
                        ?>
                        <div class="form-label-group mt-4">
                            <span style="color: red">Passwörter stimmen nicht überein!</span>
                        </div>
                        <?php } ?>

                        <button class="btn btn-lg btn-primary btn-block mt-4" name="senden" type="submit">bestätigen</button>
              
              
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
                            </tbody>
                </table>
            </form>
        </div>

