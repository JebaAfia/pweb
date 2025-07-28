<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/Post.php';
include_once '../helpers/Format.php';
$post = new Post();
$format = new Format();

include_once '../classes/Comment.php';
$comment = new Comment();

$user_id = Session::get('user_id');
$all_post = $post->AllPost($user_id);

//active
if (isset($_GET['active'])) {
    $active_id = $_GET['active'];
    $active = $comment->activePost($active_id);
}
//deactive
if (isset($_GET['deactive'])) {
    $deactive_id = $_GET['deactive'];
    $deactive = $comment->deactivePost($deactive_id);
}

if (isset($_GET['deleteComment'])) {
    $id = base64_decode($_GET['deleteComment']);
    $deleteComment = $comment->deleteComment($id);
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
                        if (isset($deleteComment)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $deleteComment ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card">
                        <h4 class="card-header">All Comment</h4>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Website</th>
                                        <th>Comment</th>
                                        <th>Admin Reply</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                    $allComment = $comment->adminComment($user_id);
                                    if ($allComment) {
                                        $i = 0;
                                        while ($row = mysqli_fetch_assoc($allComment)) {
                                            $i++;
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= $row['name'] ?></td>
                                                <td><?= $row['email'] ?></td>
                                                <td><?= $row['website'] ?></td>
                                                <td><?= $row['message'] ?></td>
                                                <td><?= $row['admin_reply'] ?></td>
                                                <td>
                                                    <a href="comment-reply.php?replyComment=<?=base64_encode($row['comment_id'])?>" class="btn btn-sm btn-primary"><i class="fas fa-reply"></i></a>
                                                    <a href="?deleteComment=<?=base64_encode($row['comment_id'])?>" onclick="return confirm('Are You Sure To Delete?')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                                    <a href="" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#myModal-<?=$row['post_id']?>"><i class="fas fa-eye"></i></a>
                                                    <?php
                                                        if ($row['status'] == 0) {
                                                            ?>
                                                            <a href="?deactive=<?=$row['comment_id']?>" class="btn btn-sm btn-warning"><i class="fas fa-arrow-down"></i></a>
                                                            <?php
                                                        }else {
                                                            ?>
                                                            <a href="?active=<?=$row['comment_id']?>" class="btn btn-sm btn-success"><i class="fas fa-arrow-up"></i></a>
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