<?php
    include_once '../classes/Register.php';
    $register = new Register();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $addUser = $register->AddUser($_POST);
    }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Registration Form</title>
</head>

<body>

    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-6">
            <span>
                <?php
                    if (isset($addUser)) {
                        ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <?=$addUser?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                        <?php
                    }
                ?>
            </span>
                <div class="card">
                    <div class="card-header">Registration Form</div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label >Name</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label >Phone</label>
                                <input type="text" name="phone" class="form-control">
                            </div>

                            <div class="form-group">
                                <label >Email address</label>
                                <input type="email" name="email" class="form-control">
                            </div>

                            <div class="form-group">
                                <label >Password</label>
                                <input type="password" name="password" class="form-control">
                            </div>
                            
                            <button type="submit" class="btn btn-success">Sign Up</button>
                            <a href="login.php" class="btn btn-info" >Login</a>
                        </form>
                            
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
</body>

</html>