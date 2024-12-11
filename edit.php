<?php
include('./layouts/header.php');
include('./config/config.php');

include_once './classes/Register.php';

$re = new Register();

if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);
}
// $register = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $register = $re->updateStudent($_POST, $_FILES, $id);

    // header("Location: " . $_SERVER['REQUEST_URI']);
    // exit;
}

?>


<div class="d-flex justify-content-between mb-3 align-items-center ">
    <h2>Edit Student</h2>
    <!-- Button trigger modal -->
    <a href="./index.php" class="btn btn-primary rounded-0 ">Back</a>
</div>
<div class="m-5">
    <?php
    $getStd = $re->getStdById($id);
    if ($getStd) {
        while ($row = mysqli_fetch_assoc($getStd)) {
    ?>
            <form method="post" enctype="multipart/form-data">
                <div class="d-flex row">
                    <div class="mb-3 col">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" value="<?= $row['name'] ?>" aria-describedby="name">
                    </div>
                    <div class="mb-3 col">
                        <label for="email" class="form-label">Email</label>
                        <input value="<?= $row['email'] ?>" type="email" class="form-control" name="email" id="email" aria-describedby="email">
                    </div>
                    <div class="mb-3 col">
                        <label for="phone" class="form-label">Phone</label>
                        <input value="<?= $row['phone'] ?>" type="number" class="form-control" name="phone" id="phone" aria-describedby="phone">
                    </div>
                </div>

                <div class="d-flex row">
                    <div class="mb-3 col">
                        <label for="photo" class="form-label">Photo</label>
                        <input value="<?= $row['photo'] ?>" type="file" class="form-control" name="photo" id="photo" aria-describedby="photo"> <br>
                        <img src="<?= $row['photo'] ?>" class="img-thumbnail" width="220px" height="90px" alt="" srcset="">
                    </div>
                    <div class="mb-3 col">
                        <label for="address" class="form-label">Address</label>
                        <input value="<?= $row['address'] ?>" type="text" class="form-control" name="address" id="address" aria-describedby="address">
                    </div>
                </div>


                <div class="modal-footer">
                    <input type="submit" class="btn btn-success rounded-0" name="add_student" value="Update">
                </div>
            </form>
    <?php
        }
    }
    ?>

</div>
<?php include('./layouts/footer.php'); ?>