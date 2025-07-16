<?php
include_once '../lib/Session.php';
Session::loginCheck();

include_once '../lib/Database.php';
include_once '../helpers/Format.php';

    class AdminLogin{
        private $db;
        private $format;

        public function __construct()
        {
            $this->db = new Database();
            $this->format = new Format();
        }

        public function LoginUser($email, $password){
            $email = $this->format->validation($email);
            $password = $this->format->validation($password);

            if (empty($email) || empty($password)) {
                $error = "Filds Must Not Be Empty!";
                return $error;
            }else {
                $select = "SELECT * FROM tbl_user WHERE email='$email' AND password = '$password'";
                $result = $this->db->select($select);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);

                    if ($row['v_status'] == 1) {
                        Session::set('login', true);
                        Session::set('user_name', $row['user_name']);
                        header('location:index.php');
                    }else {
                        $error = "Please Fisrt Varify Your Email!";
                        return $error;
                    }

                }else {
                    $error = "Invalid Email Or Password!";
                    return $error;
                }
            }

        }
    }
?>