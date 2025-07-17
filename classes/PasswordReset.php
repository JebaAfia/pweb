<?php
    include_once '../lib/Database.php';
    include_once '../helpers/Format.php';

    include_once '../PHPmailer/PHPMailer.php';
    include_once '../PHPmailer/SMTP.php';
    include_once '../PHPmailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    class PasswordReset{
        private $db;
        private $format;

        public function __construct()
        {
            $this->db = new Database();
            $this->format = new Format();

        }

        public function PasswordReset($email){

            function send_password_reset($name, $email, $v_token){
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth   = false;

                $mail->Host = 'localhost';
                $mail->Username = 'example@example.com';
                $mail->Password = null;

                $mail->SMTPSecure = false;
                $mail->Port = 1025;

                $mail->setFrom('example@gamil.com', $name);
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = "Password Varification";

                $email_template = "
                    <h2> Reset Your Password</h2>
                    <h5>Verify your email address to reset your password. Please click the link below</h5>
                    <a href='http://localhost/pweb/admin/password-change.php?token=$v_token&email=$email'>Click Here</a>
                ";

                $mail->Body = $email_template;
                $mail->send();
                // echo "Email has been sent";
            }

            $email = $this->format->validation($email);
            $v_token = md5(rand());

            if (empty($email)) {
                $error = "Email Feild Must Not Be Empty!";
                return $error;
            }else {
                $check_email = "SELECT * FROM tbl_user WHERE email = '$email'";
                $email_result = $this->db->select($check_email);

                if ($email_result) {
                    $row = mysqli_fetch_assoc($email_result);
                    $name = $row['user_name'];
                    $email = $row['email'];
                    $query = "UPDATE tbl_user SET v_token = '$v_token' WHERE email = '$email' LIMIT 1";

                    $update_token = $this->db->update($query);

                    if ($update_token) {
                        send_password_reset($name, $email, $v_token);
                        $success = "Password reset email send in your email!";
                        return $success;

                    }else {
                        $error = "Something Wrong! Token Is Not Updated.";
                        return $error;
                    }

                }else {
                    $error = "Email Not Found!";
                    return $error;
                }
            }
        }

    }
?>