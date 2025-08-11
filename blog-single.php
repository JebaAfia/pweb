<?php
include_once 'inc/header.php';
include_once 'classes/Post.php';
$post = new Post();

include_once 'helpers/Format.php';
$format = new Format();

include_once 'classes/Comment.php';
$comment = new Comment();


if (isset($_GET['singleId'])) {
  $postId = base64_decode($_GET['singleId']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $comments = $comment->addComment($_POST);
  echo "<meta http-equiv='refresh' content='0;'/>";
}
?>
<section class="site-section py-lg">
  <div class="container">

    <div class="row blog-entries element-animate">

      <?php
      $getPost = $post->singlePost($postId);
      if ($getPost) {
        while ($row = mysqli_fetch_assoc($getPost)) {
      ?>
          <div class="col-md-12 col-lg-8 main-content">
            <img src="admin/<?= $row['image_one'] ?>" alt="Image" class="img-fluid mb-5">
            <div class="post-meta">
              <span class="author mr-2"><img src="admin/<?= $row['image'] ?>" alt="Colorlib" class="mr-2"><?= $row['user_name'] ?></span>&bullet;
              <span class="mr-2"><?= $format->formatDate($row['created_at']) ?></span> &bullet;
              <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
            </div>
            <h1 class="mb-4"><?= $row['post_title'] ?></h1>
            <a class="category mb-5" href="#"><?= $row['category_name'] ?></a>
            <div class="post-content-body">
              <p><?= $row['description_one'] ?></p>
              <div class="row mb-5">
                <div class="col-md-12 mb-4">
                  <img src="admin/<?= $row['image_two'] ?>" alt="Image placeholder" class="img-fluid">
                </div>
              </div>
              <p><?= $row['description_two'] ?></p>
            </div>


            <div class="pt-5">
              <p>Categories: <a href="#"><?= $row['category_name'] ?></a>Tags: <a href="#"><?= $row['tags'] ?></a>
            </div>


            <div class="pt-5">
              <?php
              // print_r($row);
              $allcomment = $comment->allComment($row['post_id']);
              if ($allcomment) {
                $num_rows = mysqli_num_rows($allcomment);
              ?>
                <h3 class="mb-5"><?= $num_rows ?> Comments</h3>
                <?php
                while ($comment_row = mysqli_fetch_assoc($allcomment)) {

                ?>
                  <ul class="comment-list">
                    <li class="comment">
                      <div class="vcard">
                        <img src="images/person_1.jpg" alt="Image placeholder">
                      </div>
                      <div class="comment-body">
                        <h3><?= $comment_row['name'] ?></h3>
                        <div class="meta"><?= $format->formatDate($comment_row['created_at']) ?></div>
                        <p><?= $comment_row['message'] ?></p>
                      </div>

                      <?php
                      if ($comment_row['admin_reply']) {
                      ?>
                        <ul class="children">
                          <li class="comment">
                            <div class="vcard">
                              <img src="admin/<?= $comment_row['image'] ?>" alt="Image placeholder">
                            </div>
                            <div class="comment-body">
                              <h3><?= $comment_row['user_name'] ?></h3>
                              <div class="meta"><?= $comment_row['update_date'] ?></div>
                              <p><?= $comment_row['admin_reply'] ?></p>
                              <p><a href="#" class="reply rounded">Reply</a></p>
                            </div>
                          </li>
                        </ul>
                      <?php
                      }
                      ?>


                    </li>
                  </ul>
              <?php
                }
              }
              ?>

              <!-- END comment-list -->

              <div class="comment-form-wrap pt-5">
                <h3 class="mb-5">Leave a comment</h3>
                <span>
                  <?php
                  if (isset($comments)) {
                  ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                      <?= $comments ?>
                      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  <?php
                  }
                  ?>
                </span>
                <form action="" method="POST" class="p-5 bg-light">
                  <input type="hidden" name="user_id" class="form-control" id="user_id" value="<?= $row['user_id'] ?>">
                  <input type="hidden" name="post_id" class="form-control" id="post_id" value="<?= $row['post_id'] ?>">
                  <div class="form-group">
                    <label for="name">Name *</label>
                    <input type="text" name="name" class="form-control" id="name">
                  </div>
                  <div class="form-group">
                    <label for="email">Email *</label>
                    <input type="email" name="email" class="form-control" id="email">
                  </div>
                  <div class="form-group">
                    <label for="website">Website</label>
                    <input type="text" name="website" class="form-control" id="website">
                  </div>

                  <div class="form-group">
                    <label for="message">Message</label>
                    <textarea name="message" id="message" cols="30" rows="10" class="form-control"></textarea>
                  </div>
                  <div class="form-group">
                    <input type="submit" value="Post Comment" class="btn btn-primary">
                  </div>

                </form>
              </div>
            </div>

          </div>




          <!-- END main-content -->
          <!-- START sidebar -->
          <?php
          include_once 'inc/sidebar.php';
          ?>
          <!-- END sidebar -->

    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2 class="mb-3 ">Related Post</h2>
      </div>
    </div>
    <div class="row">
      <?php
          $related_post = $post->relatedPost($row['category_id']);
          if ($related_post) {
            while ($related_post_row = mysqli_fetch_assoc($related_post)) {
      ?>
          <div class="col-md-6 col-lg-4">
            <a href="blog-single.php?singleId=<?=base64_encode($related_post_row['post_id'])?>" class="a-block sm d-flex align-items-center height-md" style="background-image: url(admin/<?=$related_post_row['image_one']?>); ">
              <div class="text">
                <div class="post-meta">
                  <span class="category"><?=$related_post_row['category_name']?></span>
                  <span class="mr-2"><?=$format->formatDate($related_post_row['created_at'])?></span> &bullet;
                  <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                </div>
                <h3><?=$related_post_row['post_title']?></h3>
              </div>
            </a>
          </div>
      <?php
            }
          }
      ?>
    </div>
  </div>
</section>
<?php
        }
      }
?>
<!-- END section -->

<?php
include_once 'inc/footer.php';
?>