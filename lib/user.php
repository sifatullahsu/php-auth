<?php

include_once 'session.php';
include 'lib/DB.php';

class User {

    private $table = 'tbl_user';
    private $db;

    public function __construct() {
        $this->db = new DB;
    }

    public function userRegistration($data) {

        $name       = $data['name'];
        $username   = $data['username'];
        $email      = $data['email'];
        $password   = md5($data['password']);

        if ($name == '' || $username == '' || $email == '' || $password == '') {
            $msg = "<div>Field must not be empty...</div>";
            return $msg;
        }
        if (strlen($username) < 3) {
            $msg = "<div>Username Too Short...</div>";
            return $msg;
        } elseif (preg_match('/[^a-z0-9_-]+/i', $username)) {
            $msg = "<div>Must Containt Alphanumarical, Dashes, Underscore...</div>";
            return $msg;
        }
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            $msg = "<div>The Email Address is Not Valid</div>";
            return $msg;
        }

        $check_username = $this->checkUsername($username);
        $check_email = $this->checkEmail($email);

        if ($check_username == TRUE) {
            $msg = "<div>The Username Already Exist</div>";
            return $msg;
        }
        if ($check_email == TRUE) {
            $msg = "<div>The Email Address Already Exist</div>";
            return $msg;
        }


        $sql = "INSERT INTO $this->table(name, username, email, password) VALUES(?,?,?,?)";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(1, $name);
        $stmt->bindParam(2, $username);
        $stmt->bindParam(3, $email);
        $stmt->bindParam(4, $password);
        $result = $stmt->execute();

        if ($result) {
            $msg = "<div>Registration Successful...</div>";
            return $msg;
        }
    }

    public function userLogin($data) {
        $email      = $data['email'];
        $password   = md5($data['password']);

        if ($email == '' || $password == '') {
            $msg = "<div>Field must not be empty...</div>";
            return $msg;
        }

        if (filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE) {
            $msg = "<div>The Email Address is Not Valid</div>";
            return $msg;
        }

        $sql = "SELECT * FROM $this->table WHERE email = :email && password = :password LIMIT 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);

        if ($result) {
            Session::init();
            Session::set("login", TRUE);
            Session::set("id", $result->id);
            Session::set("name", $result->name);
            Session::set("username", $result->username);
            Session::set("loginMsg", "<div>You are logged in.</div>");

            header("Location: index.php");
        } else {
            $msg = "<div>Data not fount</div>";
            return $msg;
        }
    }

    public function checkEmail($email) {
        $sql = "SELECT email FROM $this->table WHERE email=:email";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function checkUsername($username) {
        $sql = "SELECT username FROM $this->table WHERE username=:username";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':username', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserData() {
        $sql = "SELECT * FROM $this->table";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getUserDataById($id) {
        $sql = "SELECT * FROM $this->table WHERE id=?";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->fetch();
    }

    public function updateUserData($id, $data) {
        $sql = "UPDATE $this->table SET name = ?, username = ?, email = ? WHERE id=?";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam('1', $data['name']);
        $stmt->bindParam('2', $data['username']);
        $stmt->bindParam('3', $data['email']);
        $stmt->bindParam('4', $id);
        $stmt->execute();

        $result = "<div>Data Updated..</div>";
        return $result;
    }

    public function checkOldPassword($id, $old_password) {
        $password = md5($old_password);

        $sql = "SELECT password FROM $this->table WHERE id=? && password=?";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue('1', $id);
        $stmt->bindValue('2', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateUserPassword($id, $data) {
        $old_password = $data['old_pass'];
        $new_password = $data['new_pass'];
        $check_old_password = $this->checkOldPassword($id, $old_password);

        if ($old_password == '' || $new_password == '') {
            $msg = "<div>Field must not be empty..</div>";
            return $msg;
        }

        if (strlen($new_password) < 6) {
            $msg = "<div>Password is too short...</div>";
            return $msg;
        }

        if ($check_old_password == false) {
            $msg = "<div>Incorrect old password..</div>";
            return $msg;
        }

        $new_password_md5 = md5($new_password);

        $sql = "UPDATE $this->table SET password=? WHERE id=?";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindParam('1', $new_password_md5);
        $stmt->bindParam('2', $id);

        $result = $stmt->execute();
        if ($result) {
            $msg = "<div>Password Update Successfully..</div>";
            return $msg;
        } else {
            $msg = "<div>Password Not Updated..</div>";
            return $msg;
        }
    }
}