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
                <h5 class="m-0">List of Equipment</h5>
              </b>
            </div>
            <div class="card-body">
              <table id="table_items" class="table table-striped table-hover">

                <thead>
                  <tr>
                    <th>#</td>
                    <th>Equipment</th>
                    <th>Status</th>
                    <th>Barcode</th>
                    <th>Category</th>
                    <th>AssetTag</th>
                    <!-- <td>description</td> -->
                    <!-- // <td>' . $row['description'] . '</td> -->
                    <th>ActionItems</th>
                  </tr>
                </thead>

                <tbody>
                  <?php

                  $select = $pdo->prepare("SELECT * FROM tbl_items ORDER BY itemid ASC");
                  $select->execute();

                  while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                    echo '
                                <tr>
                                    <td>' . $row['itemid'] . '</td>
                                    <td>' . $row['item'] . '</td>
                                    <td>' . $row['current_status'] . '</td>
                                    <td>' . $row['barcode'] . '</td>
                                    <td>' . $row['category'] . '</td>
                                    <td>' . $row['asset_tag'] . '</td>
                                    <td>
                                    <div class="btn-group"> 
                                    <a href="printbarcode.php?id=' . $row['itemid'] . '" class="btn btn-dark btn-xs" role="button"><span class="fa fa-barcode" style="color:#ffffff" data-toggle="tooltip" title="Print Barcode"></span></a>
                                    

                                    <a href="viewitem.php?id=' . $row['itemid'] . '" class="btn btn-warning btn-xs" role="button"><span class="fa fa-eye" style="color:#ffffff" data-toggle="tooltip" title="View Item"></span></a>
                                    

                                    <a href="edititem.php?id=' . $row['itemid'] . '" class="btn btn-success btn-xs" role="button"><span class="fa fa-edit" style="color:#ffffff" data-toggle="tooltip" title="Edit Item"></span></a>

                                    <button id=' . $row['itemid'] . '" class="btn btn-danger btn-xs btndelete" name="btndelete" title="Delete Item"><i class="fa fa-trash-alt"></i></button>
                                    </div>
                                        
                                    </td>
                                </tr>
                                ';
                  }

                  ?>
                </tbody>
                <tfoot>
                  <tr>
                    <td>#</td>
                    <td>Equipment</td>
                    <td>Status</td>
                    <td>Barcode</td>
                    <td>Category</td>
                    <td>Asset Tag</td>
                    <td>Action Items</td>
                  </tr>
                </tfoot>
              </table>
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

<script>
  $(document).ready(function () {
    $('#table_items').DataTable();
  });
</script>

<script>

  $(document).ready(function () {
    $('.btndelete').click(function () {
      var tdh = $(this);
      var id = $(this).attr("id");


      Swal.fire({
        title: "Are you sure you want to delete this item",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then((result) => {
        if (result.isConfirmed) {


          $.ajax({
            url: 'itemdelete.php',
            type: "POST",
            data: {
              item_id: id
            },
            success: function (data) {
              tdh.parents('tr').hide();
            }
          });

          Swal.fire({
            title: "Deleted!",
            text: "Item deleted successfully",
            icon: "success"
          });
        }
      });


    });
  });
</script>
