<?php

include_once 'inc/header.php';
include_once 'inc/sidebar.php';
include_once '../classes/Category.php';
$category = new Category();

$all_category = $category->AllCategory();

if (isset($_GET['deleteCategory'])) {
    $id = base64_decode($_GET['deleteCategory']);
    $deleteCategory = $category->DeleteCategory($id);
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
                        if (isset($deleteCategory)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <?= $deleteCategory ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php
                        }
                        ?>
                    </span>
                    <div class="card">
                        <h4 class="card-header">Category List</h4>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>Serial No</th>
                                        <th>Category Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>


                                <tbody>
                                    <?php
                                        if ($all_category) {
                                            $i = 0;
                                            while($row = mysqli_fetch_assoc($all_category)){
                                                $i++;
                                                ?>
                                                    <tr>
                                                        <td><?=$i?></td>
                                                        <td><?= $row['category_name']?></td>
                                                        <td>
                                                            <a href="categoryEdit.php?editId=<?=base64_encode($row['category_id'])?>" class="btn btn-success btn-sm">EDIT</a>
                                                            <a href="?deleteCategory=<?=base64_encode($row['category_id'])?>" onclick="return confirm('Are You Sure To Delete - <?=$row['category_name']?>')" class="btn btn-danger btn-sm">DELETE</a>
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
include_once 'inc/footer.php';
?>