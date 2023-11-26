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

if (isset($_POST['btnsave']))
{
  $asset_tag = $_POST['txtasset_tag'];
  $category = $_POST['txtcategory'];
  $item = $_POST['txtitem_name'];
  $barcode = $_POST['txtbarcode'];
  $description = $_POST['txtdescription'];
  $current_status = $_POST['txtstatus'];

  if (empty($barcode))
  {
    $insert = $pdo->prepare("INSERT INTO tbl_items (asset_tag, item, category, description, current_status) VALUES (:asset_tag, :item, :category, :description, :current_status)");
    
    $insert->bindParam(':asset_tag', $asset_tag);
    $insert->bindParam(':item', $item);
    $insert->bindParam(':category', $category);
    $insert->bindParam(':description', $description);
    $insert->bindParam(':current_status', $current_status);

    $insert->execute();

    $itemid = $pdo->lastInsertId();

    date_default_timezone_set('America/Los_Angeles');
    $newbarcode = $itemid.date('his');

    $update = $pdo->prepare("UPDATE tbl_items SET barcode = :barcode WHERE itemid = '$itemid'");
    $update->bindParam(':barcode', $newbarcode);
    $update->execute();

    $_SESSION['status'] = "Item added Successfully";
    $_SESSION['status_code'] = 'success';
  }
  else
  {
    $insert = $pdo->prepare("INSERT INTO tbl_items (asset_tag, item, barcode, category, description, current_status) VALUES (:asset_tag, :item, :barcode, :category, :description, :current_status)");

    $insert->bindParam(':asset_tag', $asset_tag);
    $insert->bindParam(':item', $item);
    $insert->bindParam(':barcode', $barcode);
    $insert->bindParam(':category', $category);
    $insert->bindParam(':description', $description);
    $insert->bindParam(':current_status', $current_status);

    if ($insert->execute())
    {
      $_SESSION['status'] = "Item Added Successfully";
      $_SESSION['status_code'] = 'success';
    }
    else
    {
      $_SESSION['status'] = "Failed to insert item";
      $_SESSION['status_code'] = 'error';
    }
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

          <div class="card card-outline mt-2">
          <div class="card-header text-center bg-primary">
              <b>
                <h5 class="m-0">Add New Equipment to Database</h5>
              </b>
            </div>
            <div class="card-body">

              <!-- Form -->
              <form action="" method="post">

                <div class="row">

                  <div class="col-md-6">
                  <div class="form-group">
                      <label>Item Name</label>
                      <input type="text" class="form-control" placeholder="Enter item name" name="txtitem_name"
                        required>
                    </div>


                    <!-- select -->
                    <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="txtstatus" required>
                                <option value="" disabled selected>Select Status</option>
                                <option>CheckedIn</option>
                                 <option>CheckedOut</option>
                                 <option>Broken</option>
                                 <option>Missing</option>
                            </select>
                      </div>
                    <!-- select ends here -->

                    <div class="form-group">
                      <label>Barcode</label>
                      <input type="text" class="form-control" placeholder="Will be generated automatically" name="txtbarcode">
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
                          while($row = $select->fetch(PDO::FETCH_ASSOC))
                          {
                            extract($row);
                        ?>
                            <option><?php echo $row['category'];?></option>
                        <?php
                          }
                        ?>
                      </select>
                    </div>
                    <!-- select ends here -->

                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary" name="btnsave">Save Item</button>
                    </div>

                  </div>

                  <div class="col-md-6">
                  <div class="form-group">
                      <label>Asset Tag</label>
                      <input type="text" class="form-control" placeholder="Enter asset tag/serial" name="txtasset_tag"
                        required>
                    </div>

                    <div class="form-group">
                      <label>Item Description</label>
                      <textarea class="form-control" placeholder="Enter item description (optional)"
                        name="txtdescription" row="4"></textarea>
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