<?php
function vehicle_count() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT COUNT(id) AS number_of_cars FROM vehicle_basics";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch();

		$con->commit();
	} catch (\Throwable $th) {
		$con->rollback();
	}

	return $res;
}

function customer_count() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT COUNT(id) AS number_of_customers FROM customer_details";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (\Throwable $th) {
		$con->rollback();
	}

	return $res;
}

function home_active_bookings() {
	global $con;
	global $res;
	$status = "active";

	try {
		$con->beginTransaction();

		$sql = "SELECT COUNT(id) AS number_of_bookings FROM bookings WHERE status = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (\Throwable $th) {
		$con->rollback();
	}

	return $res;
}

function partner_count() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT COUNT(id) AS number_of_partners FROM partners";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (\Throwable $th) {
		$con->rollback();
	}

	return $res;
}

// get the number of cars returning this week
function vehicles_returning_this_week_count(){
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS return_count FROM bookings b WHERE week(b.end_date) = week(now())";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (\Throwable $th) {
		$con->rollback();
	}

	return $res;
}

function home_bookings() {
	global $con;
	global $res;

	try {

		$con->beginTransaction();

		$sql = "SELECT b.id, c.first_name, c.last_name, v.model, v.make, v.number_plate, b.start_date, b.end_date FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id ORDER BY b.created_at DESC LIMIT 5";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function upcoming_workplan_bookings(){
	global $con;
	global $res;
	$status = "upcoming";

	try {

		$con->beginTransaction();

		$sql = "SELECT CONCAT(b.booking_no, ' ', c.first_name, ' ', c.last_name, ' ', v.make, ' ', v.number_plate) AS title, b.start_date AS start, b.end_date AS end FROM bookings b INNER JOIN customer_details c ON b.customer_id = c.id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function active_workplan_bookings(){
	global $con;
	global $res;
	$status = "active";

	try {
		$con->beginTransaction();

		$sql = "SELECT CONCAT(b.booking_no, ' ', c.first_name, ' ', c.last_name, ' ', v.make, ' ', v.number_plate) AS title, b.start_date AS start, b.end_date AS end FROM bookings b INNER JOIN customer_details c ON b.customer_id = c.id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$con->commit();
		
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}
?>