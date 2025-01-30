<?php

require_once './functions/authentification.php';

$nutzername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
$passwort = filter_input(INPUT_POST, 'passwort', FILTER_SANITIZE_STRING);

$login = "failed";

if (doLogin($nutzername, $passwort, $link)) {
    $login = "passed";
}
?>

