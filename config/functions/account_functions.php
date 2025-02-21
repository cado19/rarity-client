<?php
function unique_email($email)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT id FROM accounts WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
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

// get email that will be used for password reset and role_id so as to know whether it's driver or agent password being reset
function get_email($email)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT id, role_id FROM accounts WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $res = $stmt->fetch();
        } else {
            // if email is not in accounts table search for it in drivers table
            $sql1  = "SELECT id, role_id FROM drivers WHERE email = ?";
            $stmt1 = $con->prepare($sql1);
            $stmt1->execute([$email]);
            if ($stmt1->rowCount() == 1) {
                $res = $stmt1->fetch();
            } else {
                $res = "No such person";
            }
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

function create_account($name, $email, $password)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();

        $sql  = "INSERT INTO accounts (name, email, password) VALUES (?,?,?)";
        $stmt = $con->prepare($sql);
        if ($stmt->execute([$name, $email, $password])) {
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

// fetch account from accounts table or driver from drivers table 
function fetch_account($email)
{
    global $con;
    global $res;

    try {

        $con->beginTransaction();

        $sql  = "SELECT * FROM accounts WHERE email = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {
            $res = $stmt->fetch();
        } else {
            // if email is not in accounts table search for it in drivers table
            $sql1  = "SELECT * FROM drivers WHERE email = ?";
            $stmt1 = $con->prepare($sql1);
            $stmt1->execute([$email]);
            if ($stmt1->rowCount() == 1) {
                $res = $stmt1->fetch();
            } else {
                $res = ["No such person"];
            }
        }

        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

// get role id from account id
function get_role_id($account_id)
{
    global $con;
    global $res;

    try {
        $con->beginTransaction();
        $sql  = "SELECT role_id FROM accounts WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->execute([$account_id]);
        $res = $stmt->fetch();
        $con->commit();
    } catch (Exception $e) {
        $con->rollback();
    }

    return $res;
}

 
