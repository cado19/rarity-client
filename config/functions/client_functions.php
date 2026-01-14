<?php
// fetch client for login
function fetch_client($email)
{
    global $con;
    global $client;

    try {
        $con->beginTransaction();

        $sql  = "SELECT * FROM customer_details WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->rowCount() == 1) {
            $res = $stmt->fetch();
        } else {
            $res = "No such person";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get all vehicles for catalog
function catalog_vehicles()
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql = "SELECT vb.id, vb.model, vb.make, vb.number_plate, vb.category, vp.daily_rate FROM vehicle_basics vb INNER JOIN vehicle_pricing vp ON vb.id = vp.vehicle_id";

        $stmt = $con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get single vehicle for catalog
function catalog_vehicle($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql = "SELECT vb.make, vb.model, vb.number_plate, vb.category, vb.drive_train, vb.seats, vb.fuel, vb.transmission, vp.daily_rate, vp.vehicle_excess, vp.refundable_security_deposit, ve.bluetooth, ve.keyless_entry, ve.reverse_cam, ve.audio_input, ve.gps, ve.android_auto, ve.apple_carplay FROM vehicle_basics vb INNER JOIN vehicle_pricing vp ON vb.id = vp.vehicle_id INNER JOIN vehicle_extras ve ON vb.id = ve.vehicle_id WHERE vb.id = ?";

        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function all_customers()
{
    global $con;
    global $res;
    $status = "false";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, first_name, last_name, email, id_no, phone_no FROM customer_details WHERE deleted = ? ORDER BY first_name DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get most recent customers
function recent_customers()
{
    global $con;
    global $res;
    $status = "false";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, first_name, last_name, email, id_no, phone_no FROM customer_details WHERE deleted = ? ORDER BY created_at DESC LIMIT 10";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function get_customer($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT * FROM customer_details WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// check whether a customer exists with the given email
function unique_customer_email($email)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT id FROM customer_details WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $res = "Email taken";
        } else {
            $res = "You may proceed";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// create customer account through self sign up
function create_customer_account($email, $password)
{
    global $con;
    global $res;
    $registration = "Yes";

    try {
        $con->beginTransaction();

        $sql  = "INSERT INTO customer_details (email, password, self_registered) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$email, $password, $registration])) {
            $res = $con->lastInsertId();
        } else {
            $res = "No Success";
        }

        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}

// save customer when created from admin section
function save_customer($first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "INSERT INTO customer_details (first_name, last_name, email, id_type, id_no, dl_no, dl_expiration, phone_no, residential_address, work_address, date_of_birth) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry ?: null, $tel, $residential_address, $work_address, $date_of_birth ?: null])) {
            $res = "Success";
        } else {
            $res = "Unsuccessful";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
        error_log("Save client failed: " . $e->getMessage());
        $res = "Error: " . $e->getMessage();
    }

    return $res;
}

function save_client($first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "INSERT INTO customer_details (first_name, last_name, email, id_type, id_no, dl_no, dl_expiration, phone_no, residential_address, work_address, date_of_birth) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth])) {
            $res = "Success";
        } else {
            $res = "Uncsuccessful";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
        error_log("Save client failed: " . $e->getMessage());
        $res = "Error: " . $e->getMessage();
    }

    return $res;
}

// update customer
function update_customer($first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth, $id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "UPDATE customer_details SET first_name = ?, last_name = ?, email = ?, id_type = ?, id_no = ?, dl_no = ?, dl_expiration = ?, phone_no = ?, residential_address = ?, work_address = ?, date_of_birth = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$first_name, $last_name, $email, $id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth, $id])) {
            $res = "Success";
        } else {
            $res = "Unsuccessful";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to update clients from the client's dashboard
function update_client($id_type, $id_number, $tel, $residential_address, $work_address, $date_of_birth, $dl_number, $dl_expiry, $id)
{
    global $con;
    global $res;
    try {
        $con->beginTransaction();
        $sql  = "UPDATE customer_details SET id_type = ?, id_no = ?, dl_no = ?, dl_expiration = ?, phone_no = ?, residential_address = ?, work_address = ?, date_of_birth = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$id_type, $id_number, $dl_number, $dl_expiry, $tel, $residential_address, $work_address, $date_of_birth, $id])) {
            $res = "Success";
        } else {
            $res = "Unsuccessful";
        }
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function login_customer($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql = "SELECT first_name, last_name, phone_no, email, date_of_birth, dl_no, dl_expiration, id_no, residential_address,
				work_address, id_image, profile_image, license_image FROM customer_details WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to delete a customer
function delete_customer($id)
{
    global $con;
    global $res;
    $status = "true";

    try {
        $con->beginTransaction();

        $sql  = "UPDATE customer_details SET deleted = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$status, $id])) {
            $res = "Deleted";
        } else {
            $res = "Failed to delete";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// this function sets blacklist field to true in customer_details table
function blacklist_customer($id)
{
    global $con;
    global $res;
    $status = "true";

    try {
        $con->beginTransaction();
        $sql  = "UPDATE customer_details SET blacklisted = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$status, $id])) {
            $res = "Success";
        } else {
            $res = "Failed";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function blacklist_reason($id, $reason)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO blacklist (customer_id, reason) VALUES (?,?)";
        $stmt = $con->prepare($sql);
        $res  = $stmt->execute([$id, $reason]);
        // if ($stmt->execute([$id, $reason])) {
        // 	$res = "Success";
        // } else {
        // 	$res = "Failed";
        // }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function blacklisted_customers()
{
    global $con;
    global $res;
    $status = "true";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, first_name, last_name, email, id_no, phone_no FROM customer_details WHERE blacklisted = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get bookings for a cusomer
function customer_bookings($id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE c.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}
