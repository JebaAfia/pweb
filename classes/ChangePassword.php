<?php
    include_once '../lib/Database.php';
    include_once '../helpers/Format.php';

    class ChangePassword{
        private $db;
        private $format;

        public function __construct()
        {
            $this->db = new Database();
            $this->format = new Format();

        }

        public function ChangePassword($data){
            $email = $this->format->validation($data['email']);
            $newPassword = $this->format->validation($data['new-password']);
            $confirmPassword = $this->format->validation($data['confirm-password']);
            $token = $this->format->validation($data['token']);

            if (!empty($token)) {
                if (!empty($email) || !empty($newPassword) || !empty($confirmPassword)){
                    $token_query = "SELECT v_token FROM tbl_user WHERE v_token = '$token'";
                    $token_result = $this->db->select($token_query);

                    if ($token_result) {
                        
                        if ($newPassword == $confirmPassword) {
                            $update_pass = "UPDATE tbl_user SET password = '$newPassword' WHERE v_token = '$token'";
                            $update_result = $this->db->update($update_pass);

                            if ($update_result) {

                                $new_token = md5(rand());
                                $update_token = "UPDATE tbl_user SET v_token = '$new_token' WHERE v_token = '$token'";
                                $result = $this->db->update($update_token);

                                $success = "Password Changed Successfully!";
                                return $success;
                            }else {
                                $error = "Password Not Changed";
                                return $error;
                            }
                        }else {
                            $error = "Password Not Match";
                            return $error;
                        }

                    }else{
                        $error = "Invalid Token";
                        return $error;
                    }

                }else {
                    $error = "Field Must Not Be Empty!";
                    return $error;
                }
            }else{
                $error = "Token is not available!";
                return $error;
            }

        }
    }

?>