<?php
    $page = "Make Payment";
    if (isset($_GET['id'])) {
        $id         = $_GET['id'];
        $customer   = client_from_booking($id);
        $booking_no = get_booking_no($id);
    } else {
        $err_msg = "An error occured";
        header("Location: index.php?page=home&err_msg=$err_msg");
    }

    include_once 'partials/client-header.php';
?>
<script>
	console.log(<?php echo json_encode($customer) ?>);
</script>
<div class="container">
	<div class="row d-flex justify-content-center">
		<div class="col-xs-12 col-sm-9 col-8">
			<div class="text-center">
				<img src="assets/rarity_contract_top.png" alt="" class="img-fluid">
			</div>
			<h3 class="text-center">Make Payment</h3>
			<form id="rightcol" action="index.php?page=payment/iframe" method="post" class="rounded5">
		            <table>
		                <tr>
		                    <td>First Name:</td>
		                    <td><input type="text" name="first_name" value="<?php show_value($customer, 'customer_first_name'); ?>" class="form-control" /></td>
		                </tr>
		                <tr>
		                    <td>Last Name:</td>
		                    <td><input type="text" name="last_name" value="<?php show_value($customer, 'customer_last_name'); ?>" class="form-control" /></td>
		                </tr>
		                <tr>
		                    <td>Email Address:</td>
		                    <td><input type="text" name="email" value="<?php show_value($customer, 'customer_email'); ?>" class="form-control" /></td>
		                </tr>
		                <tr>
		                    <td>Phone Number:</td>
		                    <td><input type="text" name="phone_number" value="<?php show_value($customer, 'customer_phone_no'); ?>" class="form-control" /></td>
		                </tr>
		                <tr>
		                    <td>Amount:</td>
		                    <td>
		                        <select name="currency" id="currency">
		                            <option value="KES">Kenya shillings</option>
		                            <option value="UGX">Ugandan Shillings</option>
		                            <option value="TZS">Tanzanian shillings</option>
		                            <option value="USD">US Dollars</option>
		                        </select>
		                        <input type="text" name="amount" value="" class="form-control" />
		                    </td>
		                </tr>
		                <tr id="refholder" style="visibility: hidden">
		                    <td>Reference:</td>
		                    <td><input type="text" name="reference" value="<?php show_value($booking_no, 'booking_no'); ?>" /></td>
		                </tr>
		                <tr><td colspan="2"><hr /></td></tr>
		                <tr>
		                    <td>Description:</td>
		                    <td><input type="text" name="description" value="<?php show_value($booking_no, 'booking_no'); ?>" class="form-control" /></td>
		                </tr>
		                <tr><td colspan="2"><hr /></td></tr>
		                <tr>
		                    <td colspan="2"><input type="submit" value="Make Payment" class="btn btn-outline-primary" /></td>
		                </tr>
		            </table>
		        </form>
		</div>
	</div>
</div>


