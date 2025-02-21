<?php
function all_organisations() {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT * FROM organisations";
		$stmt = $con->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}
	return $res;
}

function get_organisation($organisation_id) {
	global $con;
	global $res;

	try {
		$con->beginTransaction();

		$sql = "SELECT name, email, contact_name, contact_no, kra_pin, certificate_of_inc FROM organisation_details WHERE id = ?";

		$stmt = $con->prepare($sql);
		$stmt->execute([$organisation_id]);
		$res = $stmt->fetch();

		$con->commit();
	} catch (Exception $e) {
		$con->rollback();
	}
	return $res;
}

function save_organisation($name, $email, $contact_name, $country, $tel, $kra_pin) {
	global $con;
	global $res;

	try {
		$con->beginTransaction();
		$sql = "INSERT INTO organisation_details (name, email, contact_name, country, contact_no, kra_pin) VALUES (?,?,?,?,?,?)";

		$stmt = $con->prepare($sql);
		if ($stmt->execute([$name, $email, $contact_name, $country, $tel, $kra_pin])) {
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

function update_organisation($name, $email, $contact_name, $contact_no, $kra_pin) {

}
?>