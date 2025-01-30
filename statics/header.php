<head>
	<html lang="de">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <title>Patenspiele</title>
    <link rel="icon" type="image/png" href="./images/icons8-fußball-emoji-96.png">
    <?php
    require_once './functions/dbConn.php';
        $link = connectToDatabase();
	$link ->set_charset("utf8");
        
    ?>
</head>

