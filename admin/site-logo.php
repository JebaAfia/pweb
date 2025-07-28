<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/SiteOption.php';
$site_option = new SiteOption();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $update_logo = $site_option->updateLogo($_POST);
}
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <span>
                        <?php
                        if (isset($update_logo)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $update_logo ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card shadow">
                        <h4 class="card-header">Site Logo</h4>
                        <div class="card-body">
                            <?php
                            $logo = $site_option->siteLogo();
                            if ($logo) {
                                while ($row = mysqli_fetch_assoc($logo)) {
                            ?>
                                    <form action="" method="POST">
                                        <div class="mb-3">
                                            <label class="form-label">Site Logo</label>
                                            <input type="text" name="logo" class="form-control" value="<?=$row['logo_name']?>"/>
                                        </div>
                                        <div>
                                            <div>
                                                <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                                    Update Logo
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