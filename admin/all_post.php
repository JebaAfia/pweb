<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/Post.php';
include_once '../helpers/Format.php';
$post = new Post();
$format = new Format();

$all_post = $post->AllPost();

//active
if (isset($_GET['active'])) {
    $active_id = $_GET['active'];
    $active = $post->activePost($active_id);
}
//deactive
if (isset($_GET['deactive'])) {
    $deactive_id = $_GET['deactive'];
    $deactive = $post->deactivePost($deactive_id);
}

if (isset($_GET['deletePost'])) {
    $id = base64_decode($_GET['deletePost']);
    $deletePost = $post->DeletePost($id);
}
?>

<?php
if (!isset($_GET['id'])) {
    echo "<meta http-equiv='refresh' content='0;URL=?id=ahr'/>";
}
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <span>
                        <?php
                        if (isset($active)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $active ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <span>
                        <?php
                        if (isset($deactive)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $deactive ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <span>
                        <?php
                        if (isset($deletePost)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $deletePost ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card">
                        <h4 class="card-header">All Post</h4>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Post Title</th>
                                        <th>Category</th>
                                        <th>Image One</th>
                                        <th>Description One</th>
                                        <th>Image Two</th>
                                        <th>Description Two</th>
                                        <th>Post Type</th>
                                        <th>Tags</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    if ($all_post) {
                                        $i = 0;
                                        while ($row = mysqli_fetch_assoc($all_post)) {
                                            $i++;
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['post_title'] ?></td>
                                                <td><?= $row['category_name'] ?></td>
                                                <td><img src="<?= $row['image_one'] ?>" style="width: 70px;" alt=""></td>
                                                <td><?= $format->textShorten($row['description_one'], 5) ?></td>
                                                <td><img src="<?= $row['image_two'] ?>" style="width: 70px;" alt=""></td>
                                                <td><?= $format->textShorten($row['description_two'], 5) ?></td>
                                                <td><?php
                                                    if ($row['post_type'] == 1) {
                                                        echo 'Post';
                                                    } else {
                                                        echo 'Slider';
                                                    }
                                                    ?></td>
                                                <td><?= $format->textShorten($row['tags'], 5) ?></td>
                                                <td>
                                                    <a href="" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                                    <a href="" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                                    <a href="" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#myModal-<?=$row['post_id']?>"><i class="fas fa-eye"></i></a>
                                                    <?php
                                                        if ($row['status'] == 0) {
                                                            ?>
                                                            <a href="?deactive=<?=$row['post_id']?>" class="btn btn-sm btn-warning"><i class="fas fa-arrow-down"></i></a>
                                                            <?php
                                                        }else {
                                                            ?>
                                                            <a href="?active=<?=$row['post_id']?>" class="btn btn-sm btn-success"><i class="fas fa-arrow-up"></i></a>
                                                            <?php
                                                        }
                                                    ?>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div>
    </div>
</div>

<?php
$modelData = $post->modelData();
if ($modelData) {
    while ($model_row = mysqli_fetch_assoc($modelData)) {
?>
        <div id="myModal-<?=$model_row['post_id']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Post Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><label for="">Post Title</label></td>
                                <td><?=$model_row['post_title']?></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Category</label></td>
                                <td><?=$model_row['category_name']?></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Image One</label></td>
                                <td><img src="<?= $model_row['image_one'] ?>" style="width: 200px;" alt=""></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Description One</label></td>
                                <td><?=$model_row['description_one']?></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Image Two</label></td>
                                <td><img src="<?= $model_row['image_two'] ?>" style="width: 200px;" alt=""></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Description Two</label></td>
                                <td><?=$model_row['description_two']?></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Post Type</label></td>
                                <td><?php
                                    if ($model_row['post_type'] == 1) {
                                        echo 'Post';
                                    }else{
                                        echo 'Slider';
                                    }
                                ?></td>
                                
                            </tr>
                            <tr>
                                <td><label for="">Tags</label></td>
                                <td><?=$model_row['tags']?></td>
                                
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
<?php
    }
}
?>


<?php
include_once 'inc/footer.php';
?>