<?php

// THIS SCRIPT WILL PROCESS ID UPLOAD

// PROCESS THE FORM
if ($_SERVER['REQUEST_METHOD'] == "POST") {
	$msg = "";

	$id = $_POST['id'];

	$filename = $_FILES["license_image"]["name"];
	$tempname = $_FILES["license_image"]["tmp_name"];
	// new file name to eliminate conflicts even if someone uploads the same file twice for different records.
	$filenameNew = "license_" . date("his") . ".png";

	// folder to upload the image and also its destination
	$folder = "customers/license/" . $filenameNew;

	$compressedFront = compressImage($tempname, $folder, 70); 


	// Now let's move the uploaded image into the folder: image
  // $response = upload_image($folder, $tempname);
	if ($compressedFront) {
		$sql = "UPDATE customer_details SET license_image = ? WHERE id = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$filenameNew, $id]);
		$msg = " Image uploaded successfully!";
	} else {
		$msg = "Failed to upload image!";
	}

	header("Location: index.php?page=client/register/success&msg=$msg");
}
