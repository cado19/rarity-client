<?php
// our database configuration
include_once '../db_credentials/credentials.php';

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
    $con = new PDO("$DBDRIVER:host=$DBHOST;dbname=$DBNAME", $DBUSER, $DBPASS);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id     = $_POST['id'];
    $new_id = (string) $id;
    $status = "signed";

    $sig_string     = $_POST['signature'];
    $destination    = "signatures/";
    $nama_file      = "signature_" . date("his") . ".png";
    $file_to_upload = $destination . "signature_" . date("his") . ".png";
    // echo $nama_file;
    file_put_contents($file_to_upload, file_get_contents($sig_string));

    //SQL TO UPDATE CONTRACT
    $sql  = "UPDATE contracts SET signature = ?, status = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$nama_file, $status, $new_id]);

    // fetch id of booking from contracts for redirect
    $sql1  = "SELECT booking_id FROM contracts WHERE id = ?";
    $stmt1 = $con->prepare($sql1);
    $stmt1->execute([$new_id]);
    $booking_id = $stmt1->fetch();

    // redirect to booking show page
    // header("Location: ../index.php?page=bookings/show&id=" . $booking_id['booking_id']);

    // CHANGE BOOKING TO ACTIVE
}
