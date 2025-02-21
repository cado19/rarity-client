<?php
// get all partners
function all_partners() {
	global $con;
	global $res;
	$status = "false";

	try {

		$con->beginTransaction();

		$sql = "SELECT * FROM partners WHERE deleted = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

// get single partner
function get_partner($partner_id) {
	global $con;
	global $res;

	try {

		$con->beginTransaction();

		$sql = "SELECT * FROM partners WHERE id = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$partner_id]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function partners_for_vehicle() {
	global $con;
	global $res;
	$status = "false";

	try {

		$con->beginTransaction();

		$sql = "SELECT id, name FROM partners WHERE deleted = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$status]);
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

function save_partner($name, $email, $tel) {
	global $con;
	global $res;

	try {

		$con->beginTransaction();

		$sql = "INSERT INTO partners (name, email, phone_no) VALUES (?,?,?)";

		$stmt = $con->prepare($sql);
		if ($stmt->execute([$name, $email, $tel])) {
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
// update partner
function update_partner($name, $email, $tel, $id) {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "UPDATE partners SET name = ?, email = ?, phone_no = ? WHERE id = ?";
		$stmt = $con->prepare($sql);

		if ($stmt->execute([$name, $email, $tel, $id])) {
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

// partner vehicle count
function partner_vehicle_count($partner_id) {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT count(v.id) AS vehicle_count FROM vehicle_basics v INNER JOIN partners p on v.partner_id = p.id WHERE v.partner_id = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$partner_id]);
		$res = $stmt->fetch();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}

//partner booking count
function partner_booking_count($partner_id) {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT count(b.id) AS booking_count FROM bookings b INNER JOIN vehicle_basics v ON v.id = b.vehicle_id WHERE v.partner_id = ?";
		$stmt = $con->prepare($sql);
		$stmt->execute([$partner_id]);
		$res = $stmt->fetch();
	} catch (Exception $e) {
		$con->rollback();
	}

	return $res;
}
?>