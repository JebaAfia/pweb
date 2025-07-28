<?php
    
    include_once 'inc/header.php';
    include_once 'inc/sidebar.php';
    // include_once '../classes/Category.php';
    // $category = new Category();

    // if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //     $category_name = $_POST['category_name'];

    //     $category_add = $category->AddCategory($category_name);
    // }
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <!-- <span>
                    <?php
                    if (isset($category_add)) {
                    ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?= $category_add?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php
                    }
                    ?>
                </span> -->
                    <div class="card shadow">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-6">
                                    <h5>User Profile</h5>
                                </div>
                                <div class="col-sm-6 d-flex justify-content-end">
                                    <a href="edit_profile.php?user_id=<?=Session::get('user_id')?>" class="btn btn-sm btn-info"> Edit Profile</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-responsive">
                                <tr>
                                    <td><label for="">User Name</label></td>
                                    <td><?=Session::get('user_name')?></td>
                                </tr>
                                <tr>
                                    <td><label for="">User Photo</label></td>
                                    <td><img src="<?=Session::get('user_image')?>" alt="" style="width: 200px;"></td>
                                </tr>
                                

                            </table>

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