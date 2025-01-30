<?php
function dropdownLehrgänge($link) {
    $results = $link->query("SELECT l.LID AS ID, l.Lehrgangsname AS titel
                                FROM lehrgang l ORDER BY l.`Prüfungsdatum` ASC;");
    
    foreach($results as $result) {
        $ID=htmlspecialchars($result['ID']);
        $titel=htmlspecialchars($result['titel']);

        echo '<a class="dropdown-item" href="?content=Lehrgang&LID='.$ID.'"><i class="fa fa-group"></i> '.$titel.'</a>';
    }
}

function dropdownPrüfungen($link) {
    $results = $link->query("SELECT p.PruefungsId, p.Art, p.Standort, p.Test, p.Datum, p.Pruefer
                                FROM pruefungen p ORDER BY p.Datum ASC;");
    
    foreach($results as $result) {
        $id=htmlspecialchars($result['PruefungsId']);
        $art=htmlspecialchars($result['Art']);
        $standort=htmlspecialchars($result['Standort']);
        $test=htmlspecialchars($result['Test']);
        $datum=htmlspecialchars($result['Datum']);
        $datumNew = new DateTime($datum);  
        $zeitpunkt = $datumNew->format("d.m.y-H:i");

        echo '<a class="dropdown-item" href="?content=pruefung&id='.$id.'"><i class="fa fa-group"></i> '.$zeitpunkt." - ".$art." in ".$standort." (".$test.")</a>";
    }
}

function dropdownVeranstaltungen($link) {
    $results = $link->query("SELECT l.LehrabendId, l.Thema, l.Art, l.Datum, l.Standort
                                FROM lehrabende l ORDER BY l.Datum ASC;");
    
    foreach($results as $result) {
        $id=htmlspecialchars($result['LehrabendId']);
        $art=htmlspecialchars($result['Art']);
        $standort=htmlspecialchars($result['Standort']);
        $thema=htmlspecialchars($result['Thema']);
        $datum=htmlspecialchars($result['Datum']);
        $datumNew = new DateTime($datum);  
        $zeitpunkt = $datumNew->format("d.m.y-H:i");

        echo '<a class="dropdown-item" href="?content=lehrveranstaltung&id='.$id.'"><i class="fa fa-group"></i> '.$zeitpunkt." - ".$art." in ".$standort." (".$thema.")</a>";
    }
}
?>
<!--<meta http-equiv="refresh" content="10">-->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="">Menü</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">


<!-- A U F L I S T U N G -->                                   
<?php
if ($_SESSION['login']) {
    ?>             
            <li class="nav-item dropdown <?php if ($content == "auflistungAuswahl.php" || $content == "kader.php" || $content == "auflistung.php") {
            echo "active";
                     } ?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-sort-amount-desc"></i>
                        Auflistung <?php if ($content == "auflistungAuswahl.php" || $content == "kader.php" || $content == "auflistung.php") {
                        echo '<span class="sr-only">(current)</span>';}?>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="?content=auflistungAuswahl&detail=alter"><i class="fa fa-users"></i> nach Alter</a>
                    <a class="dropdown-item" href="?content=auflistungAuswahl&detail=quali"><i class="fa fa-users"></i> nach SR Q-Max</a>
                    <a class="dropdown-item" href="?content=kader"><i class="fa fa-users"></i> nach Kader</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?content=auflistung&detail=Ue50"><i class="fa fa-users"></i> Schiedsrichter Ü50</a>
                    <a class="dropdown-item" href="?content=auflistung&detail=U50"><i class="fa fa-users"></i> Schiedsrichter U50</a>
                    <a class="dropdown-item" href="?content=auflistung&detail=Frauen"><i class="fa fa-users"></i> Schiedsrichter Frauen</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="?content=auflistung&detail=keinSpiel"><i class="fa fa-users"></i> kein Spiel</a>
                </div>
            </li>
<?php } ?> 

  
<!-- L E H R V E R A N S T A L T U N G E N -->                                   
<?php
if ($_SESSION['login']) {
    ?>             
            <li class="nav-item dropdown <?php if ($content == "lehrveranstaltung.php") {
            echo "active";
                     } ?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-calendar-o"></i>
                        Lehrveranstaltungen <?php if ($content == "lehrveranstaltung.php") {
                        echo '<span class="sr-only">(current)</span>';}?>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    dropdownVeranstaltungen($link);
                    ?>
                </div>
            </li>
<?php } ?>
 
           
<!-- L E I S T U N G S P R U E F U N G -->                                   
<?php
if ($_SESSION['login']) {
    ?>             
            <li class="nav-item dropdown <?php if ($content == "pruefung.php") {
            echo "active";
                     } ?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-graduation-cap"></i>
                        Leistungsprüfung <?php if ($content == "pruefung.php") {
                        echo '<span class="sr-only">(current)</span>';}?>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    dropdownPrüfungen($link);
                    ?>
                </div>
            </li>
<?php } ?>
 
           
<!-- A N W Ä R T E R L E H R G Ä N G E -->                                   
<?php
if ($_SESSION['login']) {
    ?>             
            <li class="nav-item dropdown <?php if ($content == "Lehrgang.php" || $aus == "Lehrgang" || $vor == "Lehrgang") {
            echo "active";
                     } ?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-list"></i>
                        Anwärterlehrgänge <?php if ($content == "Lehrgang.php" || $aus == "Lehrgang" || $vor == "Lehrgang") {
                        echo '<span class="sr-only">(current)</span>';}?>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    dropdownLehrgänge($link);
                    ?>
                </div>
            </li>
