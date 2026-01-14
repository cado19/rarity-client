<?php
    // THIS SCRIPT WILL HANDLE THE NEW CUSTOMER FORM PROCESSING

    // error_reporting(E_ALL);
    // ini_set('display_errors', 1);

    $first_name = $last_name = $email = $id_type = $id_number = $dl_number = $dl_expiry = $tel = $residential_address = $work_address = $date_of_birth = $account_id = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //VALIDATIONS
    if (empty($_POST['first_name'])) {
        $first_name_err = "Required";
        header("Location: index.php?page=client/new&first_name_err=$first_name_err");
        exit;
    }
    if (empty($_POST['last_name'])) {
        $last_name_err = "Required";
        header("Location: index.php?page=client/new&last_name_err=$last_name_err");
        exit;
    }
    if (empty($_POST['email'])) {
        $email_err = "Required";
        header("Location: index.php?page=client/new&email_err=$email_err");
        exit;
    }
    if (empty($_POST['id_type'])) {
        $id_type_err = "Required";
        header("Location: index.php?page=client/new&id_type_err=$id_type_err");
        exit;
    }

    if (empty($_POST['date_of_birth'])) {
        $date_of_birth_err = "Required";
        header("Location: index.php?page=client/new&date_of_birth_err=$date_of_birth_err");
        exit;
    }

    $first_name = ucfirst($_POST['first_name']);
    $last_name  = ucfirst($_POST['last_name']);
    $email      = $_POST['email'];
    $id_type    = $_POST['id_type'];
    $id_number  = $_POST['id_number'];
    $dl_number  = $_POST['dl_number'];
    // $dl_expiry  = $_POST['dl_expiry'];
    $dl_expiry = ! empty($_POST['dl_expiry'])
        ? date('Y-m-d H:i:s', strtotime($_POST['dl_expiry']))
        : null;

    $date_of_birth = ! empty($_POST['date_of_birth'])
        ? date('Y-m-d H:i:s', strtotime($_POST['date_of_birth']))
        : null;
    $tel                 = $_POST['tel'];
    $residential_address = $_POST['residential_address'];
    $work_address        = $_POST['work_address'];
    // $date_of_birth       = $_POST['date_of_birth'];

    $details = [$first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth, $account_id];

    $result = save_client($first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth);

    echo $result;

    if ($result == "Success") {
        $msg = "Successfully registered";
        header("Location: index.php?page=client/success&msg=$msg");
    } else {
        $err_msg = "An error occured";
        header("Location: index.php?page=client/new&err_msg=$err_msg");
    }
    $log->info($result);
    } else {
    $msg = "Unauthorized activity";
    session_start();
    session_destroy();
    header("Location: index.php?err_msg=$msg");
    exit;
    }

?>
<script>
	console.log(<?php echo json_encode($result); ?>);
</script>