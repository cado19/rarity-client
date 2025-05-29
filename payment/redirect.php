<?php
    // require_once('top.php');
    // require_once('db/dbconnector.php');
    require_once 'config/pesapalV30Helper.php';

    $consumer_key    = $CONSUMER_KEY;
    $consumer_secret = $CONSUMER_SECRET;

    $api = 'live';

    $helper = new pesapalV30Helper($api);

    $access       = $helper->getAccessToken($consumer_key, $consumer_secret);
    $access_token = $access->token;
    // echo $access_token;

    if (isset($_GET['OrderTrackingId'])) {
        $orderTrackingId = $_GET['OrderTrackingId'];
    }

    $status = $helper->getTransactionStatus($orderTrackingId, $access_token);

    $booking_no        = $status->merchant_reference;
    $currency          = $status->currency;
    $amount            = $status->amount;
    $payment_account   = $status->payment_account;
    $payment_status    = $status->payment_status_description;
    $message           = $status->message;
    $payment_method    = $status->payment_method;
    $confirmation_code = $status->confirmation_code;
    $order_tracking_id = $status->order_tracking_id;
    $payment_time      = $status->created_date;

    //check whether this transaction exists
    $transacion = existing_payment($order_tracking_id);
    if ($transacion == "Exists") {
        $msg = "That payment has been saved";
        header("Location: index.php?msg=$msg");
        exit;
    } else {
        // code...
        // A function to save the details above to DB
        $response = update_payment($payment_account, $payment_status, $message, $payment_method, $confirmation_code, $order_tracking_id, $payment_time, $booking_no);
        if ($response == true) {
            header("Location: index.php?page=payment/receipt&id=order_tracking_id")
        }
    }

    // var_dump($status)

    //At this point, you can update your database.
    //In my case i will let the IPN do this for me since it will run
    //IPN runs when there is a status change  and since this is a new transaction,
    //the status has changed for UNKNOWN to PENDING/COMPLETED/FAILED
    // <b>Status: </b> <?php echo $status->payment_status_description
?>
<script>
    console.log(<?php echo json_encode($status) ?>);
</script>
<h3>Callback/ return URl</h3>
<div class="row-fluid">
	<div class="span6">
        <b>PAYMENT RECEIVED SUCCESSFULLY</b>
        <blockquote>
         	<b>Order Tracking ID: </b> <?php echo $orderTrackingId; ?><br />
         	<b>Status: </b> <?php echo $status->payment_status_description; ?><br />
        </blockquote>
    </div>
</div>