<?php
// save a payment that comes from pesapal
function save_payment($booking_no, $currency, $amount, $payment_status)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "INSERT INTO payments (booking_no, currency, amount, status) VALUES (?,?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$booking_no, $currency, $amount, $payment_status])) {
            $res = true;
        } else {
            $res = false;
        }
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function update_payment($payment_account, $status, $message, $payment_method, $confirmation_code, $order_tracking_id, $payment_time, $booking_no)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "UPDATE payments SET payment_account = ?, status = ?, message = ?, payment_method = ?, confirmation_code = ?, order_tracking_id = ?, payment_time = ? WHERE booking_no = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$payment_account, $status, $message, $payment_method, $confirmation_code, $order_tracking_id, $payment_time, $booking_no])) {
            $res = true;
        } else {
            $res = false;
        }
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get all payments
function all_payments()
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "SELECT * FROM payments";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function existing_payment($order_tracking_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "SELECT id FROM payments WHERE order_tracking_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$order_tracking_id]);
        if ($stmt->rowCount == 1) {
            $res = "Exists";
        } else {
            $res = "New";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get receipt details 
function receipt_details($id){
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, b.custom_rate, b.total, c.first_name, c.last_name, p.currency, p.amount, p.payment_time, p.payment_method, p.payment_account  FROM bookings b INNER JOIN  customer_details c ON b.customer_id = c.id INNER JOIN payments p ON b.booking_no = p.booking_no WHERE p.order_tracking_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}
