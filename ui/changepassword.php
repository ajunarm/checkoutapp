
<?php

include_once "connectdb.php";
session_start();

if ($_SESSION['useremail'] == '')
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

if (isset($_POST['btnupdate']))
{
  $oldpassword = $_POST['txt_oldpassword'];
  $newpassword = $_POST['txt_newpassword'];
  $rnewpassword = $_POST['txt_rnewpassword'];

  $email = $_SESSION['useremail'];
  $select = $pdo->prepare("SELECT * FROM tbl_user WHERE useremail = '$email'");
  $select->execute();
  $row = $select->fetch(PDO::FETCH_ASSOC);

  // $useremail_db = $row['useremail'];
  $password_db = $row['userpassword'];

  if ($oldpassword == $password_db && $oldpassword != '' && $newpassword != '' && $rnewpassword != '')
  {
    if ($newpassword == $rnewpassword)
    {
      $update = $pdo->prepare("UPDATE tbl_user SET userpassword=:passwrd WHERE useremail=:email");
      $update->bindParam(':passwrd', $rnewpassword);
      $update->bindParam(':email', $email);
      if ($update->execute())
      {
        $_SESSION['status'] = "Password Changed Successfully";
        $_SESSION['status_code'] = 'success';
      }
      else
      {
        $_SESSION['status'] = "Could not update password. Something went wrong";
        $_SESSION['status_code'] = 'error';
      }
    }
    else
    {
      $_SESSION['status'] = "New password does not match";
      $_SESSION['status_code'] = 'error';
    }
  }
  else
  {
    $_SESSION['status'] = "Old password does not match";
    $_SESSION['status_code'] ='error';
  }

}

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">
            <!-- Horizontal Form -->
            <div class="card mt-2">
            <div class="card-header text-center bg-info">
              <b>
                <h5 class="m-0">Change User Password</h5>
              </b>
            </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form class="form-horizontal" action="" method="post">
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-2 col-form-label" ">Old Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputEmail3" placeholder="old password" name="txt_oldpassword">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="new password" name="txt_newpassword" required>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputPassword3" class="col-sm-2 col-form-label">Repeat New Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword3" placeholder="Repeat New Password" name="txt_rnewpassword" required>
                    </div>
                  </div>
      
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info" name="btnupdate">Update Password</button>
                </div>

                <!-- /.card-footer -->
              </form>
            </div>
            <!-- /.card -->

          </div>
          <!-- /.col-md-6 -->
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