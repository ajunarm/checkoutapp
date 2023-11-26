<?php

include_once "connectdb.php";
session_start();

if ($_SESSION['useremail'] == '' || $_SESSION['role'] == 'User') {
  header('location: ../index.php');
}

if ($_SESSION['role'] == 'Admin') {
  include_once "header.php";
} else {
  include_once "headeruer.php";

}

$id = $_GET['id'];

$select = $pdo->prepare("SELECT * from tbl_items WHERE itemid = $id");
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$id_db = $row['itemid'];
$barcode_db = $row['barcode'];
$asset_tag_db = $row['asset_tag'];
$item_db = $row['item'];
$category_db = $row['category'];
$description_db = $row['description'];

 

if (isset($_POST['updateItemButton']))
{
  $asset_tag_txt = $_POST['txtasset_tag'];
  $category_txt = $_POST['txtcategory'];
  $item_txt = $_POST['txtitem_name'];
  // $barcode_txt = $_POST['txtbarcode'];
  $description_txt = $_POST['txtdescription'];
  $current_status = $_POST['txtstatus'];
  $lastcheck_out = date("Y-m-d H:i:s");


$update = $pdo->prepare("UPDATE tbl_items SET item=:item, category=:category, asset_tag=:asset_tag, description=:description, current_status=:current_status, lastcheck_out=:lastcheck_out WHERE itemid=$id");
$update->bindParam(':item', $item_txt);
$update->bindParam(':asset_tag', $asset_tag_txt);
$update->bindParam(':category', $category_txt);
$update->bindParam(':description', $description_txt);
$update->bindParam(':current_status', $current_status);
$update->bindParam(':lastcheck_out', $lastcheck_out);

if ($update->execute())
{
  $_SESSION['status'] = "Item Updated Successfully";
  $_SESSION['status_code'] = 'success';
  
}
else
{
  $_SESSION['status'] = "Failed to update item";
  $_SESSION['status_code'] = 'error';
}
}

$select = $pdo->prepare("SELECT * from tbl_items WHERE itemid = $id");
$select->execute();

$row = $select->fetch(PDO::FETCH_ASSOC);

$id_db = $row['itemid'];
$barcode_db = $row['barcode'];
$asset_tag_db = $row['asset_tag'];
$item_db = $row['item'];
$category_db = $row['category'];
$description_db = $row['description'];
$current_status = $row['current_status'];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Edit Item</h1>
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

          <div class="card card-success card-outline">
            <div class="card-header">
              <h5 class="m-0">Edit items name here</h5>
            </div>
            <div class="card-body">

              <!-- form starts here -->
              <form action="" method="post" name="edititem">

                <div class="row">

                  <div class="col-md-6">
                    

                    <div class="form-group">
                      <label>Item Name</label>
                      <input type="text" class="form-control" value="<?php echo $item_db;?>" placeholder="Enter item name" name="txtitem_name"
                        required>
                    </div>

                    <!-- select -->
                    <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="txtstatus" required>
                                <option value="" disabled selected><?php echo $current_status;?></option>
                                <option>CheckedIn</option>
                                 <option>CheckedOut</option>
                                 <option>Broken</option>
                                 <option>Missing</option>
                            </select>
                      </div>
                    <!-- select ends here -->

                    <div class="form-group">
                      <label>Barcode</label>
                      <input type="text" class="form-control" value="<?php echo $barcode_db;?>" disabled placeholder="Enter barcode" name="txtbarcode">
                    </div>

                    <!-- select -->
                    <div class="form-group">
                      <label>Category</label>
                      <select class="form-control" name="txtcategory" required>
                        <option value="" disabled selected>Select Category</option>

                        <!-- get the selected category from database -->
                        <?php
                        $select = $pdo->prepare("SELECT * FROM tbl_category ORDER BY catid ASC");
                        $select->execute();
                        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                          extract($row);
                          ?>
                          <option

                                <?php
                          if ($row['category']==$category_db)
                            {
                                ?>
                                selected="selected"
                            <?php
                            }
                          ?>>  
                          <?php 
                          echo $row['category'];
                          ?>
                          </option>

                        <?php

                        }
                        
                        ?>
                      </select>
                    </div>
                    <!-- select ends here -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-success" name="updateItemButton">Update Item</button>
                    </div>

                  </div>

                  <div class="col-md-6">
                    
                    <div class="form-group">
                      <label>Asset Tag</label>
                      <input type="text" class="form-control" value="<?php echo $asset_tag_db;?>" placeholder="Enter asset tag" name="txtasset_tag"
                        required>
                    </div>

                    <div class="form-group">
                      <label>Item Description</label>
                      <textarea class="form-control" placeholder="Enter item description (optional)"
                        name="txtdescription" row="4"><?php echo $description_db; ?></textarea>
                    </div>

                  </div>

                </div>

              </form>
              <!-- Form ends here -->
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