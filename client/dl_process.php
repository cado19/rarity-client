<?php
// PROCESS THE FORM
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$msg = "";

	$id = $_POST['id'];
	if ($_FILES["dl_image"]["name"] == '') {
		$err_msg = "DL Image is required";
		header("Location: index.php?page=client/id_form&id=$id&err_msg=$err_msg");
		exit;
	}
	$filename = $_FILES["dl_image"]["name"];
	$tempname = $_FILES["dl_image"]["tmp_name"];
	// new file name to eliminate conflicts even if someone uploads the same file twice for different records.
	$filenameNew = "license_" . date("his") . ".png";

	// folder to upload the image and also its destination
	$folder = "customers/license/" . $filenameNew;

	$sql = "UPDATE customer_details SET license_image = ? WHERE id = ?";
	$stmt = $con->prepare($sql);
	$stmt->execute([$filenameNew, $id]);

	// Upload the image to the server
	$result = upload_image($folder, $tempname);

	// Now let's move the uploaded image into the folder: image
	if ($result == "Success") {
		$msg = " License uploaded successfully! Contact Admin to proceed";
        header("Location: index.php?page=client/register/success&msg=$msg");
        exit;
	} else {
		$msg = "Failed to upload image!";
		header("Location: index.php?page=client/register/dl_form&msg=$msg");
	}

}