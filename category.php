<?php
include_once 'inc/header.php';
include_once 'classes/Post.php';
$post = new Post();

include_once 'classes/Category.php';
$category = new Category();

include_once 'helpers/Format.php';
$format = new Format();

if (isset($_GET['categoryID'])) {
  $categoryID = base64_decode($_GET['categoryID']);
}
?>

<section class="site-section pt-5">
  <div class="container">
    <div class="row mb-4">
      <?php
      $category_name = $category->categoryName($categoryID);
      if ($category_name) {
        while ($category = mysqli_fetch_assoc($category_name)) {
      ?>
          <div class="col-md-6">
            <h2 class="mb-4">Category: <?= $category['category_name'] ?></h2>
          </div>
      <?php
        }
      }
      ?>

    </div>
    <div class="row blog-entries">
      <div class="col-md-12 col-lg-8 main-content">
        <div class="row mb-5 mt-5">

          <div class="col-md-12">
            <?php
            $limit = 1;
            if (isset($_GET['page'])) {
              $page = $_GET['page'];
            }else {
              $page = 1;
            }
            $offset = ($page - 1) * $limit;

            $category_post = $post->categoryPost($categoryID, $offset, $limit);
            if ($category_post) {
              while ($row = mysqli_fetch_assoc($category_post)) {
            ?>
                <div class="post-entry-horzontal">
                  <a href="blog-single.php?singleId=<?= base64_encode($row['post_id']) ?>">
                    <div class="image element-animate" data-animate-effect="fadeIn" style="background-image: url(admin/<?= $row['image_one'] ?>);"></div>
                    <span class="text">
                      <div class="post-meta">
                        <span class="author mr-2"><img src="admin/<?= $row['image'] ?>" alt="Colorlib"> <?= $row['user_name'] ?></span>&bullet;
                        <span class="mr-2"><?= $format->formatDate($row['created_at']) ?></span> &bullet;
                        <span class="mr-2"><?= $row['category_name'] ?></span> &bullet;
                      </div>
                      <h2><?= $row['post_title'] ?></h2>
                    </span>
                  </a>
                </div>
            <?php
              }
            } else {
              echo "<h1 class='text-danger'>This Category Has No Post</h1>";
            }
            ?>

            <!-- END post -->

          </div>
        </div>

        <div class="row mt-5">
          <div class="col-md-12 text-center">
            <nav aria-label="Page navigation" class="text-center">
              <?php
              $num_page = $post->numberOfCategoryPost($categoryID);
              if ($num_page) {
                $total_record = mysqli_num_rows($num_page);
                $total_page = ceil($total_record / $limit);
              ?>
                <ul class="pagination">
                  <?php
                    if ($page > 1) {
                      ?>
                        <li class="page-item "><a class="page-link" href="<?=$_SERVER['REQUEST_URI']?>&page=<?=$page - 1?>">&lt;</a></li>
                      <?php
                    }
                  ?>
                  
                  <?php
                    for ($i=1; $i <= $total_page ; $i++) { 
                      if ($i == $page) {
                            $active = 'active';
                            }else {
                              $active = '';
                            }
                      ?>
                        <li class="page-item <?=$active?>"><a class="page-link" href="<?=$_SERVER['REQUEST_URI']?>&page=<?=$i?>"><?=$i?></a></li>
                      <?php
                    }
                  ?>
                  
                  <?php
                  if ($total_page > $page) {
                    ?>
                      <li class="page-item"><a class="page-link" href="<?=$_SERVER['REQUEST_URI']?>&page=<?=$page + 1?>">&gt;</a></li>
                    <?php
                  }
                  ?>
                  
                </ul>
              <?php
              }
              ?>

            </nav>
          </div>
        </div>



      </div>

      <!-- END main-content -->

      <?php
      include_once 'inc/sidebar.php';
      ?>
      <!-- END sidebar -->

    </div>
  </div>
</section>

<?php
include_once 'inc/footer.php';
?>