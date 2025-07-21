<?php
 include_once '../lib/Database.php';
 include_once '../helpers/Format.php';

 class Post{
    private $db;
    private $format;

    public function __construct()
    {
        $this->db = new Database();
        $this->format = new Format();
    }

    public function AddPost($data, $file){
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
        $unique_image = substr(md5(time()),0,10).'.'.$file_extension;
        $upload_image = "upload/".$unique_image;

        //for image_two
        $permited_two = array('jpg', 'jpeg', 'png', 'gif');
        $file_name_two = $file['image_two']['name'];
        $file_size_two = $file['image_two']['size'];
        $file_temp_two = $file['image_two']['tmp_name'];

        $division_two = explode('.', $file_name_two);
        $file_extension_two = strtolower(end($division_two));
        $unique_image_two = substr(md5(rand().time()),0,10).'.'.$file_extension_two;
        $upload_image_two = "upload/".$unique_image_two;

        if (empty($post_title) || empty($description_one) || empty($description_two) || empty($post_type) || empty($tags)) {
            $msg = "Fields Must Not Be Empty!";
            return $msg;
        }elseif ($file_size > 1048567) {
            $msg = "File Size Must Be Less Than 1 MB!";
            return $msg;
        }elseif ($file_size_two > 1048567) {
            $msg = "File Size Must Be Less Than 1 MB!";
            return $msg;
        }elseif (in_array($file_extension, $permited) == false) {
            $msg = "You Can Upload Only:-". implode(',', $permited);
            return $msg;
        }elseif (in_array($file_extension_two, $permited_two) == false) {
            $msg = "You Can Upload Only:-". implode(',', $permited_two);
            return $msg;
        }else {
            move_uploaded_file($file_temp, $upload_image);
            move_uploaded_file($file_temp_two, $upload_image_two);

            $query = "INSERT INTO `tbl_post`(`post_title`, `category_id`, `image_one`, `description_one`, `image_two`, `description_two`, `post_type`, `tags`) 
            VALUES ('$post_title', '$category_id', '$upload_image', '$description_one', '$upload_image_two', '$description_two', '$post_type', '$tags')";

            $result = $this->db->insert($query);
            if ($result) {
                $msg = "Post Inserted Successfully!";
                return $msg;
            }else{
                $msg = "Something Wrong! Post is not added.";
                return $msg;
            }
        }
    }

    public function AllPost()
    {
        $select_post = "SELECT tbl_post.*, tbl_category.category_name FROM tbl_post INNER JOIN tbl_category ON tbl_post.category_id = tbl_category.category_id";
        $all_post = $this->db->select($select_post);

        if ($all_post) {
            return $all_post;
        } else {
            return false;
        }
    }

    public function modelData(){
        $model_data = "SELECT tbl_post.*, tbl_category.category_name FROM tbl_post INNER JOIN tbl_category ON tbl_post.category_id = tbl_category.category_id";
        $model_result = $this->db->select($model_data);
        return $model_result;
    
    }
    public function activePost($active_id){
         $active_query = "UPDATE tbl_post SET status = '0' WHERE post_id = '$active_id'";
         $active_result = $this->db->update($active_query);
         if ($active_result) {
            $msg = "Post Deactive!";
            return $msg;
         }
    }
    public function deactivePost($deactive_id){
         $deactive_query = "UPDATE tbl_post SET status = '1' WHERE post_id = '$deactive_id'";
         $deactive_result = $this->db->update($deactive_query);
         if ($deactive_result) {
            $msg = "Post Active!";
            return $msg;
         }
    }
 }

?>