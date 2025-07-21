<?php
include_once '../lib/Database.php';
include_once '../helpers/Format.php';

class Category
{
    private $db;
    private $format;

    public function __construct()
    {
        $this->db = new Database();
        $this->format = new Format();
    }

    public function AddCategory($category_name)
    {
        $category_name = $this->format->validation($category_name);

        if (empty($category_name)) {
            $msg = "Category Name Field Must Not Be Empty!";
            return $msg;
        } else {
            $select_query = "SELECT * FROM tbl_category WHERE category_name = '$category_name'";
            $select_result = $this->db->select($select_query);

            if ($select_result) {
                $msg = "This Category Already Exists!";
                return $msg;
            } else {
                $insert_query = "INSERT INTO tbl_category(category_name) VALUES ('$category_name')";
                $insert_result = $this->db->insert($insert_query);

                if ($insert_result) {
                    $msg = "Category Inserted Successfully!";
                    return $msg;
                } else {
                    $msg = "Something Wrong! Category is not added.";
                    return $msg;
                }
            }
        }
    }

    public function AllCategory()
    {
        $select_category = "SELECT * FROM tbl_category";
        $all_category = $this->db->select($select_category);

        if ($all_category) {
            return $all_category;
        } else {
            return false;
        }
    }

    public function getEditCategory($id)
    {
        $edit_data = "SELECT * FROM tbl_category WHERE category_id = '$id'";
        $edit_result = $this->db->select($edit_data);
        return $edit_result;
    }

    public function UpdateCategory($category_name, $id)
    {
        $category_name = $this->format->validation($category_name);

        if (empty($category_name)) {
            $msg = "Category Name Field Must Not Be Empty!";
            return $msg;
        } else {
            $select_query = "SELECT * FROM tbl_category WHERE category_name = '$category_name'";
            $select_result = $this->db->select($select_query);

            if ($select_result) {
                $msg = "This Category Already Exists!";
                return $msg;
            } else {
                $update_query = "UPDATE tbl_category SET category_name = '$category_name' WHERE category_id = '$id'";
                $update_result = $this->db->insert($update_query);

                if ($update_result) {
                    header('location:categorylist.php');
                    $msg = "Category Updated Successfully!";
                    return $msg;
                } else {
                    $msg = "Something Wrong! Category is not updated.";
                    return $msg;
                }
            }
        }
    }

    public function DeleteCategory($id)
    {
        $delete_query = "DELETE FROM tbl_category WHERE category_id = '$id'";
        $delete_result = $this->db->delete($delete_query);

        if ($delete_result) {
            $msg = "Category Deleted Successfully!";
            return $msg;
        } else {
            $msg = "Something Wrong! Category is not updated.";
            return $msg;
        }
    }
    public function modelDataCategory()
    {
        $model_data = "SELECT * FROM tbl_category";
        $model_result = $this->db->select($model_data);

        if ($model_result) {
            return $model_result;
        } else {
            return false;
        }
    }
}
