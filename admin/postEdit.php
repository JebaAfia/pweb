<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/Category.php';
include_once '../classes/Post.php';
$category = new Category();
$post = new Post();

if (isset($_GET['editPost'])) {
    $id = base64_decode($_GET['editPost']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $edit_post = $post->EditPost($_POST, $_FILES, $id);
}
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-10">
                    <span>
                        <?php
                        if (isset($edit_post)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $edit_post ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card shadow">
                        <h4 class="card-header">Post Edit Form</h4>
                        <div class="card-body">
                            <?php
                             $getPost = $post->getPostForEdit($id);
                            if ($getPost) {
                                while ($post_row = mysqli_fetch_assoc($getPost)) {
                            ?>
                                    <form action="" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label class="form-label">Post Title</label>
                                            <input type="text" name="post_title" class="form-control" value="<?=$post_row['post_title']?>"/>
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
                                                            <option <?=$post_row['category_id'] == $row['category_id']?'selected': ''?> value="<?= $row['category_id'] ?>"><?= $row['category_name'] ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image One</label>
                                            <input type="file" name="image_one" class="form-control"/>
                                            <img src="<?=$post_row['image_one']?>" class="img-thumbnail" style="width: 200px;" alt="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description One</label>
                                            <textarea id="classic-editor" name="description_one"><?=$post_row['description_one']?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image Two</label>
                                            <input type="file" name="image_two" class="form-control"/>
                                            <img src="<?=$post_row['image_two']?>" class="img-thumbnail" style="width: 200px;" alt="">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Description Two</label>
                                            <textarea id="classic-editor_two" name="description_two"><?=$post_row['description_two']?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Post Type</label>
                                            <div>
                                                <select class="form-select" name="post_type">
                                                    <option>Select</option>
                                                    <?php
                                                        if ($post_row['post_type'] == 1) {
                                                            ?>
                                                            <option selected value="1">Post</option>
                                                            <option value="2">Slider</option>
                                                            <?php
                                                        }else{
                                                            ?>
                                                            <option value="1">Post</option>
                                                            <option selected value="2">Slider</option>
                                                            <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tags</label>
                                            <input type="text" name="tags" class="form-control" value="<?=$post_row['tags']?>"/>
                                        </div>


                                        <div>
                                            <div>
                                                <button type="submit" class="btn btn-danger waves-effect waves-light me-1">
                                                    Edit Post
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                            <?php
                                }
                            }
                            ?>
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