<?php
include_once 'inc/header.php';
include_once 'helpers/Format.php';
$format = new Format();

include_once 'classes/Post.php';
$post = new Post();

if (!isset($_GET['search']) || $_GET['search'] == NULL) {
    echo "<h1 class='text-danger'>Search Result Not Found</h1>";
}else {
    $search = $_GET['search'];
}
?>



<section class="site-section py-sm">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2 class="mb-4">Search Posts</h2>
      </div>
    </div>
    <div class="row blog-entries">
      <div class="col-md-12 col-lg-8 main-content">
        <div class="row">
          <?php
          $getPost = $post->searchPost($search);
          if ($getPost) {
            while ($row = mysqli_fetch_assoc($getPost)) {
          ?>
              <div class="col-md-6">
                <a href="blog-single.php?singleId=<?=base64_encode($row['post_id'])?>" class="blog-entry element-animate" data-animate-effect="fadeIn">
                  <img src="admin/<?= $row['image_one']?>" alt="Image placeholder">
                  <div class="blog-content-body">
                    <div class="post-meta">
                      <span class="author mr-2"><img src="admin/<?= $row['image'] ?>" alt="Colorlib"> <?= $row['user_name']?></span>&bullet;
                      <span class="mr-2"><?= $format->formatDate($row['created_at']) ?></span> &bullet;
                      <span class="ml-2"><span class="fa fa-comments"></span> 3</span>
                    </div>
                    <h2><?= $row['post_title'] ?></h2>
                  </div>
                </a>
              </div>
          <?php
            }
          }else {
            echo "<h1 class='text-danger'>Search Result Not Found</h1>";
          }
          ?>
            <div class="col-md-12 text-center">
              <nav aria-label="Page navigation" class="text-center">
                <ul class="pagination">
                  <li class="page-item  active"><a class="page-link" href="#">&lt;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">4</a></li>
                  <li class="page-item"><a class="page-link" href="#">5</a></li>
                  <li class="page-item"><a class="page-link" href="#">&gt;</a></li>
                </ul>
              </nav>
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
  </div>
</section>

<?php
include_once 'inc/footer.php';
?>