<?php
session_start();
include('user.php');

$student = new Student();

if (isset($_POST['update'])) {
    $student->editRecord($this->id);
}

if (isset($_REQUEST['deleteid'])) {
    $deleteid = $_REQUEST['deleteid'];
    $student->deleteRecord($deleteid);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>
    <nav class="navbar bg-dark">
        <form class="container-fluid justify-content-center">
            <a href="add.php"><button class="btn btn-success mx-5" type="button">Add New User</button></a>
        </form>
    </nav>
    <div class="container">
        <h3 class="text-center my-5">PHP CRUD</h3>
        <h3 class="text-center my-3">List of Users</h3>
        <?php
        if (isset($_SESSION['status'])) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                ' . $_SESSION['status'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            unset($_SESSION['status']);
        }
        ?>

        <?php
        if (isset($_SESSION['msg'])) {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                ' . $_SESSION['msg'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';
            unset($_SESSION['msg']);
        }
        ?>
        <table class="table table-dark table-striped">
            <tr class="text-center">
                <td>S.N.</td>
                <td>Name</td>
                <td>Email</td>
                <td>Address</td>
                <td>Phone number</td>
                <td>Gender</td>
                <td>Action</td>
            </tr>
            <?php
            $student = new Student();
            $data = $student->listAll();
            $sn = 1;
            if ($data) {
                foreach ($data as $key => $value) {
                    //var_dump($value);
            ?>
                <tr class="text-center">
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $value->name; ?></td>
                    <td><?php echo $value->email; ?></td>
                    <td><?php echo $value->address; ?></td>
                    <td><?php echo $value->phone; ?></td>
                    <td><?php echo $value->gender; ?></td>
                    <td>
                        <a href="add.php?updateid=<?php echo $value->id; ?>"><button class="btn btn-primary">Edit</button></a>
                        <a href="index.php?deleteid=<?php echo $value->id; ?>"><button class="btn btn-danger">Delete</button></a>
                    </td>
                </tr>
            <?php
                }
            } else {
                ?>
                <tr class="text-center">
                    <td colspan="7">No Record Available</td>
                </tr>
            <?php
                }
            ?>
        </table>
    </div>
</body>

</html>