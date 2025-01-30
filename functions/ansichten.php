<?php
function doAnsichtAktionsboardPatenspiele($statusNR,$link){
    $results = $link->query("SELECT s.SID AS nr, s.Datum AS datum, b.Kuerzel AS staffel,a.Vorname AS Avor, a.Nachname AS Anach, p.Vorname AS Pvor, p.Nachname AS Pnach, s.`status` AS statNr, a.AID AS AID
                                FROM spiele s
                                INNER JOIN paten p ON s.Pate=p.PID
                                INNER JOIN anwaerter a ON s.Anwaerter=a.AID
                                LEFT JOIN staffeln b ON s.Staffel=b.SID
                                WHERE s.`Status`=$statusNR
                                ORDER BY s.Datum, a.Nachname, a.Vorname;");
    $aus='Aktionsboard';
    ?>
    <table border="2px solid black" frame="box" >  
            <tr bgcolor='#A4A4A4'> 
                <th width=130><p align="center">Datum</p></th>
                <th width=250><p align="center">Anwärter*in</p></th>
                <th width=250><p align="center">Pate/Patin</p></th>
                <th width=100><p align="center">Staffel</p></th>
                <th width=140><p align="center">Aktion</p></th>
            </tr>
                <?php    
    foreach($results as $result) {
        $SID=htmlspecialchars($result['nr']);
        $datum=htmlspecialchars($result['datum']);
        $date = new DateTime($datum);
        $heute = new DateTime(date('Y-m-d'));
        $staffel=htmlspecialchars($result['staffel']);       
        $Avor=htmlspecialchars($result['Avor']);
        $Anach=htmlspecialchars($result['Anach']);
        $Pvor=htmlspecialchars($result['Pvor']);
        $Pnach=htmlspecialchars($result['Pnach']);
        $AID=htmlspecialchars($result['AID']);
        $statNr=htmlspecialchars($result['statNr']);
    ?>
        <tr bgcolor='<?php if($heute>$date and $statusNR==0){echo '7FFFD4';}else{ if($i==1){echo 'cfcfcf'; $i=0;}else{echo '#FFFFFF';$i=1;}}?>'>
            <td><div align="center"><?php echo $date->format('d.m.y'); ?></div></td>
            <td><div align="center"><?php echo $Anach.", ".$Avor; ?></div></td>
            <td><div align="center"><?php echo $Pnach.", ".$Pvor; ?></div></td>
            <td><div align="center"><?php echo $staffel; ?></div></td>
            <td><center>
<?php
        switch ($statNr) {
            case 0:
                if($_SESSION['ansetzer']){
                $pate=true;
                }                
                $bericht=false;
                if($_SESSION['ansetzer']){
                $delete=true;
                }
                if($_SESSION['ansetzer'] or $_SESSION['bericht']){
                $status=true;
                }
                break;
            case 1:
                $pate=false;
                if($_SESSION['bericht']){
                $bericht=true;
                }                
                $delete=false;
                if($_SESSION['ansetzer'] or $_SESSION['bericht']){
                $status=true;
                }
                break;
            case 2:
                $pate=false;
                $bericht=false;
                $delete=false;
                $status=false;
                break;
            case 3:
                if($_SESSION['ansetzer']){
                $pate=true;
                }
                $bericht=false;
                if($_SESSION['ansetzer']){
                $delete=true;
                }
                if($_SESSION['ansetzer'] or $_SESSION['bericht']){
                $status=true;
                }
                break;
            case 4:
                if($_SESSION['ansetzer']){
                $pate=true;
                }
                $bericht=false;
                if($_SESSION['ansetzer']){
                $delete=true;
                }
                if($_SESSION['ansetzer'] or $_SESSION['bericht']){
                $status=true;
                }
                break;
            case 5:
                $pate=false;
                $bericht=false;
                $delete=false;
                $status=false;
                break;
        }
        if($pate){
?>
            <a href="?content=SpielBearbeiten&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>" style="color:#000000;"><i class="fa fa-user-times"></i></a>&emsp;
<?php 
        }
        if($delete){
?>
            <a href="?content=SpielLoeschen&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>" style="color:#000000;"><i class="fa fa-trash"></i></a>&emsp;
<?php 
        }
        if($status){
?>
            <a href="?content=AnwaerterSpieleStatus&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>" style="color:#000000;"><i class="fa fa-question-circle-o"></i></a>
<?php 
        }
        if($bericht){
?>
            &emsp;<a href="?content=BerichteHochladen&aus=<?php echo $aus; ?>&anwaerter=<?php echo $AID; ?>&spiel=<?php echo $SID; ?>" style="color:#000000;"><i class="fa fa-upload"></i></a>
        <?php } ?>
            </center>
            </td>
        </tr>
    <?php } ?>
    </table>
<?php
}