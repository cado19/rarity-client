<?php
    $page = "receipt";
    include_once 'partials/client-header.php';
    // include_once 'partials/content_start.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    }
    $receipt    = receipt_details($id);


?>

<script>
    console.log(<?php echo json_encode($receipt); ?>);
</script>

<div class="container">
    <div class="row">
        <div class="col-12 col-xs-12">
            <img src="assets/rarity_contract_top.png" alt="" class="img-fluid">
        </div>
    </div>

    <div class="row d-flex justify-content-center">
        <div class="col-xs-12 col-sm-9 col-6">
            <h2 class="text-center">Booking receipt</h2>
            <p><b>Booking No:</b><?php echo " "; ?><?php show_value($receipt, 'booking_no'); ?></p>
            <p><b>Client:</b><?php echo " "; ?><?php show_value($receipt, 'first_name'); ?><?php echo " "; ?><?php show_value($receipt, 'last_name'); ?></p>
            <p><b>Amount:</b><?php echo " "; ?><?php show_value($receipt, 'amount'); ?></p>
            <p><b>Currency:</b><?php echo " "; ?><?php show_value($receipt, 'currency'); ?></p>
            <p><b>Payment Method:</b><?php echo " "; ?><?php show_value($receipt, 'payment_method'); ?></p>
            <p><b>Payment Account:</b><?php echo " "; ?><?php show_value($receipt, 'payment_account'); ?></p>
            
            <p><b>Total:</b><?php echo " "; ?><?php show_numeric_value($receipt, 'total'); ?>/- </p>
        </div>
    </div>
</div>