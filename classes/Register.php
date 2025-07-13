<?php
    
    include_once '../lib/Database.php';
    include_once '../helpers/Format.php';

    include_once '../PHPmailer/PHPMailer.php';
    include_once '../PHPmailer/SMTP.php';
    include_once '../PHPmailer/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Register{
        public $db;
        public $format;

        public function __construct()
        {
            $this->db = new Database();
            $this->format = new Format();
        }

        public function AddUser($data){

            function sendemail_verify($name, $email, $v_token){
                $mail = new PHPMailer(true);
                $mail->isSMTP();
                $mail->SMTPAuth   = true;

                $mail->Host = 'smtp.gamil.com';
                $mail->Username = 'afiakhatun.npi@gamil.com';
                $mail->Password = '22091671r';

                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('afiakhatun.npi@gamil.com', $name);
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

            $name = $this->format->validation($data['name']);
            $phone = $this->format->validation($data['phone']);
            $email = $this->format->validation($data['email']);
            $password = $this->format->validation($data['password']);
            $v_token = md5(rand());

            if (empty($name) || empty($phone) || empty($email) || empty($password)) {
                $error = "Fild Must Not Be Empty";
                return $error;
            }else {
                $e_query = "SELECT * FROM tbl_user WHERE email = '$email'";
                $check_email = $this->db->select($e_query);

                if ($check_email > 0) {
                    $error = "This Email Is Already Exists";
                    return $error;
                    header("location:register.php");
                }else {
                    $insert_query = "INSERT INTO tbl_user(name, email, phone, password, v_token,) VALUES ('$name', '$email', '$phone', '$password', '$v_token')";

                    $insert_row = $this->db->insert($insert_query);

                    if ($insert_row) {
                        sendemail_verify($name, $email, $v_token);
                        $success = "Registration Successfull. Please check your inbox for verify email.";

                        return $success;
                    }else {
                        $error = "Registration Failed";
                        return $error;
                    }
                }
            }

        }
    }
?>