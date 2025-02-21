<?php
    // THIS FILE IS RESPONSIBLE FOR CONNECTING THE APP TO THE DATABASE 

    include_once 'db_credentials/credentials.php';

    // DATABASE DRIVER
    $DBDRIVER = "mysql"; 

    // DATABASE HOST
    $DBHOST = "localhost"; 

    // DATABASE USER USERNAME
    $DBUSER = $DBUSERNAME; 

    // DATABASE USER PASSWORD
    $DBPASS = $DBPASSWORD; 

    // DATABASE NAME
    $DBNAME = "rarity-rental"; 


    try {
        $con = new PDO("$DBDRIVER:host=$DBHOST;dbname=$DBNAME",$DBUSER,$DBPASS);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
?>