<?php } ?>
            
             
<!-- P A T E N S Y S T E M -->                                   
<?php
if ($_SESSION['login']) {
    ?>             
            <li class="nav-item dropdown <?php if ($content == "Aktionsboard.php" || $content == "Ansetzung.php" || $content == "patenAuflistung.php"|| $content == "Abrechnung.php"|| $content == "AllgemeinDokumente.php"|| $content == "Abschlussberichte.php") {
            echo "active";
                     } ?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-list"></i>
                        Patensystem <?php if ($content == "Aktionsboard.php" || $content == "Ansetzung.php" || $content == "patenAuflistung.php"|| $content == "Abrechnung.php"|| $content == "AllgemeinDokumente.php"|| $content == "Abschlussberichte.php") {
                        echo '<span class="sr-only">(current)</span>';}?>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem']) {
                    ?>
                    <a class="dropdown-item" href="?content=Aktionsboard"><i class="fa fa-users"></i> Aktionsboard</a>
                    <?php } ?>
                    <?php
                    if ($_SESSION['ansetzerPatensystem']) {
                    ?>
                    <a class="dropdown-item" href="?content=Ansetzung"><i class="fa fa-users"></i> Ansetzungen</a>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem']) {
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem']) {
                    ?>
                    <a class="dropdown-item" href="?content=patenAuflistung"><i class="fa fa-users"></i> Paten Dashboard</a>
                    <a class="dropdown-item" href="?content=Abrechnung"><i class="fa fa-users"></i> Paten Abrechnung</a>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem'] || $_SESSION['bericht']) {
                    ?>
                    <a class="dropdown-item" href="?content=pdferstellen" target="_blank"><i class="fa fa-file-pdf-o"></i> Bild zu PDF</a>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <a class="dropdown-item" href="?content=AllgemeinDokumente"><i class="fa fa-file-o"></i> Dokumente</a>
                    <a class="dropdown-item" href="?content=Abschlussberichte"><i class="fa fa-files-o"></i> Abschlussberichte</a>
                </div>
            </li>
<?php } ?>

     
<!--A N L E G E N-->                                   
<?php
if ($_SESSION['verwaltung'] || $_SESSION['lehrwart'] || $_SESSION['ansetzerPatensystem']) {
    ?>             
            <li class="nav-item dropdown <?php if ($content == "anlegenLehrgang.php" || $content == "anlegenAnwaerter.php" || $content == "anlegenPaten.php") {
            echo "active";
                     } ?>">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-pencil"></i>
                        anlegen <?php if ($content == "anlegenLehrgang.php" || $content == "anlegenAnwaerter.php" || $content == "anlegenPaten.php") {
                        echo '<span class="sr-only">(current)</span>';}?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['lehrwart']) {
                    ?>
                    <a class="dropdown-item" href="?content=anlegen&detail=Lehrveranstaltung"><i class="fa fa-users"></i> neue Lehrveranstaltung</a>
                    <a class="dropdown-item" href="?content=anlegenTeilnahme&detail=lehrveranstaltung"><i class="fa fa-user-plus"></i> Teilnahme</a>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['lehrwart']) {
                    ?>
                    <a class="dropdown-item" href="?content=anlegen&detail=Leistungspruefung"><i class="fa fa-users"></i> neue Leistungsprüfung</a>
                    <a class="dropdown-item" href="?content=anlegenErgebnisse&detail=leistungspruefung"><i class="fa fa-user-plus"></i> Teilnahme</a>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung']) {
                    ?>
                    <a class="dropdown-item" href="?content=anlegenKader"><i class="fa fa-cog"></i> Kader bearbeiten</a>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem'] || $_SESSION['lehrwart']) {
                    ?>
                    <a class="dropdown-item" href="?content=anlegenLehrgang"><i class="fa fa-users"></i> neuer Anwärterlehrgang</a>
                    <a class="dropdown-item" href="?content=anlegenAnwaerter"><i class="fa fa-user-plus"></i> neue(r) Anwärter*in</a>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem']) {
                    ?>
                    <div class="dropdown-divider"></div>
                    <?php } ?>
                    <?php
                    if ($_SESSION['verwaltung'] || $_SESSION['ansetzerPatensystem']) {
                    ?>
                    <a class="dropdown-item" href="?content=anlegenPaten"><i class="fa fa-user-plus"></i> neue(r) Pate/Patin</a>
                    <?php } ?>
                </div>
            </li>
