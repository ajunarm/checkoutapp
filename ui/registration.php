<?php

include_once "connectdb.php";
session_start();

if ($_SESSION['useremail'] == '' || $_SESSION['role'] == 'User')
{
  header('location: ../index.php');
}

if ($_SESSION['role'] == 'Admin')
{
  include_once "header.php";
}
else
{
include_once "headeruer.php";

}

error_reporting(0);

$id = $_GET['id'];
if (isset($id))
{
  $delete_query = $pdo->prepare("DELETE FROM tbl_user WHERE userid = '$id'");
  if ($delete_query->execute())
  {
    $_SESSION['status'] = "Account Deleted Successfully";
    $_SESSION['status_code'] = 'success';
  }
  else
  {
    $_SESSION['status'] = "Failed to Delete Account";
    $_SESSION['status_code'] = 'warning';
  }

}

if (isset($_POST['btnsave']))
{
  $username = ucfirst($_POST['txtname']);
  $useremail = $_POST['txtemail'];
  $userpassword = $_POST['txtpassword'];
  $userrole = $_POST['txtselect_option'];

  if (isset($_POST['txtemail']))
  {
    $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail = '$useremail'");
    $select->execute();
    if ($select->rowCount() > 0)
    {
      $_SESSION['status'] = "Email already exists";
      $_SESSION['status_code'] = 'error';
    }
    else
    {
      $insert = $pdo->prepare("INSERT INTO tbl_user (username, useremail, userpassword, role) VALUES (:name, :email, :password, :role)");

      $insert->bindParam(':name', $username);
      $insert->bindParam(':email', $useremail);
      $insert->bindParam(':password', $userpassword);
      $insert->bindParam(':role', $userrole);
    
      if ($insert->execute())
      {
        $_SESSION['status'] = "Inserted Successfully";
        $_SESSION['status_code'] = 'success';
      }
      else
      {
        $_SESSION['status'] = "Failed to Inserted";
        $_SESSION['status_code'] = 'error';
      }
    }
  }
  
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="card card-outline mt-2">
            <div class="card-header text-center bg-primary">
              <b>
                <h5 class="m-0">Add New Technician</h5>
              </b>
            </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <!-- form start -->
                            <form action="" method="post">
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Username</label>
                                    <input type="text" class="form-control" placeholder="Enter username" name="txtname" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email address</label>
                                    <input type="email" class="form-control" placeholder="Enter email" name="txtemail" required>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Password</label>
                                    <input type="password" class="form-control" placeholder="Password" name="txtpassword">
                                </div>

                                <!-- select -->
                                <div class="form-group">
                                    <label>Role</label>
                                    <select class="form-control" name="txtselect_option" required>
                                        <option value="" disabled selected>Select Role</option>
                                        <option>Admin</option>
                                        <option>User</option>
                                    </select>
                                </div>
                                <!-- select ends here -->
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary" name="btnsave">Save</button>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-8">
                          <table class="table table-striped table-hover">

                            <thead>
                              <tr>
                                <td>#</td>
                                <td>Username</td>
                                <td>Email</td>
                                <td>Role</td>
                                <!-- <td>Password</td> -->
                                <td>Delete</td>
                              </tr>
                            </thead>

                            <tbody>
                              <?php
                              
                              $select = $pdo->prepare("SELECT * FROM tbl_user ORDER BY userid ASC");
                              $select->execute();

                              while($row = $select->fetch(PDO::FETCH_ASSOC))
                              {
                                echo "
                                <tr>
                                <td>".$row['userid']."</td>
                                <td>".$row['username']."</td>
                                <td>".$row['useremail']."</td>
                                <td>".$row['role']."</td>
                                <td>
                                <a href='registration.php?id=".$row['userid']."' class='btn btn-danger'><i class='fa fa-trash-alt'></i></a>
                                </td>
                                <tr>";
                              }
                              
                              ?>
                            </tbody>

                          </table>
                        </div>
                    </div>
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
include_once "footer.php";
?>

<?php
 if (isset($_SESSION['status']) && $_SESSION['status'] != '')
 {
?>
 <script>

      Swal.fire({
        icon: '<?php echo $_SESSION['status_code'];?>',
        title: '<?php echo $_SESSION['status'];?>'
      });

 </script>

<?php 
  unset($_SESSION['status']);
}
?>