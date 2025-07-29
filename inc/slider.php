<?php
include_once 'classes/Post.php';
$post = new Post();

include_once 'helpers/Format.php';
$format = new Format();
?>
<section class="site-section pt-5 pb-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <div class="owl-carousel owl-theme home-slider">
          <?php
          $slider_post = $post->sliderPost();
          if ($slider_post) {
            while ($slider_post_row = mysqli_fetch_assoc($slider_post)) {
          ?>
              <div>
                <a href="blog-single.php?singleId=<?=base64_encode($slider_post_row['post_id'])?>" class="a-block d-flex align-items-center height-lg" style="background-image: url(admin/<?=$slider_post_row['image_one']?>); ">
                  <div class="text half-to-full">
                    <span class="category mb-5"><?=$slider_post_row['category_name']?></span>
                    <div class="post-meta">

                      <span class="author mr-2"><img src="admin/<?=$slider_post_row['image']?>" alt="user_name"><?=$slider_post_row['user_name']?></span>&bullet;
                      <span class="mr-2"><?=$format->formatDate($slider_post_row['created_at'])?></span> &bullet;

                    </div>
                    <h3><?=$slider_post_row['post_title']?></h3>
                    <p><?=$format->textShorten($slider_post_row['description_one'], 100)?></p>
                  </div>
                </a>
              </div>
          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- END section -->