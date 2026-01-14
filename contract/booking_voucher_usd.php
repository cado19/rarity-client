<?php
    // THIS SCRIPT IS FOR THE BOOKING VOUCHER IN USD. IT WILL CONVERT THE FIGURES WHICH ARE IN KSH BY DEFAULT TO USD

    $req_url = "https://v6.exchangerate-api.com/v6/$apiKey/latest/KES";

    // fetch exchange rate data
    // $response_json = file_get_contents($req_url);

    $ch = curl_init($req_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10); // optional: timeout in seconds
    $response_json = curl_exec($ch);

    if (curl_errno($ch)) {
        echo "cURL error: " . curl_error($ch);
        exit;
    }

    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($http_code !== 200 || ! $response_json) {
        echo "Failed to fetch exchange rate (HTTP $http_code)";
        exit;
    }

    $page = "Voucher";
    include_once 'partials/client-header.php';
    // include_once 'partials/content_start.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    $voucher    = booking_voucher_details($id);
    $created    = strtotime($voucher['created_at']);
    $start_date = strtotime($voucher['start_date']);
    $end_date   = strtotime($voucher['end_date']);

    $subtotal = 0;

    $driver_fee  = $voucher['driver_fee'];
    $fuel_fee    = $voucher['fuel'];
    $daily_rate  = $voucher['daily_rate'];
    $custom_rate = $voucher['custom_rate'];
    $total       = $voucher['total'];

    if ($voucher['driver_fee'] > 0) {
        $subtotal += $voucher['driver_fee'];
    }

    if ($voucher['fuel'] > 0) {
        $subtotal += $voucher['fuel_fee'];
    }

    $subtotal += $voucher['total'];

    //convert values to usd
    // driver fee
    // fuel fee
    // custom rate
    // daily rate
    if ($response_json !== false) {
        try {
            $response = json_decode($response_json);
            if ($response->result === 'success') {
                $rate_usd        = $response->conversion_rates->USD;
                $driver_fee_usd  = round($driver_fee * $rate_usd, 2);
                $fuel_fee_usd    = round($fuel_fee * $rate_usd, 2);
                $daily_rate_usd  = round($daily_rate * $rate_usd, 2);
                $custom_rate_usd = round($custom_rate * $rate_usd, 2);
                $total_usd       = round($total * $rate_usd, 2);
                $subtotal_usd    = round($subtotal * $rate_usd, 2);

            }
        } catch (Exception $e) {
            echo "Error parsing exchange rate data";
            exit;
        }
    } else {
        echo "Failed to fetch exchange rate";
        exit;
    }

?>

<script>
	console.log(<?php echo json_encode($response); ?>);
</script>

<div class="container">
    <div class="row">
        <div class="col-12 col-xs-12">
            <img src="assets/rarity_contract_top.png" alt="" class="img-fluid">
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-xs-12 col-sm-9 col-6">
            <h2 class="text-center">Booking Voucher</h2>
            <p><b>Booking No:</b><?php echo " "; ?><?php show_value($voucher, 'booking_no'); ?></p>
            <p><b>Client:</b><?php echo " "; ?><?php show_value($voucher, 'customer_first_name'); ?><?php echo " "; ?><?php show_value($voucher, 'customer_last_name'); ?></p>
            <p><b>Vehicle:</b><?php echo " "; ?><?php show_value($voucher, 'make'); ?><?php echo " "; ?><?php show_value($voucher, 'model'); ?> </p>
            <p><b>Registration:</b><?php echo " "; ?><?php show_value($voucher, 'number_plate'); ?></p>
            <?php if ($voucher['custom_rate'] == 0): ?>
                <p><b>Daily Rate:</b><?php echo " "; ?>$<?php echo $daily_rate_usd; ?>/-</p>
            <?php else: ?>
                <p><b>Daily Rate:</b><?php echo " "; ?><del>$<?php echo $daily_rate_usd; ?>/-</del> <ins>$<?php echo $custom_rate_usd; ?>/-</ins></p>
            <?php endif; ?>

            <p><b>Fuel Fee:</b><?php echo " "; ?>$<?php echo $fuel_fee_usd; ?>/-</p>

            <?php if ($voucher['driver_fee'] > 0): ?>
              <p><b>Driver Fee:</b><?php echo " "; ?>$<?php echo $driver_fee_usd; ?>/-</p>
              <p><b>Vehicle Fee:</b><?php echo " "; ?>$<?php echo $total_usd; ?>/-</p>
            <?php endif; ?>

            <p><b>Subtotal:</b><?php echo " "; ?>$<?php echo $subtotal_usd; ?>/- </p>

            <p><b>Start Date:</b><?php echo " "; ?><?php echo date("l jS \of F Y", $start_date); ?></p>
            <p><b>End Date:</b><?php echo " "; ?><?php echo date("l jS \of F Y", $end_date); ?> </p>
            <p><b>Start Time:</b><?php echo " "; ?><?php show_value($voucher, 'start_time'); ?></p>
            <p><b>End Time:</b><?php echo " "; ?><?php show_value($voucher, 'end_time'); ?></p>
            <div id="payment-details">
                <h3>PAYMENT DETAILS: </h3>

                <p><b>BANK NAME:</b> I&M BANK</p>
                <p><b>BRANCH:</b> VALLEY ARCADE</p>
                <p><b>Account Name:</b> RARITY TRAVEL LTD</p>
                <p><b>ACCOUNT NUMBER:</b> 01605023636350 (KES)</p>
                <p><b>ACCOUNT NUMBER:</b> 01605023631250 (USD)</p>
                <p><b>S.W.I.F.T BIC:</b> IMBLKENA</p>
                <p><b>BRANCH CODE:</b> 016</p>
                <p><b>BANK CODE:</b> 057</p>
                <p><b>MPESA PAYBILL:</b> 400200</p>
                <p><b>ACCOUNT:</b> 40044610</p>

                <p><b>SECURE ONLINE PAYMENT PORTAL:</b></p>
                <a href="index.php?page=payment/new&id=<?php echo $id; ?>" class="btn btn-outline-success" target="_blank">Pay Now</a>
            </div>
        </div>
    </div>
</div>