<?php
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

    if ($voucher['driver_fee'] > 0) {
        $subtotal += $voucher['driver_fee'];
    }

    if ($voucher['fuel'] > 0) {
        $subtotal += $voucher['fuel'];
    }

    $subtotal += $voucher['total'];

?>

<script>
    console.log(<?php echo json_encode($voucher); ?>);
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
                <p><b>Daily Rate:</b><?php echo " "; ?>Ksh. <?php show_numeric_value($voucher, 'daily_rate'); ?>/-</p>
            <?php else: ?>
                <p><b>Daily Rate:</b><?php echo " "; ?><del>Ksh. <?php show_numeric_value($voucher, 'daily_rate'); ?>/-</del> <ins>Ksh. <?php show_numeric_value($voucher, 'custom_rate'); ?>/-</ins></p>
            <?php endif; ?>

            <p><b>Fuel Fee:</b><?php echo " "; ?>Ksh. <?php show_numeric_value($voucher, 'fuel'); ?>/-</p>

            <?php if ($voucher['driver_fee'] > 0): ?>
              <p><b>Driver Fee:</b><?php echo " "; ?>Ksh. <?php show_numeric_value($voucher, 'driver_fee'); ?>/-</p>
              <p><b>Vehicle Fee:</b><?php echo " "; ?>Ksh. <?php show_numeric_value($voucher, 'total'); ?>/-</p>
            <?php endif; ?>

            <?php if ($voucher['cdw_total'] > 0): ?>
                <p><b>CDW Fee:</b><?php echo " "; ?>Ksh. <?php show_numeric_value($voucher, 'cdw_total'); ?>/- </p>
            <?php endif; ?>
            
            <p><b>Subtotal:</b><?php echo " "; ?>Ksh. <?php echo number_format($subtotal); ?>/- </p>

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
