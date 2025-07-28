<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath .'/../lib/Database.php');
include_once ($filepath .'/../helpers/Format.php');

class SiteOption
{
    private $db;
    private $format;

    public function __construct()
    {
        $this->db = new Database();
        $this->format = new Format();
    }

    public function allSocial()
    {
        $select_query = "SELECT * FROM tbl_social WHERE social_id = '1'";
        $select_result = $this->db->select($select_query);
        return $select_result;
    }

    public function updateLinks($data)
    {
        $twiter = $data['twiter'];
        $facebook = $data['facebook'];
        $instagram = $data['instagram'];
        $youtube = $data['youtube'];

        $update_query = "UPDATE tbl_social SET twiter = '$twiter', facebook = '$facebook', instagram = '$instagram', youtube = '$youtube'";
        $update_result = $this->db->update($update_query);

        if ($update_result) {
            $msg = "Link Update Successfully!";
            return $msg;
        }else {
            $msg = "Link is not updated!";
            return $msg;
        }
    }

    //site logo
    public function siteLogo()
    {
        $select_query = "SELECT * FROM tbl_logo WHERE logo_id = '1'";
        $logo = $this->db->select($select_query);
        return $logo;
    }

    public function updateLogo($data)
    {
        $logo = $this->format->validation($data['logo']);

        $update_logo = "UPDATE tbl_logo SET logo_name = '$logo' WHERE logo_id = '1'";
        $logo_result = $this->db->update($update_logo);
        if ($logo_result) {
            $msg = "Logo Update Successfully!";
            return $msg;
        }else {
            $msg = "Logo is not updated!";
            return $msg;
        }
    }

   
}
