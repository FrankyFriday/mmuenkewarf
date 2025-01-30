<?php
session_start();
if (isset($_GET['logout'])) {
    session_destroy();
    session_start();
}
$initApp = parse_ini_file("./statics/settings.ini.php", TRUE);
require_once $initApp['path']['statics'] . '/errorHandling.php';
?>
<!DOCTYPE html>
<html>
    <?php
    require_once $initApp['path']['statics'] . '/header.php';

    ?>
    <body>
        <br><br>
        <?php
        if (array_key_exists("passwort", $_POST)) {
            require_once $initApp['path']['contents'] . "/loginVorgang.php";
        }

        if (isset($_GET["content"])) {
            $content = $_GET["content"]. ".php";
        } elseif (isset($_GET["aus"])) {
            $content = $_GET["aus"].".php";
        } else {
            $content = "start.php";
        }
        
        require_once $initApp['path']['statics'] . '/navbar.php';

        //Aufruf content
        if (file_exists($initApp['path']['contents'] . "/" . $content)) {
            if( !empty($initApp['allowedSites'][substr($content,0,-4)]) or $_SESSION['login']   ){
                include_once $initApp['path']['contents'] . "/" . $content;
            } else {
                include_once $initApp['path']['contents'] . "/forbiddenContent.php";
            }
        } else {
            include_once $initApp['path']['contents'] . "/fileNotFound.php";
        }
        ?>
        
    </body>
</html>
