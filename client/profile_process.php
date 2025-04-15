<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    if (empty($_POST['image'])) {
        $err_msg = "No image was taken";
        header("Location: index.php?page=client/profile_form&err_msg=$err_msg&id=$id");
        exit;
    }

    $img = $_POST['image'];

    $folderPath = "client/profile/";

    $image_parts = explode(";base64,", $img);

    $image_type_aux = explode("image/", $image_parts[0]);

    $image_type = $image_type_aux[1];

    $image_base64 = base64_decode($image_parts[1]);

    $fileName = "profile_" . date("his") . '.png';

    $file = $folderPath . $fileName;

    file_put_contents($file, $image_base64);
    // update profile in the database
    $sql  = "UPDATE customer_details SET profile_image = ? WHERE id = ?";
    $stmt = $con->prepare($sql);
    $stmt->execute([$fileName, $id]);
    $msg = "Successfully updated your peofile";
    header("Location: index.php?page=client/success&msg=$msg");
    exit;

    // $err_msg = "There was an error uploading your image. Try again";
    // header("Location: index.php?page=client/register/profile_form&err_msg=$err_msg");
    // exit;

    print_r($fileName);
} else {
    $msg = "Unauthorized activity";
    header("Location: index.php?page=client/profile_form&err_msg=$msg");
    exit;
}
