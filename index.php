<?php
include('./layouts/header.php');
include('./config/config.php');
include_once './classes/Register.php';

$re = new Register();
if (isset($_GET['delStd'])) {
    $id = base64_decode($_GET['delStd']);
    $delStudent = $re->delStudent($id);
}


// $register = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $register = $re->addRegister($_POST, $_FILES);

    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}

?>


<div class="d-flex justify-content-between mb-3 align-items-center ">
    <h2>All Students</h2>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Add Student
    </button>
    <!-- <a href="#" class="btn btn-primary ">Student Add</a> -->
</div>
<table class="table table-striped border table-hover">
    <thead>
        <tr>
            <th scope="col">Sl No.</th>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Phone</th>
            <th scope="col">Image</th>
            <th scope="col">Address</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $students = $re->getAllStudents();
        $sl = 1;
        if ($students) {
            while ($row = mysqli_fetch_assoc($students)) {

        ?>
                <tr>
                    <th scope="row"><?= $sl++; ?></th>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><img src="<?= htmlspecialchars($row['photo']) ?>" alt="Image" width="50"></td>
                    <td><?= $row['address'] ?></td>
                    <td>
                        <a href="edit.php?id=<?= base64_encode($row['id']) ?>" class="btn btn-primary btn-sm rounded-0 me-2">Edit</a>
                        <a href="?delStd=<?= base64_encode($row['id']) ?>" class="btn btn-danger btn-sm rounded-0" onclick="return confirm('Are you sure to delete this record?')">Delete</a>
                    </td>

                </tr>
        <?php

            }
        }
        ?>


    </tbody>
</table>




<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">

        <div class="modal-content p-4">
            <?php
            if (isset($register)) {
            ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong><?= $register ?></strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php
            }
            ?>
            <h2 class="text-center">Add Student</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" placeholder="Enter your name" id="name" aria-describedby="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="Enter your email" id="email" aria-describedby="email" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" name="phone" placeholder="Enter your phone" id="phone" aria-describedby="phone" required>
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input type="file" class="form-control" name="photo" placeholder="Enter your photo" id="photo" aria-describedby="photo" required>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" placeholder="Enter your address" id="address" aria-describedby="address" required>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" name="add_student" value="ADD">
                </div>
            </form>

        </div>
    </div>
</div>

<?php include('./layouts/footer.php'); ?>