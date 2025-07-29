<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath. '/../lib/Database.php');
include_once ($filepath. '/../helpers/Format.php');

class Post
{
    private $db;
    private $format;

    public function __construct()
    {
        $this->db = new Database();
        $this->format = new Format();
    }

    public function AddPost($data, $file)
    {   
        $user_id = $this->format->validation($data['user_id']);
        $post_title = $this->format->validation($data['post_title']);
        $category_id = $this->format->validation($data['category_id']);
        $description_one = $this->format->validation($data['description_one']);
        $description_two = $this->format->validation($data['description_two']);
        $post_type = $this->format->validation($data['post_type']);
        $tags = $this->format->validation($data['tags']);

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image_one']['name'];
        $file_size = $file['image_one']['size'];
        $file_temp = $file['image_one']['tmp_name'];

        $division = explode('.', $file_name); // rim.jh.ijm.jpg -> ['rim.jh.im', 'jpg']
        $file_extension = strtolower(end($division)); // jpg
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_extension;
        $upload_image = "upload/" . $unique_image;

        //for image_two
        $permited_two = array('jpg', 'jpeg', 'png', 'gif');
        $file_name_two = $file['image_two']['name'];
        $file_size_two = $file['image_two']['size'];
        $file_temp_two = $file['image_two']['tmp_name'];

        $division_two = explode('.', $file_name_two);
        $file_extension_two = strtolower(end($division_two));
        $unique_image_two = substr(md5(rand() . time()), 0, 10) . '.' . $file_extension_two;
        $upload_image_two = "upload/" . $unique_image_two;

        if (
            empty($post_title) || 
            empty($file_name) || 
            empty($file_name_two) || 
            empty($description_one) || 
            empty($description_two) || 
            empty($post_type) || 
            empty($tags)
        ) {
            $msg = "Fields Must Not Be Empty!";
            return $msg;
        } 
        if ($file_size > 1048567 || $file_size_two > 1048567) {
            $msg = "File Size Must Be Less Than 1 MB!";
            return $msg;
        } 
        if (!in_array($file_extension, $permited)) {
            $msg = "You Can Upload Only:-" . implode(',', $permited);
            return $msg;
        } 
        if (!in_array($file_extension_two, $permited_two)) {
            $msg = "You Can Upload Only:-" . implode(',', $permited_two);
            return $msg;
        }
        move_uploaded_file($file_temp, $upload_image);
        move_uploaded_file($file_temp_two, $upload_image_two);

        $query = "INSERT INTO `tbl_post`(`user_id`, `post_title`, `category_id`, `image_one`, `description_one`, `image_two`, `description_two`, `post_type`, `tags`) 
        VALUES ('$user_id', '$post_title', '$category_id', '$upload_image', '$description_one', '$upload_image_two', '$description_two', '$post_type', '$tags')";

        $result = $this->db->insert($query);
        if ($result) {
            $msg = "Post Inserted Successfully!";
            return $msg;
        } else {
            $msg = "Something Wrong! Post is not added.";
            return $msg;
        }
    }

    public function AllPost($id)
    {
        $select_post = "SELECT tbl_post.*, tbl_category.category_name, tbl_user.user_id FROM tbl_post 
        INNER JOIN tbl_category ON tbl_post.category_id = tbl_category.category_id 
        INNER JOIN tbl_user ON tbl_post.user_id = tbl_user.user_id WHERE tbl_user.user_id = '$id'";
        $all_post = $this->db->select($select_post);

        if ($all_post) {
            return $all_post;
        } else {
            return false;
        }
    }

