<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath. '/../lib/Database.php');
include_once ($filepath. '/../helpers/Format.php');

    class Comment{
        private $db;
        private $format;

        public function __construct()
        {
            $this->db = new Database();
            $this->format = new Format();
        }

        public function addComment($data){
        $user_id = $this->format->validation($data['user_id']);
        $post_id = $this->format->validation($data['post_id']);
        $name = $this->format->validation($data['name']);
        $email = $this->format->validation($data['email']);
        $website = $this->format->validation($data['website']);
        $message = $this->format->validation($data['message']);

        if (
            empty($name) || 
            empty($email) || 
            empty($message)
        ) {
            $msg = "Fields Must Not Be Empty!";
            return $msg;
        }
        $insert_comment = "INSERT INTO `tbl_comment`(`user_id`, `post_id`, `name`, `email`, `website`, `message`) 
                        VALUES ('$user_id', '$post_id', '$name', '$email', '$website', '$message')";
        // print_r($insert_comment);
        $result = $this->db->insert($insert_comment);

        if ($result) {
            $msg = "Comment Success!";
            return $msg;
        } else {
            $msg = "Something Wrong! Comment is not added.";
            return $msg;
        }

        }

        public function allComment($id){
            $select_comment = "SELECT tbl_comment.*, tbl_post.post_id, tbl_user.user_name, tbl_user.image FROM tbl_comment
            INNER JOIN tbl_post ON tbl_comment.post_id = tbl_post.post_id 
            INNER JOIN tbl_user ON tbl_comment.user_id = tbl_user.user_id
            WHERE tbl_comment.post_id = '$id' AND tbl_comment.status = '1'";
            $result = $this->db->select($select_comment);
            return $result;
        }

        public function adminComment($id)
        {
            $admin_comment = "SELECT tbl_comment.*, tbl_user.user_id FROM tbl_comment
            INNER JOIN tbl_user ON tbl_comment.user_id = tbl_user.user_id WHERE tbl_comment.user_id = '$id'";
            $result = $this->db->select($admin_comment);
            return $result;
        }

        public function activePost($active_id)
        {
            $active_query = "UPDATE tbl_comment SET status = '0' WHERE comment_id = '$active_id'";
            $active_result = $this->db->update($active_query);
            if ($active_result) {
                $msg = "Comment Deactive!";
                return $msg;
            }
        }
        public function deactivePost($deactive_id)
        {
            $deactive_query = "UPDATE tbl_comment SET status = '1' WHERE comment_id = '$deactive_id'";
            $deactive_result = $this->db->update($deactive_query);
            if ($deactive_result) {
                $msg = "Comment Active!";
                return $msg;
            }
        }

        //Select comment for update and reply
        public function selectComment($id)
        {
            $select_comment = "SELECT * FROM tbl_comment WHERE comment_id = '$id'";
            $result = $this->db->select($select_comment);
            return $result;
        }

        //admin send reply
        public function AddReply($reply, $id)
        {
            $reply = $this->format->validation($reply);
            $update_date = date("M d, Y");
            if (empty($reply)) {
                $msg = "Reply Feild must be required";
                return $msg;
            }
            $update_reply = "UPDATE tbl_comment SET admin_reply = '$reply', update_date = '$update_date' WHERE comment_id = '$id'";
            $result = $this->db->update($update_reply);
            if ($result) {
                $msg = "Replied Successfully!";
                return $msg;
            }else {
                $msg = "Reply Failed!";
                return $msg;
            }
        }

        //delete comment

        public function deleteComment($id)
        {
            $delete_comment = "DELETE FROM tbl_comment WHERE comment_id = '$id'";
            $delete = $this->db->delete($delete_comment);
            if ($delete) {
                $msg = "Comment deleted successfully!";
                return $msg;
            }else {
                $msg = "Comment is not deleted yet!";
                return $msg;
            }
        }
    }
?>