<?php
    include_once '../lib/Database.php';
    include_once '../helpers/Format.php';

    include_once '../PHPmailer/PHPMailer.php';
    include_once '../PHPmailer/SMTP.php';
    include_once '../PHPmailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Resendemail{
        private $db;
        private $format;

        public function __construct()
        {
            $this->db = new Database();
            $this->format = new Format();

        }

        public function resendEmail($email){
            function resend_email_varify($name, $email, $v_token){
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
                $mail->Subject = "Email Varification From Jeba";

                $email_template = "
                    <h2> You have register with jeba</h2>
                    <h5>Verify your email address to login. Please click the link below</h5>
                    <a href='http://localhost/pweb/admin/verify-email.php?token=$v_token'>Click Here</a>
                ";

                $mail->Body = $email_template;
                $mail->send();
                // echo "Email has been sent";
            }

            $email = $this->format->validation($email);
            $email = mysqli_real_escape_string($this->db->link, $email);

            if (empty($email)) {
                $error = "Email fild must not be empty!";
                return $error;
            }else {
                $checkEmail = "SELECT * FROM tbl_user WHERE email = '$email'";
                $emailResult = $this->db->select($checkEmail);

                if ($emailResult) {
                    $row = mysqli_fetch_assoc($emailResult);
                    // print_r($row);
                    if ($row['v_status'] == 0) {

                        $name = $row['user_name'];
                        $email = $row['email'];
                        $v_token = $row['v_token'];

                        resend_email_varify($name, $email, $v_token);
                        $success = "Varification email link has been send in your email.";
                        return $success;
                    }else {
                        $error = "Email already varified. Please Log In.";
                        return $error;
                    }
                }else {
                    $error = "This Email Is Not Registered. Please Register First.";
                    return $error;
                }
            }
        }
    }

?>