    public function modelData()
    {
        $model_data = "SELECT tbl_post.*, tbl_category.category_name FROM tbl_post INNER JOIN tbl_category ON tbl_post.category_id = tbl_category.category_id";
        $model_result = $this->db->select($model_data);
        return $model_result;
    }
    //post for edit
    public function getPostForEdit($id)
    {
        $get_query = "SELECT * FROM tbl_post WHERE post_id = '$id'";
        $get_result = $this->db->select($get_query);
        return $get_result;
    }
    public function EditPost($data, $file, $id)
    { 
        // print_r($data);
        $post_title = $this->format->validation($data['post_title']);
        $category_id = $this->format->validation($data['category_id']);
        $description_one = $this->format->validation($data['description_one']);
        $description_two = $this->format->validation($data['description_two']);
        $post_type = $this->format->validation($data['post_type']);
        $tags = $this->format->validation($data['tags']);

        $permited = array('jpg', 'jpeg', 'png', 'gif');
        $file_name = $file['image_one']['name'];
        $file_size = $file['image_one']['size'];
        $file_temp = $file['image_one']['tmp_name'];

        $division = explode('.', $file_name); // rim.jh.ijm.jpg -> ['rim.jh.im', 'jpg']
        $file_extension = strtolower(end($division)); // jpg
        $unique_image = substr(md5(time()), 0, 10) . '.' . $file_extension;
        $upload_image = "upload/" . $unique_image;

        $permited_two = array('jpg', 'jpeg', 'png', 'gif');
        $file_name_two = $file['image_two']['name'];
        $file_size_two = $file['image_two']['size'];
        $file_temp_two = $file['image_two']['tmp_name'];

        $division_two = explode('.', $file_name_two);
        $file_extension_two = strtolower(end($division_two));
        $unique_image_two = substr(md5(rand() . time()), 0, 10) . '.' . $file_extension_two;
        $upload_image_two = "upload/" . $unique_image_two;

        if (empty($post_title) || empty($description_one) || empty($description_two) || empty($post_type) || empty($tags)) {
            $msg = "Fields Must Not Be Empty!";
            return $msg;
        } else {
            if (!empty($file_name) || !empty($file_name_two)) {
                if ($file_size > 1048567 || $file_size_two > 1048567) {
                    $msg = "File Size Must Be Less Than 1 MB!";
                    return $msg;
                } 
                
                
                if(!empty($file_extension)){
                    if (!in_array($file_extension, $permited)) {
                        $msg = "You Can Upload Only Image:-" . implode(',', $permited);
                        return $msg;
                    } 
                } 

                if(!empty($file_extension_two)){

                    if (!in_array($file_extension_two, $permited_two)) {
                        $msg = "You Can Upload Only Image:-" . implode(',', $permited_two);
                        return $msg;
                    } 
                }


                move_uploaded_file($file_temp, $upload_image);
                move_uploaded_file($file_temp_two, $upload_image_two);

                $query = "UPDATE `tbl_post` SET `post_title`='$post_title',`category_id`='$category_id',`image_one`='$upload_image',`description_one`='$description_one',
                `image_two`='$upload_image_two',`description_two`='$description_two',`post_type`='$post_type',`tags`='$tags' WHERE post_id = '$id'";

                $result = $this->db->insert($query);
                if ($result) {
                    $msg = "Post Updated Successfully!";
                    return $msg;
                } else {
                    $msg = "Something Wrong! Post is not updated.";
                    return $msg;
                }
                
            }else {
                 $query = "UPDATE `tbl_post` SET `post_title`='$post_title',`category_id`='$category_id',`description_one`='$description_one',
                `description_two`='$description_two',`post_type`='$post_type',`tags`='$tags' WHERE post_id = '$id'";

                $result = $this->db->insert($query);
                if ($result) {
                    $msg = "Post Updated Successfully!";
                    return $msg;
                } else {
                    $msg = "Something Wrong! Post is not updated.";
                    return $msg;
                }
            }
        }
    }
    public function activePost($active_id)
    {
        $active_query = "UPDATE tbl_post SET status = '0' WHERE post_id = '$active_id'";
        $active_result = $this->db->update($active_query);
        if ($active_result) {
            $msg = "Post Deactive!";
            return $msg;
        }
    }
    public function deactivePost($deactive_id)
    {
        $deactive_query = "UPDATE tbl_post SET status = '1' WHERE post_id = '$deactive_id'";
        $deactive_result = $this->db->update($deactive_query);
        if ($deactive_result) {
            $msg = "Post Active!";
            return $msg;
        }
    }
    public function DeletePost($id)
    {
        $image_query = "SELECT * FROM tbl_post WHERE post_id = '$id'";
        $image_result = $this->db->select($image_query);
        if ($image_result) {
            while ($image = mysqli_fetch_assoc($image_result)) {
                $imageOne = $image['image_one'];
                unlink($imageOne);

                $imageTwo = $image['image_two'];
                unlink($imageTwo);
            }
        }
        $delete_query = "DELETE FROM tbl_post WHERE post_id = '$id'";
        $delete_result = $this->db->delete($delete_query);

        if ($delete_result) {
            $msg = "Post Deleted Successfully!";
            return $msg;
        } else {
            $msg = "Something Wrong! Post is not updated.";
            return $msg;
        }
    }

    //frontend Functions
    public function latestPost(){
        $post_query = "SELECT tbl_post.*, tbl_user.user_name, tbl_user.image FROM tbl_post 
        INNER JOIN tbl_user ON tbl_post.user_id = tbl_user.user_id 
        WHERE tbl_post.status = '1' ORDER BY tbl_post.post_id DESC";

        $post_result = $this->db->select($post_query);
        return $post_result;
    }

    public function singlePost($id){
        $single_query = "SELECT tbl_post.*, tbl_user.user_name, tbl_user.image, tbl_category.category_name FROM tbl_post 
        INNER JOIN tbl_user ON tbl_post.user_id = tbl_user.user_id 
        INNER JOIN tbl_category ON tbl_post.category_id = tbl_category.category_id
        WHERE tbl_post.post_id = '$id'";

        $single_result = $this->db->select($single_query);
        return $single_result;
    }

    public function showPopularPost()
    {
        $popular_post = "SELECT * FROM tbl_post ORDER BY post_id DESC LIMIT 3";
        $result = $this->db->select($popular_post);
        return $result;
    }

    public function categoryNumber($id)
    {
        $category_query = "SELECT * FROM tbl_post WHERE tbl_post.category_id = '$id'";
        $category_result = $this->db->select($category_query);
        return $category_result;
    }

    //slider post
    public function sliderPost()
    {
        $slider_query = "SELECT tbl_post.*, tbl_category.category_name, tbl_user.image, tbl_user.user_name FROM tbl_post 
        INNER JOIN tbl_category ON tbl_post.category_id = tbl_category.category_id 
        INNER JOIN tbl_user ON tbl_post.user_id = tbl_user.user_id 
        WHERE post_type = 2 AND status = 1";

        $slider_result = $this->db->select($slider_query);
        return $slider_result;
    }
}
