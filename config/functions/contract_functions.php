<?php
// function to insert contract into database
function create_contract($bk_id)
{
    global $con;
    global $res;
    global $lastId;

    try {
        $con->beginTransaction();

        $sql  = "INSERT INTO contracts (booking_id) VALUES (?)";
        $stmt = $con->prepare($sql);

        if ($stmt->execute([$bk_id])) {
            $res = "Successfully created contract";
        } else {
            $res = "An error occurred";
        }

        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}

// fetch id of the contract that is to be signed
function contract_to_sign($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT id from contracts WHERE booking_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}

// function to upload signature
function sign_contract($id, $file)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "UPDATE contracts SET signature = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$file, $id])) {
            $res = "success";
        } else {
            $res = "Failed";
        }

        $con->comit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}

function contract($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql = "SELECT c.first_name AS c_fname, c.last_name AS c_lname, c.id_no AS c_id_no, c.phone_no AS c_phone_no, c.email AS c_email,
					c.residential_address, d.first_name, d.last_name, d.id_no, d.phone_no, vb.make, vb.model, vb.number_plate, vp.daily_rate, vp.vehicle_excess,bk.start_date, bk.end_date, bk.start_time, bk.end_time, bk.custom_rate, bk.total, ct.signature, ct.created_at FROM bookings bk INNER JOIN customer_details c ON bk.customer_id = c.id INNER JOIN drivers d ON bk.driver_id = d.id INNER JOIN vehicle_basics vb ON bk.vehicle_id = vb.id INNER JOIN contracts ct ON ct.booking_id = bk.id INNER JOIN vehicle_pricing vp ON bk.vehicle_id = vp.vehicle_id WHERE bk.id = ?";

        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $con->commit();

    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}

// get booking id using contract id
function booking_from_contract($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT booking_id from contracts WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}
