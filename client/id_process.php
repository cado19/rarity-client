<?php

// THIS SCRIPT WILL PROCESS ID UPLOAD

// PROCESS THE FORM
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $id = $_POST['id'];
    // VALIDATIONS
    if (($_FILES['id_image']["name"] == '')) {
        $err_msg = "Front side id image is required";
        header("Location: index.php?page=client/register/id_form&err_msg=$err_msg&id=$id");
        exit;
    }

    if (($_FILES['id_image_back']["name"] == '')) {
        $err_msg = "Back side id image is required";
        header("Location: index.php?page=client/register/id_form&err_msg=$err_msg&id=$id");
        exit;
    }

    $msg = "";

    $front_filename = $_FILES["id_image"]["name"];
    $front_tempname = $_FILES["id_image"]["tmp_name"];

    $back_filename = $_FILES["id_image_back"]["name"];
    $back_tempname = $_FILES["id_image_back"]["tmp_name"];
    // new file name to eliminate conflicts even if someone uploads the same file twice for different records.
    $front_filenameNew = "id_front_" . date("his") . ".png";
    $back_filenameNew  = "id_back_" . date("his") . ".png";

    // folder to upload the image and also its destination
    $front_folder = "customers/id/" . $front_filenameNew;
    $back_folder  = "customers/id/" . $back_filenameNew;

    // Compress size and upload image 
    $compressedFront = compressImage($front_tempname, $front_folder, 70); 
    $compressedBack = compressImage($back_tempname, $back_folder, 70); 


    // $sql  = "UPDATE customer_details SET id_image = ?, id_back_image = ? WHERE id = ?";
    // $stmt = $con->prepare($sql);
    // $stmt->execute([$front_filenameNew, $back_filenameNew, $id]);

    // Now let's move the uploaded image into the folder: image
    // Now let's move the uploaded image into the folder: image
    // $response = upload_image($front_folder, $front_tempname);
    // $result   = upload_image($back_folder, $back_tempname);

    if ($compressedFront) {
        if ($compressedBack) {
            $sql  = "UPDATE customer_details SET id_image = ?, id_back_image = ? WHERE id = ?";
            $stmt = $con->prepare($sql);
            $stmt->execute([$front_filenameNew, $back_filenameNew, $id]);
            $msg = "Successfully uploaded ID images";
            header("Location: index.php?page=client/register/success&msg=$msg");
            exit;
        } else {
            $err_msg = "Failed to upload back ID image!";
            header("Location: index.php?page=client/profile/show&err_msg=$err_msg&id=$id");
            exit;
        }
    } else {
        $err_msg = "Failed to upload front image!";
        header("Location: index.php?page=client/profile/show&err_msg=$err_msg&id=$id");
        exit;
    }

}
