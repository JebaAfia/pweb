<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/Comment.php';
$comment = new Comment();

if (isset($_GET['replyComment'])) {
    $comment_id = base64_decode($_GET['replyComment']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reply = $_POST['reply'];

    $comment_reply = $comment->AddReply($reply, $comment_id);
}
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <span>
                        <?php
                        if (isset($comment_reply)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $comment_reply ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card shadow">
                        <h4 class="card-header">Reply Post Comment</h4>
                        <div class="card-body">
                            <?php
                            $select_comment = $comment->selectComment($comment_id);
                            if ($select_comment) {
                                while ($row = mysqli_fetch_assoc($select_comment)) {
                            ?>
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Reply Message</label>
                                            <textarea class="form-control" name="reply" id=""><?=$row['admin_reply']?></textarea>
                                        </div>
                                        <div>
                                            <div>
                                                <button type="submit" class="btn btn-success waves-effect waves-light me-1">
                                                    Send Reply
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