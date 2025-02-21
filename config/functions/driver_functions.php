<?php
// get all driver records
function all_drivers()
{
    global $con;
    global $drivers;
    $status = "false";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, first_name, last_name, email, id_no, phone_no FROM drivers WHERE deleted = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $drivers;
}

// get single driver record
function get_driver($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT * FROM drivers WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// save driver into the database
function save_driver($first_name, $last_name, $email, $id_number, $dl_number, $tel, $date_of_birth, $password)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql = "INSERT INTO drivers
				(first_name, last_name, email, id_no, dl_no, phone_no, date_of_birth, password)
				VALUES (?,?,?,?,?,?,?,?)";

        $stmt = $con->prepare($sql);
        if ($stmt->execute([$first_name, $last_name, $email, $id_number, $dl_number, $tel, $date_of_birth, $password])) {
            $res = "Success";
        } else {
            $res = "Uncsuccessful";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// update driver record
function update_driver($first_name, $last_name, $email, $id_number, $dl_number, $tel, $date_of_birth, $id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();
        $sql  = "UPDATE drivers SET first_name = ?, last_name = ?, email = ?, id_no = ?, dl_no = ?, phone_no = ?, date_of_birth = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$first_name, $last_name, $email, $id_number, $dl_number, $tel, $date_of_birth, $id])) {
            $res = "Success";
        } else {
            $res = "Uncsuccessful";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to delete a driver
function delete_driver($id)
{
    global $con;
    global $res;
    $status = "true";

    try {
        $con->beginTransaction();

        $sql  = "UPDATE drivers SET deleted = ? WHERE id = ?";
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

// DRIVER BOOKING FUNCTIONS

// get bookings where driver is assigned
function driver_home_bookings($driver_id)
{
    global $con;
    global $res;
    $status = "upcoming";

    try {
        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.driver_id = ? AND b.status = ? ORDER BY b.created_at DESC LIMIT 5";
        $stmt = $con->prepare($sql);
        $stmt->execute([$driver_id, $status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function driver_workplan_bookings($driver_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT b.booking_no AS title, b.start_date AS start, b.end_date AS end FROM bookings b WHERE b.driver_id = ? ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$driver_id]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}
