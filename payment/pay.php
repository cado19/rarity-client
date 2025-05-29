<?php
    $response = save_payment($_POST['reference'], $_POST['currency'], $order['amount'], $payment_status);
?>
<h2>Payment form</h2>
<div class="row-fluid">
    <div class="span4 text-center">
        <img src="assets/kizusi_logo_white.png" class="img-circle profile-avatar" alt="User avatar">
    </div>

    <div id="rightcol2" class="span8">
        <iframe src="<?php echo $iframe_src; ?>" width="100%" height="900px"  scrolling="yes" frameBorder="0">
        	<p>Browser unable to load iFrame</p>
        </iframe>
    </div>
</div>