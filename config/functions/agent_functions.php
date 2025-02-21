<?php
function all_agents()
{
    global $con;
    global $res;
    $agent_id       = 2;
    $super_agent_id = 1;

    try {
        $con->beginTransaction();

        $sql  = "SELECT * FROM accounts WHERE role_id = ? || role_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$agent_id, $super_agent_id]);
        $res = $stmt->fetchAll();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }
    return $res;
}

function get_agent($id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT * FROM accounts WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id]);
        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function save_agent($name, $email, $country, $tel, $password, $role_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO accounts (name, email, country, phone_no, password, role_id) VALUES (?,?,?,?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$name, $email, $country, $tel, $password, $role_id])) {
            $res = $con->lastInsertId();
        } else {
            $res = "Failed";
        }
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

//partner booking count
function agent_booking_count($agent_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT count(b.id) AS booking_count FROM bookings b INNER JOIN accounts a ON a.id = b.account_id WHERE a.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$agent_id]);
        $res = $stmt->fetch();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function agent_bookings($agent_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT b.id, a.id, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id INNER JOIN accounts a ON b.account_id = a.id WHERE a.id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$agent_id]);
        $res = $stmt->fetchAll();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function create_suv_rate($id)
{
    global $con;
    $category_id = 1;
    $rate        = 0;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id, $category_id, $rate]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

}

function create_mid_size_suv_rate($id)
{
    global $con;
    $category_id = 2;
    $rate        = 0;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id, $category_id, $rate]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }
}

function create_medium_car_rate($id)
{
    global $con;
    $category_id = 3;
    $rate        = 0;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id, $category_id, $rate]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }
}

function create_small_car_rate($id)
{
    global $con;
    $category_id = 4;
    $rate        = 0;
    $con->beginTransaction();
    $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->execute([$id, $category_id, $rate]);
    $con->commit();
    try {

    } catch (Exception $e) {
        $con->rollback();
    }
}

function create_safari_rate($id)
{
    global $con;
    $category_id = 5;
    $rate        = 0;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id, $category_id, $rate]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }
}

function create_luxury_rate($id)
{
    global $con;
    $category_id = 6;
    $rate        = 0;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id, $category_id, $rate]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }
}

function create_commercial_rate($id)
{
    global $con;
    $category_id = 7;
    $rate        = 0;

    try {
        $con->beginTransaction();
        $sql  = "INSERT INTO agent_rates (agent_id, category_id, rate) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        $stmt->execute([$id, $category_id, $rate]);
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }
}

function update_rate($agent_id, $category_id, $rate)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "UPDATE agent_rates SET rate = ? WHERE agent_id = ? AND category_id = ?";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$rate, $agent_id, $category_id])) {
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

function get_agent_rates($agent_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT a.id AS agent_id, cat.id AS category_id, cat.name, ar.rate FROM accounts a INNER JOIN agent_rates ar ON a.id = ar.agent_id INNER JOIN vehicle_categories cat ON ar.category_id = cat.id WHERE a.id = ? ORDER BY category_id ASC";
        $stmt = $con->prepare($sql);
        $stmt->execute([$agent_id]);

        $res = $stmt->fetchAll();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function get_agent_rate($agent_id, $category_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "SELECT rate FROM agent_rates WHERE agent_id = ? AND category_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$agent_id, $category_id]);

        $res = $stmt->fetch();

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}
