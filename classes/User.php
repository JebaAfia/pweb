<?php
include_once '../lib/Database.php';
include_once '../helpers/Format.php';

class User
{
    private $db;
    private $format;

    public function __construct()
    {
        $this->db = new Database();
        $this->format = new Format();
    }

    public function userInfo($id){
        $user_query = "SELECT * FROM tbl_user WHERE user_id = '$id'";
        $result = $this->db->select($user_query);
        return $result;
    }

    public function userUpdate($data, $file, $id){
        $user_name = $this->format->validation($data['user_name']);

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image']['name'];
        $file_size = $file['image']['size'];
        $file_temp = $file['image']['tmp_name'];

        $division = explode('.', $file_name); 
        $file_extension = strtolower(end($division)); 
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_extension;
        $upload_image = "upload/" . $unique_image;

        if (empty($user_name)) {
            $msg = "User Name Feild Must Not Be Empty";
            return $msg;
        }else {
            if (!empty($file_name)) {
                if ($file_size > 1048567) {
                    $msg = "File Size Must Be Less Than 1 MB!";
                    return $msg;
                } 
                if(!empty($file_extension)){
                    if (!in_array($file_extension, $permited)) {
                        $msg = "You Can Upload Only Image:-" . implode(',', $permited);
                        return $msg;
                    } 
                } 
                move_uploaded_file($file_temp, $upload_image);

                $query = "UPDATE tbl_user SET user_name = '$user_name', image = '$upload_image' WHERE user_id = '$id'";
                $result = $this->db->insert($query);
                if ($result) {
                    $msg = "User Profile Updated Successfully!";
                    return $msg;
                } else {
                    $msg = "Something Wrong! User profile is not updated.";
                    return $msg;
                }
            }else {
                $query = "UPDATE tbl_user SET user_name = '$user_name' WHERE user_id = '$id'";
                $result = $this->db->insert($query);
                if ($result) {
                    $msg = "User Profile Updated Successfully!";
                    return $msg;
                } else {
                    $msg = "Something Wrong! User profile is not updated.";
                    return $msg;
                }
            }
        }
    }
}