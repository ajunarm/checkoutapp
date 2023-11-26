<?php

include_once "connectdb.php";
session_start();

if ($_SESSION['useremail'] == '') {
    header('location: ../index.php');
}

if ($_SESSION['role'] == 'Admin') {
    include_once "header.php";
} else {
    include_once "headeruer.php";

}

if (isset($_POST['btnsave'])) {
    $category = $_POST['txtcategory'];

    if (empty($category)) {
        $_SESSION['status'] = "Category cannot be empty";
        $_SESSION['status_code'] = 'warning';
    } else {
        $select = $pdo->prepare("SELECT * FROM tbl_category WHERE category = '$category'");
        $select->execute();
        if ($select->rowCount() > 0) {
            $_SESSION['status'] = "Category already exists";
            $_SESSION['status_code'] = 'error';
        } else {
            $insert = $pdo->prepare("INSERT INTO tbl_category (category) VALUES (:category)");
            $insert->bindParam(':category', $category);
            if ($insert->execute()) {
                $_SESSION['status'] = "Inserted Successfully";
                $_SESSION['status_code'] = 'success';
            } else {
                $_SESSION['status'] = "Failed to Inserted";
                $_SESSION['status_code'] = 'error';
            }
        }
    }
}

if (isset($_POST['btnupdate'])) {
    $category = $_POST['txtcategory'];
    $id = $_POST['txtcatid'];

    if (empty($category)) {
        $_SESSION['status'] = "Category cannot be empty";
        $_SESSION['status_code'] = 'warning';
    } else {
        $update = $pdo->prepare("UPDATE tbl_category SET category=:cat WHERE catid = '$id'");
        $update->bindParam(':cat', $category);
        if ($update->execute()) {
            $_SESSION['status'] = "Category updated Successfully";
            $_SESSION['status_code'] = 'success';
        } else {
            $_SESSION['status'] = "failed to update Category";
            $_SESSION['status_code'] = 'error';
        }
    }
}

if (isset($_POST['btndelete'])) {
    $delete = $pdo->prepare("DELETE FROM tbl_category WHERE catid = " . $_POST['btndelete']);
    if ($delete->execute()) {
        $_SESSION['status'] = "Category deleted Successfully";
        $_SESSION['status_code'] = 'success';
    } else {
        $_SESSION['status'] = "failed to delete category";
        $_SESSION['status_code'] = 'error';
    }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="card card-outline mt-2">
            <div class="card-header text-center bg-warning">
              <b>
                <h5 class="m-0">Add new item category</h5>
              </b>
            </div>
                <div class="card-body">
                    <form action="" method="post">

                        <div class="row">
                            <?php

                            if (isset($_POST['btnedit'])) {
                                $select = $pdo->prepare("SELECT * FROM tbl_category WHERE catid = " . $_POST['btnedit']);
                                $select->execute();

                                if ($select) {
                                    $row = $select->fetch(PDO::FETCH_ASSOC);

                                    echo '
                                 <div class="col-md-4">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Item Category</label>
                                    <input type="hidden" class="form-control" placeholder="Enter category" value="' . $row['catid'] . '" name="txtcatid">
                                    <input type="text" class="form-control" placeholder="Enter category" value="' . $row['category'] . '" name="txtcategory">
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="btnupdate">Update</button>
                                </div>
                                    </div>
                                     ';
                                }
                                     } else {
                                echo '
                                <div class="col-md-4">
                                <!-- form start -->
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Item Category</label>
                                    <input type="text" class="form-control" placeholder="Enter category"
                                        name="txtcategory">
                                </div>

                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-warning" name="btnsave">Save</button>
                                </div>
                            </div>
                                    ';
                            }

                            ?>

                            <div class="col-md-8">
                                <table id="table_category" class="table table-striped table-hover">

                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Item Category</td>
                                            <td>Edit</td>
                                            <td>Delete</td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php

                                        $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid ASC");
                                        $select->execute();

                                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                                            echo '
                                <tr>
                                    <td>' . $row['catid'] . '</td>
                                    <td>' . $row['category'] . '</td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-xs" name="btnedit" value="' . $row['catid'] . '"><i class="fa fa-edit"></i></button>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-danger btn-xs" name="btndelete" value="' . $row['catid'] . '"><i class="fa fa-trash-alt"></i></button>
                                    </td>
                                </tr>
                                ';
                                        }

                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>#</td>
                                            <td>Item Category</td>
                                            <td>Edit</td>
                                            <td>Delete</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once "footer.php";
?>

<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    ?>
    <script>
        Swal.fire({
            icon: '<?php echo $_SESSION['status_code']; ?>',
            title: '<?php echo $_SESSION['status']; ?>'
        });
    </script>

    <?php
    unset($_SESSION['status']);
}
?>

<script>
    $(document).ready(function () {
        $('#table_category').DataTable();
    });
</script>