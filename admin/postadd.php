<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/Category.php';
include_once '../classes/Post.php';
$category = new Category();
$post = new Post();


   if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $post_add = $post->AddPost($_POST, $_FILES);
    }
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10">
                    <span>
                        <?php
                        if (isset($post_add)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $post_add ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card shadow">
                        <h4 class="card-header">Post Add Form</h4>
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" class="form-control" value="<?=Session::get('user_id')?>"/>
                                <div class="mb-3">
                                    <label class="form-label">Post Title</label>
                                    <input type="text" name="post_title" class="form-control" placeholder="Type post title..." />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Select Category</label>
                                    <div>
                                        <select class="form-select" name="category_id" id="">
                                            <option>Select</option>
                                            <?php
                                                $all_category = $category->AllCategory();
                                                if ($all_category) {
                                                    while ($row = mysqli_fetch_assoc($all_category)) {
                                                        ?>
                                                        <option value="<?=$row['category_id']?>"><?=$row['category_name']?></option>
                                                        <?php
                                                    }
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image One</label>
                                    <input type="file" name="image_one" class="form-control" placeholder="" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description One</label>
                                    <textarea id="classic-editor" name="description_one"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Image Two</label>
                                    <input type="file" name="image_two" class="form-control" placeholder="" />
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Description Two</label>
                                    <textarea id="classic-editor_two" name="description_two"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Post Type</label>
                                    <div>
                                        <select class="form-select" name="post_type">
                                            <option>Select</option>
                                            <option value="1">Post</option>
                                            <option value="2">Slider</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Tags</label>
                                    <input type="text" name="tags" class="form-control" placeholder="Post Tags" />
                                </div>


                                <div>
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                            Add Post
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
</div>


<?php
include_once 'inc/footer.php';
?>