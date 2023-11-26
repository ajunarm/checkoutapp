
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

include 'barcode/barcode128.php'

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Details</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Starter Page</li> -->
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- /.col-md-6 -->
          <div class="col-lg-12">

            <div class="card card-info card-outline">
              <!-- <div class="card-header">
                <h5 class="m-0">Details</h5>
              </div> -->
              <div class="card-body">

                        <?php 
                        $id = $_GET['id'];

                        $select = $pdo->prepare("SELECT * FROM tbl_items WHERE itemid = '$id'");
                        $select->execute();

                        while ($row = $select->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '
                          <div class="row">

                          <div class="col-md-12">
                            <center><p class="list-group-item-info"><b>'.$row['item'].' Details</b></p></center>
                          <ul class="list-group">
                            <li class="list-group-item">Name <span class="badge badge-info float-right">'.$row['item'].'</span></li>
                            <li class="list-group-item">Status <span class="badge badge-info float-right">'.$row['current_status'].'</span></li>
                            <li class="list-group-item">Barcode <span class="badge badge-light float-right">'.bar128($row['barcode']).'</span></li>
                            <li class="list-group-item">Category <span class="badge badge-success float-right">'.$row['category'].'</span></li>
                            <li class="list-group-item">Asset Tag <span class="badge badge-warning float-right">'.$row['asset_tag'].'</span></li>
                            <li class="list-group-item">Description <span class="badge badge-secondary float-right">'.$row['description'].'</span></li>
                          </ul>

                        </div>

                      </div>
                          ';
                        }
                        ?>
                
              </div>
            </div>

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