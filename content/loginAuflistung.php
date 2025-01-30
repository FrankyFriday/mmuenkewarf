<style>
    th{
        font-size: .8vw;
    }
    td{
        font-size: .8vw;
    }
    .text{
        margin-left: .3vw;
    }
    .legende{
        font-size: .5vw;
    }
    
    button {
        margin-left: 1vw;
      background: none;
      border: none;
      padding: 0;
      cursor: pointer;
    }
    .tempPass{
        font-size: .8vw;
        margin-top: 1vw;
        margin-left: 60vw;
    }
</style>

<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';

if($_POST['edit']){
    doUpdatePasswortToTemp($_POST['edit'],$link);
}

$results=doSelectLoginListe($link);
$i=0;
?>

<form method='post' >
<div class='mt-4'></div>
<center><h2>Login Auflistung</h2></center>
<center>
   <table border="5px solid black" frame="box">  
    <tr bgcolor='#A4A4A4'> 
        <th style='width: 8vw'><center>Nachname</center></th>
        <th style='width: 8vw'><center>Vorname</center></th>
        <th style='width: 6vw'><center>Geburtsdatum</center></th>
        <th style='width: 9vw'><center>letzter Login</center></th>
        <th style='width: 6vw'><center>Nutzername</center></th>
        <th style='width: 6vw'><center>Tempwort</center></th>
    </tr>
    <?php
    foreach($results as $result){
        $id=htmlspecialchars($result['LID']);
        $vorname=htmlspecialchars($result['vor']);
        $nachname=htmlspecialchars($result['nach']);
        $nutzername=htmlspecialchars($result['nutzer']);
        $passwort=htmlspecialchars($result['pass']);
        $datum=htmlspecialchars($result['geb']);
        $login=htmlspecialchars($result['logi']);
    ?>
    <tr bgcolor='<?php if($i==1){echo 'cfcfcf'; $i=0;}else{echo '#FFFFFF';$i=1;}?>' >
        <td><span class='text'><?php echo $nachname; ?></span></td>
        <td><span class='text'><?php echo $vorname; ?></span></td>
        <td><center><?php
            $geburtstag = new DateTime($datum);
            echo $geburtstag->format('d.m.Y');  ?>
        </center></td>
        <td><center><?php
            $letzerLogin = new DateTime($login);
            echo $letzerLogin->format('d.m.Y - H:i');  ?>
        </center></td>
        <td><span class='text'><?php echo $nutzername; ?></span></td>
   <td><span class='text'>
       <?php 
       if($passwort== 1){
           echo 'erlaubt';           
       }else{ 
           echo 'verboten';
           echo '<button name="edit" value="'.$id.'"><i class="fa fa-edit"></i></button>';

           
       } ?></span></td>
    </tr>
	<?php           
    }
?>
</table>
   
</center>
<span class="tempPass">temporäres Passwort: paten</span>
</form>

