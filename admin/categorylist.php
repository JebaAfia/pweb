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
                                                            <a href="javascript:avoid(0)" data-bs-toggle="modal" data-bs-target="#myModal-<?=$row['category_id']?>" class="btn btn-sm btn-info">VIEW</a>
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
$modelDataCategory = $category->modelDataCategory();
if ($modelDataCategory) {
    while ($model_row = mysqli_fetch_assoc($modelDataCategory)) {
?>
        <div id="myModal-<?=$model_row['category_id']?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Post Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-bordered">
                            <tr>
                                <td><label for="">Category Name</label></td>
                                <td><?=$model_row['category_name']?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light waves-effect" data-bs-dismiss="modal">Close</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
<?php
    }
}
?>



<?php
include_once 'inc/footer.php';
?>