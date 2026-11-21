<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // code...
    header("Location: index.php?page=client/new_client");
    exit;
}

try {
    $con->beginTransaction();

    /*
    |--------------------------------------------------------------------------
    | Upload Images
    |--------------------------------------------------------------------------
    */

    $base_url = "https://www.raritycars.com/files/customers";

    $profileImage = null;
    $idFrontImage = null;
    $idBackImage  = null;
    $licenseImage = null;

    // Profile
    // Profile Selfie
    if (! empty($_POST['profile_image'])) {

        $img = $_POST['profile_image'];

        $profileImage =
        "profile_" . uniqid() . ".jpg";

        $image_parts =
            explode(";base64,", $img);

        if (count($image_parts) === 2) {

            $image_base64 =
                base64_decode(
                $image_parts[1]
            );

            file_put_contents(
                $base_url . "/profile/" . $profileImage,
                $image_base64
            );
        }
    }

    // ID Front
    if (! empty($_FILES['id_image']['tmp_name'])) {

        $idFrontImage =
        "id_front_" . time() . ".jpg";

        compressImage(
            $_FILES['id_image']['tmp_name'],
            $base_url . "id/" . $idFrontImage,
            70
        );
    }

    // ID Back
    if (! empty($_FILES['id_image_back']['tmp_name'])) {

        $idBackImage =
        "id_back_" . time() . ".jpg";

        compressImage(
            $_FILES['id_image_back']['tmp_name'],
            $base_url . "id/" . $idBackImage,
            70
        );
    }

    // License
    if (! empty($_FILES['license_image']['tmp_name'])) {

        $licenseImage =
        "license_" . time() . ".jpg";

        compressImage(
            $_FILES['license_image']['tmp_name'],
            $base_url . "/license/" . $licenseImage,
            70
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Insert Customer
    |--------------------------------------------------------------------------
    */

    $sql = "
	        INSERT INTO customer_details
	        (
	            first_name,
	            last_name,
	            email,

	            country,
	            date_of_birth,

	            id_type,
	            id_no,

	            dl_no,
	            dl_expiration,

	            phone_no,

	            residential_address,
	            work_address,

	            profile_image,
	            id_image,
	            id_back_image,
	            license_image
	        )
	        VALUES
	        (
	            ?,?,?,?,?,?,
	            ?,?,?,?,?,?,
	            ?,?,?,?
	        )
	    ";

    $stmt = $con->prepare($sql);

    $stmt->execute([
        $_POST['first_name'],
        $_POST['last_name'],
        $_POST['email'],

        $_POST['country'],
        $_POST['date_of_birth'],

        $_POST['id_type'],
        $_POST['id_number'],

        $_POST['dl_number'],
        $_POST['dl_expiry'],

        $_POST['tel'],

        $_POST['residential_address'],
        $_POST['work_address'],

        $profileImage,
        $idFrontImage,
        $idBackImage,
        $licenseImage,
    ]);

    $customerId = $con->lastInsertId();

    $con->commit();

    $msg = "Registration completed successfully";

    header(
        "Location: index.php?page=client/success&id={$customerId}&msg={$msg}"
    );

    exit;

} catch (Exception $e) {
    $con->rollBack();

    error_log($e->getMessage());

    $err_msg =
        urlencode("Registration failed. Please try again.");

    header(
        "Location: index.php?page=client/new&err_msg={$err_msg}"
    );

    exit;
}
