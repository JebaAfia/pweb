<?php
include_once 'classes/User.php';
$user = new User();

include_once 'classes/SiteOption.php';
$site_option = new SiteOption();

include_once 'classes/Post.php';
$post = new Post();

include_once 'classes/Category.php';
$category = new Category();

include_once 'helpers/Format.php';
$format = new Format();
?>
<div class="col-md-12 col-lg-4 sidebar">
  <div class="sidebar-box search-form-wrap">
    <form action="#" class="search-form">
      <div class="form-group">
        <span class="icon fa fa-search"></span>
        <input type="text" class="form-control" id="s" placeholder="Type a keyword and hit enter">
      </div>
    </form>
  </div>
  <!-- END sidebar-box -->
  <div class="sidebar-box">
    <?php
    $userInfo = $user->userBio();
    if ($userInfo) {
      $user_info_row = mysqli_fetch_assoc($userInfo)
    ?>
      <div class="bio text-center">
        <img src="admin/<?= $user_info_row['image'] ?>" alt="Image Placeholder" class="img-fluid">
        <div class="bio-body">
          <h2><?= $user_info_row['user_name'] ?></h2>
          <p><?= $user_info_row['user_bio'] ?></p>
          <p><a href="#" class="btn btn-primary btn-sm rounded">Read my bio</a></p>
          <?php
          $allLink = $site_option->allSocial();
          if ($allLink) {
            while ($link = mysqli_fetch_assoc($allLink)) {
          ?>
              <p class="social">
                <a href="<?= $link['facebook'] ?>" target="_blank" class="p-2"><span class="fa fa-facebook"></span></a>
                <a href="<?= $link['twiter'] ?>" target="_blank" class="p-2"><span class="fa fa-twitter"></span></a>
                <a href="<?= $link['instagram'] ?>" target="_blank" class="p-2"><span class="fa fa-instagram"></span></a>
                <a href="<?= $link['youtube'] ?>" target="_blank" class="p-2"><span class="fa fa-youtube-play"></span></a>
              </p>
          <?php
            }
          }
          ?>
        </div>
      </div>
    <?php

    }
    ?>

  </div>
  <!-- END sidebar-box -->
  <div class="sidebar-box">
    <h3 class="heading">Popular Posts</h3>
    <div class="post-entry-sidebar">
      <ul>
        <?php
        $allPost = $post->showPopularPost();
        if ($allPost) {
          while ($post_row = mysqli_fetch_assoc($allPost)) {
        ?>
            <li>
              <a href="">
                <img src="admin/<?=$post_row['image_one']?>" alt="Image placeholder" class="mr-4">
                <div class="text">
                  <h4><?=$post_row['post_title']?></h4>
                  <div class="post-meta">
                    <span class="mr-2"><?=$format->formatDate($post_row['created_at'])?></span>
                  </div>
                </div>
              </a>
            </li>
        <?php
          }
        }
        ?>
      </ul>
    </div>
  </div>
  <!-- END sidebar-box -->

  <div class="sidebar-box">
    <h3 class="heading">Categories</h3>
    <ul class="categories">
      <?php
      $allCategory = $category->AllCategory();
      if ($allCategory) {
        while ($categoryRow = mysqli_fetch_assoc($allCategory)) {
          ?>
            <li>
              <a href="#"><?=$categoryRow['category_name']?> 
                <span>
                  (<?php
                    $categoryNumber = $post->categoryNumber($categoryRow['category_id']);
                    if ($categoryNumber) {
                      echo $num = mysqli_num_rows($categoryNumber);
                    }else {
                      echo 0;
                    }
                  ?>)
                </span>
              </a>
            </li>
          <?php
        }
      }
      ?>
    </ul>
  </div>
  <!-- END sidebar-box -->

  <div class="sidebar-box">
    <h3 class="heading">Tags</h3>
    <ul class="tags">
      <?php
        $allTags = $post->showPopularPost();
        if ($allTags) {
          while ($tag = mysqli_fetch_assoc($allTags)) {
            ?>
              <li><a href="#"><?=$tag['tags']?></a></li>
            <?php
          }
        }
      ?>
    </ul>
  </div>
</div>