<?php } ?>

<!--A D M I N I S T R A T I O N-->                                   
<?php
if ($_SESSION['admin']) {
?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                   <i class="fa fa-database"></i>  Administration
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
		    <a class="dropdown-item" href="?content=upload&detail=stammdaten"><i class="fa fa-upload"></i> Stammdaten upload</a>
                    <a class="dropdown-item" href="?content=upload&detail=spielestatistik"><i class="fa fa-upload"></i> Spielestatiskik upload</a>
                    <div class="dropdown-divider"></div>
		    <a class="dropdown-item" href="?content=loginAuflistung">Login</a>
		    <a class="dropdown-item" href="?content=history">Logs</a>
                    <div class="dropdown-divider"></div>
		    <a class="dropdown-item" href="?content=myhost" target="_blank">bplaced - Host</a>
		    <a class="dropdown-item" href="?content=myadmin" target="_blank">phpMyAdmin</a>
            </li>
<?php
}
?>

<!--A N M E L D U N G--> 
<?php
if($_SESSION['login']==false){
?>
            <li class="nav-item <?php if ($content == "loginForm.php") {
    echo "active";
} ?>">
                <a class="nav-link" href="?content=loginForm">
                    <i class="fa fa-arrow-circle-right"></i>
                    Anmeldung <?php if ($content == "loginForm.php") {
    echo '<span class="sr-only">(current)</span>';
} ?>
                </a>
            </li>
<?php
}
?>
        </ul>
<!--L O G I N--> 
<?php
if ($_SESSION['login']) {
            echo "<div class='mr-2 text-light'>";
            echo $_SESSION['Benutzer'];
            echo "<a href='?content=start&logout=1'>";
            echo "<button class='btn btn-outline-light my-2 my-sm-0 ml-2'><i class='fa fa-sign-out'></i></button>";
            echo "</a>";
            echo "</div>";
?>
        <button class="btn btn-outline-success my-2 my-sm-0 sticky-top" type="submit">
        <i class="fa fa-user"></i>
        </button>
<?php
}else{
?>
        <button class="btn btn-outline-danger my-2 my-sm-0 sticky-top" type="submit">
        <i class="fa fa-user"></i>
        </button>
<?php
}
?>
    </div>
</nav> 

