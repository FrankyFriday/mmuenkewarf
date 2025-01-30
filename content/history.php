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
</style>

<?php
require_once './functions/sqlSelect.php';
require_once './functions/sqlInsert.php';
require_once './functions/sqlUpdate.php';

if($_POST['edit']){
    doUpdatePasswortToTemp($_POST['edit'],$link);
}

$results= doSelectHistoryListe($link);
?>

<form method='post' >
<div class='mt-4'></div>
<center><h2>History</h2></center>
<center>
   <table border="5px solid black" frame="box">  
    <tr bgcolor='#A4A4A4'> 
        <th style='width: 4vw'><center>ID</center></th>
        <th style='width: 8vw'><center>Zeitpunkt</center></th>
        <th style='width: 12vw'><center>Bearbeiter</center></th>
        <th style='width: 30vw'><center>Aktion</center></th>
    </tr>
    <?php
    foreach($results as $result){
        $id=htmlspecialchars($result['HID']);
        $zeitpunkt=htmlspecialchars($result['Zeitpunkt']);
        $aenderung=htmlspecialchars($result['Aenderung']);
        $vornameBearbeiter=htmlspecialchars($result['Vorname']);
        $nachnameBearbeiter=htmlspecialchars($result['Nachname']);
        $Nutzername=htmlspecialchars($result['Nutzername']);
    ?>
    <tr bgcolor='<?php if($i==1){echo 'cfcfcf'; $i=0;}else{echo '#FFFFFF';$i=1;}?>' >
        <td><center><?php echo $id; ?></center></td>
        <td><center><?php $zeitpunktFormat = new DateTime($zeitpunkt);
            echo $zeitpunktFormat->format('d.m.Y - H:i');  ?></center>
        </td>
        <td><span class='text'><?php if($vornameBearbeiter!="" && $nachnameBearbeiter!=""){ echo $vornameBearbeiter." ".$nachnameBearbeiter;}else{ echo $Nutzername;} ?></span></td>
   <td><span class='text'><?php echo $aenderung; ?></span></td>
    </tr>
	<?php           
    }
?>
</table>
   
</center>

</form>

