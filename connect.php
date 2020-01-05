<?php

function openConnection() {
    // Try to figure out what these should be for you
    $dbhost    = "localhost";
    $dbuser    = "root";
    $dbpass    = "root";
    $db        = "becode";

    // Try to understand what happens here
    $pdo = new PDO('mysql:host='. $dbhost .';dbname='. $db, $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // Why we do this here
    return $pdo;
}

/*try {
    $dbhost    = "localhost";
    $dbuser    = "root";
    $dbpass    = "root";
    $db        = "becode";

    $pdo = new PDO('mysql:host='. $dbhost .';dbname='. $db, $dbuser, $dbpass);
    // set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $pdo;
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}*/

?>