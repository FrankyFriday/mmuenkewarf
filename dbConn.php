<?php
function connectToDatabase() {
    $link = mysqli_connect("localhost", "root", "", "srostfriesland");
    if (!$link) {
        die("Datenbankverbindung gescheitert");
    }
    return $link;
}



//online
//function connectToDatabase() {
//    $link = mysqli_connect("database-5017070556.webspace-host.com", "dbu3929612", "srOstfriesland24", "dbs13735838");
//    if (!$link) {
//        die("Datenbankverbindung gescheitert");
//    }
//    return $link;
//}

function doQuery($query, $link) {
    $result = mysqli_query($link, $query);
    if (mysqli_num_rows($result) > 0) {
        return $result;
    } else {
        return false;
    }
}

function doInsert($insertQuery, $link) {
    return mysqli_query($link, $insertQuery);
}
