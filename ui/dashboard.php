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

<!-- table css -->
<style type="text/css">
  .tableFixHead {
    overflow: scroll;
    height: 570px;
    width: 2191px;
  }

  .tableFixHead thead th {
    position: sticky;
    top: 0px;
    z-index: 1;
  }

  table {
    border-collapse: collapse;
    width: 100px;
  }

  th,
  td {
    padding: 8px 16px;
  }

  th {
    background: #eee;
  }
</style>
<!-- end of table css -->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Main content -->
  <div class="content">

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">

          <div class="card card-outline  mt-2">
            <div class="card-header text-center bg-info">
              <b>
                <h5 class="m-0">CheckOut/CheckIn History</h5>
              </b>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <!-- <p class="list-group-item-info text-center"><b>CheckOut/CheckIn History</b></p> -->

                  <div class="row">
                    <div class="input-group mb-3">
                      <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                      </div>
                      <input type="text" class="form-control" placeholder="Scan Barcode" name="txtbarcode"
                        id="txtbarcode_id">

                      <button class="btn btn-primary ml-2" id="btnclearsearch" onclick="clearSearch()">Clear
                        Search</button>
                    </div>

                    <div class="tableFixHead">
                      <table class="table table-bordered table-striped table-hover" id="item_history_table">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Item</th>
                            <th>Status</th>
                            <th>CheckedOutTo</th>
                            <th>LastCheckedOut</th>
                            <th>LastCheckedIn</th>
                            <th>CheckedOutBy</th>
                            <th>CheckedInBy</th>
                            <th>Barcode</th>
                            <th>AssetTag</th>
                          </tr>
                        </thead>

                        <tbody class="details" id="itemtable">
                          <tr data-widget="expandable-table" aria-expanded="false"></tr>


                          <?php
                          $select = $pdo->prepare("SELECT * FROM tbl_items ORDER BY lastcheck_out DESC");
                          $select->execute();

                          while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                            echo '
                                <tr>
                                    <td>' . $row['itemid'] . '</td>
                                    <td>' . $row['item'] . '</td>
                                    <td>' . $row['current_status'] . '</td>
                                    <td>' . $row['checkout_to'] . '</td>
                                    <td>' . $row['lastcheck_out'] . '</td>
                                    <td>' . $row['lastcheck_in'] . '</td>
                                    <td>' . $row['checkout_by'] . '</td>
                                    <td>' . $row['checkin_by'] . '</td>
                                    <td>' . $row['barcode'] . '</td>
                                    <td>' . $row['asset_tag'] . '</td>
                                  </tr>
                                  ';
                          }
                          ?>

                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>

              </div>
            </div>
          </div>
          <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
        <div class="col-md-12 mb-3 text-center">
          <a href="checkincheckout.php" class="btn btn-primary mx-auto d-block" style="width: 50%;">
            <b>CheckOut/CheckIn Items</b>
          </a>
        </div>
      </div>

    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include_once "footer.php";
?>

<script>
  //Initialize Select2 Elements
  $('.select2').select2()

  //Initialize Select2 Elements
  $('.select2bs4').select2({ theme: 'bootstrap4' })

  function addrow(itemid, item, current_status, checkout_to, lastcheck_out, lastcheck_in, checkout_by, checkin_by, barcode, asset_tag) {
    var tr = '<tr>' +
      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + itemid + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + item + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + current_status + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + checkout_to + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + lastcheck_out + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + lastcheck_in + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + checkout_by + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + checkin_by + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + barcode + '</span></td>' +

      '<td style="text-align: left; vertical-align: middle; fonts-size:17px;"><class="form-control item_c" name="item_arr[]" <span>' + asset_tag + '</span></td>' +
      '</tr>';

    $('.details').empty();
    $('.details').append(tr);
  };


  var itemarr = [];

  $(function () {
    $('#txtbarcode_id').on('change', function () {
      var barcode = $('#txtbarcode_id').val();

      $.ajax({
        url: "getitem.php",
        method: "get",
        dataType: "json",
        data: { id: barcode },
        success: function (data) {
          console.log(data);
          addrow(data['itemid'], data['item'], data['current_status'], data['checkout_to'], data['lastcheck_out'], data['lastcheck_in'], data['checkout_by'], data['checkin_by'], data['barcode'], data['asset_tag']);
        },
      });
    })
  });

  // clear search
  // clear search
  $(function () {
    // When the document is ready

    // Attach a click event handler to the button with id "btnclearserach"
    $('#btnclearserach').on('click', function () {
      // Reload the page
      location.reload();
    });
  });

  function clearSearch() {
    // Reload the page
    location.reload();
  }
</script>