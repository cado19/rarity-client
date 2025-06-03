<?php
// function to get all bookings
function bookings()
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date, b.status FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get upcoming bookings
function upcoming_bookings()
{
    global $con;
    global $res;
    $status = "upcoming";

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status = ? ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get active bookings
function active_bookings()
{
    global $con;
    global $res;
    $status = "active";

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status = ? ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get completed bookings
function completed_bookings()
{
    global $con;
    global $res;
    $status = "complete";

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status = ? ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get cancelled bookings
function cancelled_bookings()
{
    global $con;
    global $res;
    $status = "cancelled";

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status = ? ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get booking number
function get_booking_no($booking_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT booking_no FROM bookings WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$booking_id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get client details needed for booking
function client_from_booking($booking_id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT c.id AS customer_id, c.first_name AS customer_first_name, c.last_name AS customer_last_name, c.email AS customer_email, c.phone_no AS customer_phone_no, b.total, b.status, b.booking_no FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$booking_id]);
        $res = $stmt->fetch();

        $con->commit();

    } catch (Exception $e) {
        $con->rollback();
    }
    return $res;
}

function partner_bookings($partner_id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE v.partner_id = ? ORDER BY b.created_at DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$partner_id]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function bookings_endng_this_week()
{
    global $con;
    global $res;
    // $status = "cancelled";

    try {

        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE week(b.end_date) = week(now())";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}
// function to get all active bookings created by agents
function active_agent_bookings()
{
    global $con;
    global $res;
    $status = "active";

    try {

        $con->beginTransaction();

        $sql = "SELECT
    b.id,
    c.first_name,
    c.last_name,
    v.model,
    v.make,
    v.number_plate,
    b.start_date,
    b.end_date
FROM
    customer_details c
        INNER JOIN
    bookings b ON c.id = b.customer_id
        INNER JOIN
    vehicle_basics v ON b.vehicle_id = v.id
WHERE
    b.account_id IS NOT NULL AND b.status = ?
ORDER BY b.created_at DESC;";

        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get single booking
function booking($id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT c.id AS customer_id, c.first_name AS customer_first_name, c.last_name AS customer_last_name, v.id AS vehicle_id, v.model, v.make, v.number_plate, v.drive_train, cat.name AS category, v.seats, vp.daily_rate,d.id AS driver_id, d.first_name AS driver_first_name, d.last_name AS driver_last_name, b.start_date, b.end_date, b.start_time, b.end_time, b.total, b.status, b.booking_no, b.custom_rate, ct.status AS signature_status FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id INNER JOIN vehicle_pricing vp ON b.vehicle_id = vp.vehicle_id INNER JOIN contracts ct ON b.id = ct.booking_id INNER JOIN vehicle_categories cat ON v.category_id = cat.id INNER JOIN drivers d ON b.driver_id = d.id WHERE b.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// gets the daily rate of a vehicle in booking after it has just been saved
function get_booking_vehicle_daily_rate($booking_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT v.daily_rate FROM vehicle_pricing v INNER JOIN bookings b ON v.vehicle_id = b.vehicle_id WHERE b.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$booking_id]);
        $res = $stmt->fetch();
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to update last booking details (total_price)
function update_booking($total, $id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "UPDATE bookings SET total = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$total, $id])) {
            $res = "Success";
        } else {
            $res = "Error";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to assign(hand over) a vehicle to the client
function assign_vehicle($id, $fuel, $account_id)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "UPDATE bookings SET fuel = ?, assign_id = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$fuel, $account_id, $id])) {
            $res = "Success";
        } else {
            $res = "Error";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to get all vehicles for the booking process
function booking_vehicles()
{
    global $con;
    global $bk_vehicles;
    $status = "false";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, make, model, number_plate FROM vehicle_basics WHERE deleted = ? AND partner_id IS NULL ORDER BY id DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $bk_vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $bk_vehicles;
}

// function to get all partner vehicles for the booking process
function partner_booking_vehicles()
{
    global $con;
    global $bk_vehicles;
    $status  = "false";
    $partner = '';

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, make, model, number_plate FROM vehicle_basics WHERE deleted = ? AND partner_id != ? ORDER BY id DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status, $partner]);
        $bk_vehicles = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $bk_vehicles;
}

// function to get all customers for the booking process
function booking_customers()
{
    global $con;
    global $bk_customers;
    $status = "false";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, first_name, last_name FROM customer_details WHERE deleted = ? ORDER BY id DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $bk_customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $bk_customers;
}

// function to get all drivers for the booking process
function booking_drivers()
{
    global $con;
    global $bk_drivers;
    $status = "false";

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, first_name, last_name FROM drivers WHERE deleted = ? ORDER BY id DESC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $bk_drivers = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $bk_drivers;
}

// function to insert booking into database
function save_booking($v_id, $c_id, $d_id, $a_id, $start_date, $end_date, $start_time, $end_time, $custom_rate)
{
    global $con;
    global $res;
    $status = "upcoming";

    try {
        $con->beginTransaction();

        $sql  = "INSERT INTO bookings (vehicle_id, customer_id, driver_id, account_id, start_date, end_date, start_time, end_time, custom_rate, status) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$v_id, $c_id, $d_id, $a_id, $start_date, $end_date, $start_time, $end_time, $custom_rate, $status])) {
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

// function to insert booking with custom rate into database
function save_custom_booking($v_id, $c_id, $d_id, $a_id, $start_date, $end_date, $start_time, $end_time, $rate, $total)
{
    global $con;
    global $res;
    $status = "upcoming";

    try {
        $con->beginTransaction();

        $sql  = "INSERT INTO bookings (vehicle_id, customer_id, driver_id, account_id, start_date, end_date, start_time, end_time, custom_rate, total, status) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$v_id, $c_id, $d_id, $a_id, $start_date, $end_date, $start_time, $end_time, $rate, $total, $status])) {
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

function update_booking_details($v_id, $c_id, $d_id, $start_date, $end_date, $start_time, $end_time, $custom_rate, $b_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "UPDATE bookings SET vehicle_id = ?, customer_id = ?, driver_id = ?, start_date = ?, end_date = ?, start_time = ?, end_time = ?, custom_rate = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$v_id, $c_id, $d_id, $start_date, $end_date, $start_time, $end_time, $custom_rate, $b_id])) {
            $res = "Success";
        } else {
            $res = "No Success";
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function custom_booking_update($v_id, $c_id, $d_id, $start_date, $end_date, $start_time, $end_time, $custom_rate, $total, $b_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "UPDATE bookings SET vehicle_id = ?, customer_id = ?, driver_id = ?, start_date = ?, end_date = ?, start_time = ?, end_time = ?, custom_rate = ?, total = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$v_id, $c_id, $d_id, $start_date, $end_date, $start_time, $end_time, $custom_rate, $total, $b_id])) {
            $res = "Success";
        } else {
            $res = "No Success";
        }
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// function to insert booking number into the database
function save_booking_number($id, $number)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "UPDATE bookings SET booking_no = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$number, $id]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

}

// function to activate booking
function activate_booking($id)
{
    global $con;
    global $res;
    $status = "active";

    try {
        $con->beginTransaction();
        $sql  = "UPDATE bookings SET status = ? WHERE id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$status, $id])) {
            $res = "Success";
        } else {
            $res = "Failed";
        }
        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}

// get details for booking voucher
function booking_voucher_details($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT b.id, b.booking_no, b.custom_rate, b.driver_fee, b.total, b.start_date, b.start_time, b.end_date, b.end_time, b.created_at, vb.make, vb.model, vb.number_plate, vp.daily_rate, c.first_name, c.last_name, d.first_name, d.last_name FROM bookings b INNER JOIN vehicle_basics vb ON b.vehicle_id = vb.id INNER JOIN customer_details c ON b.customer_id = c.id INNER JOIN vehicle_pricing vp ON b.vehicle_id = vp.vehicle_id INNER JOIN drivers d ON b.driver_id = d.id WHERE b.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (\Throwable $th) {
        $con->rollback();
    }

    return $res;
}



function booked_vehicles()
{
    global $con;
    global $res;
    $status = "active";

    try {
        $con->beginTransaction();
        $sql  = "SELECT v.make, v.model, v.number_plate, b.booking_no, b.end_date FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id WHERE b.status = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll();
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function booked_vehicles_home()
{
    global $con;
    global $res;
    $status = "active";

    try {
        $con->beginTransaction();
        $sql  = "SELECT v.make, v.model, v.number_plate, b.booking_no, b.end_date FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id WHERE b.status = ? LIMIT 5";
        $stmt = $con->prepare($sql);
        $stmt->execute([$status]);
        $res = $stmt->fetchAll();
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}
