<?php
    
    include_once 'inc/header.php';
    include_once 'inc/sidebar.php';
    include_once '../classes/Category.php';
    $category = new Category();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $category_name = $_POST['category_name'];

        $category_add = $category->AddCategory($category_name);
    }
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-6">
                    <span>
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
                </span>
                    <div class="card shadow">
                        <h4 class="card-header">Category Add Form</h4>
                        <div class="card-body">
                            <form action="" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Category Name</label>
                                    <input type="text" name="category_name" class="form-control" placeholder="Type category name..." />
                                </div>
                                <div>
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                            Add Category
                                        </button>
                                    </div>
                                </div>
                            </form>

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