<?php
//   ******************* */ CLIENT ANALYTIC FUNCTIONS ******************* */

// get clients with the most bookings
function client_most_bookings() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name, c.last_name, count(c.id) AS Bookings FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? GROUP BY c.id ORDER BY Bookings DESC LIMIT 10";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get single client with the most bookings
function client_most_booking() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name, c.last_name, count(c.id) AS Bookings FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? GROUP BY b.customer_id ORDER BY Bookings DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get clients whose bookings generated the most income
function most_profitable_clients() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name, c.last_name, sum(b.total) AS Income FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? GROUP BY b.customer_id ORDER BY sum(b.total) DESC LIMIT 10";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get client whose bookings generated the most income
function most_profitable_client() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name AS first_name, c.last_name AS last_name, sum(b.total) AS Total FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ?  GROUP BY c.id ORDER BY sum(b.total) DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

		// **** MONTHLY CLIENT ANALYTICS ****
// get clients with the most bookings
function client_most_bookings_month($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name, c.last_name, count(c.id) AS Bookings FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? AND month(b.created_at) = ? GROUP BY c.id ORDER BY Bookings DESC LIMIT 10";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status,$month]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get single client with the most bookings
function client_most_booking_month($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name, c.last_name, count(c.id) AS Bookings FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? AND month(b.created_at) = ? GROUP BY b.customer_id ORDER BY Bookings DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status,$month]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get clients whose bookings generated the most income
function most_profitable_clients_month($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name, c.last_name, sum(b.total) AS Income FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? AND month(b.created_at) = ? GROUP BY b.customer_id ORDER BY sum(b.total) DESC LIMIT 10";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status,$month]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get client whose bookings generated the most income
function most_profitable_client_month($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT c.first_name AS first_name, c.last_name AS last_name, sum(b.total) AS Total FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id WHERE b.status != ? AND month(b.created_at) = ? GROUP BY c.id ORDER BY sum(b.total) DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status,$month]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

//   ******************* */ VEHICLE ANALYTIC FUNCTIONS ******************* */

// vehicles that have generated the most income
function most_profitable_vehicles() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.model, v.make, sum(b.total) AS Income FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id WHERE b.status != ? GROUP BY v.id ORDER BY Income DESC LIMIT 5";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// vehicle that has generated the most income OVERALL
function most_profitable_vehicle() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.model, v.make, v.number_plate, sum(b.total) AS Income FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id WHERE b.status != ? GROUP BY v.id ORDER BY Income DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// vehicle that has been booked the most OVERALL
function most_popular_vehicle() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.model, v.make, v.number_plate, count(v.id) AS total FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id WHERE b.status != ? GROUP BY v.id ORDER BY total DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}



// vehicles that have been booked the most
function most_popular_vehicles() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT vb.id, vb.model, vb.make, vb.number_plate, count(vb.id) AS total FROM vehicle_basics vb INNER JOIN bookings b ON vb.id = b.vehicle_id WHERE b.status != ? GROUP BY vb.id ORDER BY count(vb.id) DESC LIMIT 10";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// most popular vehicle categories 
function most_popular_categories(){
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT count(vb.category_id) AS total, cat.name AS category FROM vehicle_basics vb INNER JOIN bookings b ON vb.id = b.vehicle_id INNER JOIN vehicle_categories cat ON vb.category_id = cat.id WHERE b.status != ? GROUP BY vb.category_id ORDER BY count(vb.category_id) DESC";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get daily rate and also vehicle adr and total FOR the year (for now 3 months) in one table
function all_vehicles_totals() {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.id, v.make, v.model, v.number_plate, sum(b.total) AS total, (SELECT daily_rate FROM vehicle_pricing vp WHERE vp.vehicle_id = v.id) AS daily_rate, sum(b.total) / 90 AS ADR FROM bookings b INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE b.status != ? group by v.id;";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

		// **** MONTHLY VEHICLE ANALYTICS ****
// vehicle that has generated the most income IN GIVEN MONTH
function month_most_profitable_vehicle($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.model, v.make, v.number_plate, sum(b.total) AS Income FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id  WHERE month(b.created_at) = ? AND b.status != ? GROUP BY v.id ORDER BY Income DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$month,$status]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// vehicle that has been booked the most IN THE MONTH
function month_most_popular_vehicle($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.model, v.make, v.number_plate, count(v.id) AS total FROM vehicle_basics v INNER JOIN bookings b ON v.id = b.vehicle_id WHERE month(b.created_at) = ? AND b.status != ? GROUP BY v.id ORDER BY total DESC LIMIT 1";
		$stmt = $con->prepare($sql);
		$stmt->execute([$month,$status]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}


// vehicles that have been booked the most IN THE MONTH
function month_most_popular_vehicles($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT vb.id, vb.model, vb.make, vb.number_plate, count(vb.id) AS total FROM vehicle_basics vb INNER JOIN bookings b ON vb.id = b.vehicle_id WHERE month(b.created_at) = ? AND b.status != ? GROUP BY vb.id ORDER BY total DESC LIMIT 5";
		$stmt = $con->prepare($sql);
		$stmt->execute([$month,$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get daily rate and also vehicle adr and total FOR MONTH in one table
function month_vehicles_totals($month) {
	global $con;
	global $res;
	$status = "cancelled";

	try {
		$con->beginTransaction();

		$sql = "SELECT v.id, v.make, v.model, v.number_plate, sum(b.total) AS total, (SELECT daily_rate FROM vehicle_pricing vp WHERE vp.vehicle_id = v.id) AS daily_rate, sum(b.total) / 30 AS ADR FROM bookings b INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE month(b.created_at) = ? AND b.status != ? group by v.id;";
		$stmt = $con->prepare($sql);
		$stmt->execute([$month,$status]);
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}



//   ******************* */ BOOKING ANALYTIC FUNCTIONS ******************* */
function total_booking_count(){
	global $con;
	global $res;

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function completed_booking_count(){
	global $con;
	global $res;
	$status = "complete";

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE b.status = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function cancelled_booking_count(){
	global $con;
	global $res;
	$status = "cancelled";

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE b.status = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function active_booking_count(){
	global $con;
	global $res;
	$status = "active";

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE b.status = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}



function bookings_start_by_day(){
	global $con;
	global $res;
	$status = "cancelled";

	try {
		
		$con->beginTransaction();

		$sql = "SELECT DAYNAME(b.start_date) AS day, count(b.id) AS count FROM bookings b WHERE b.status != 'cancelled' GROUP BY DAYOFWEEK(b.start_date), DAYNAME(b.start_date) ORDER BY DAYOFWEEK(b.start_date)";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}


		// **** MONTHLY BOOKING ANALYTICS ****
function total_month_booking_count($month){
	global $con;
	global $res;

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE  month(b.created_at) = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$month]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get bookings created in a specified month
function bookings_this_month($month) {
	global $con;
	global $res;

	try {

		$con->beginTransaction();

		$sql = "SELECT b.id, c.first_name, c.last_name, v.model, v.make, v.number_plate FROM customer_details c INNER JOIN bookings b ON c.id = b.customer_id INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE month(b.created_at) = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$month]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function cancelled_booking_count_this_month($month){
	global $con;
	global $res;
	$status = "cancelled";

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE b.status = ? AND month(b.created_at) = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status, $month]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function completed_booking_count_this_month($month){
	global $con;
	global $res;
	$status = "complete";

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE b.status = ? AND month(b.created_at) = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status, $month]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function active_booking_count_this_month($month){
	global $con;
	global $res;
	$status = "active";

	try {

		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS count FROM bookings b WHERE b.status = ? AND month(b.created_at) = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status, $month]);
		$res = $stmt->fetch(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}





//   ******************* */ DASHBOARD ANALYTIC FUNCTIONS ******************* */
function income_last_three_months() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();
		$sql = "SELECT monthname(created_at) AS Month, sum(total) AS Total from bookings WHERE datediff(now(), created_at) <= 90 group by Month";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}
// earned revenue this month
function earned_revenue() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT monthname(created_at) AS Month, sum(total) AS total FROM bookings WHERE datediff(now(), created_at) <= 30 GROUP BY Month";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// expected revenue this month
function expected_revenue() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT monthname(created_at) AS Month, sum(total) AS total FROM bookings WHERE datediff(now(), end_date) <= 30 GROUP BY Month";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get the number of bookings in the current month
function booking_count_this_month(){
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS total FROM bookings b  WHERE datediff(now(), created_at) <= 30";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}



// ****************************** NEW ANALYTICS ******************************
// CURRENT MONTH ANALYTICS

function income_this_month(){
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT v.model, v.make, b.monthname(created_at) AS Month, sum(b.total) AS total FROM bookings b INNER JOIN vehicle_basics v ON b.vehicle_id = v.id WHERE datediff(now(), created_at) <= 30 GROUP BY v.id";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}