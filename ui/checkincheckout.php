<?php
// Set the timezone to Mountain Standard Time (MST)
date_default_timezone_set('America/Denver');

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

if (isset($_POST['checkOutButtonTxt'])) 
{
  $currentStatusTxt = "CheckedOut";
  $barcodeTxt = $_POST['checkoutBarcodeTxt'];
  $facultyNameTxt = $_POST['checkOutFacultyNameTxt'];
  $ticketIdTxt = $_POST['checkOutTicketIdTxt'];
  $checkoutTo = ucfirst($_POST['checkOutTechTxt']);
  $checkoutTime = date('Y-m-d H:i:s');
  $checkoutBy = ucfirst($_SESSION['username']);


  $update =  $pdo->prepare("UPDATE tbl_items SET current_status=:currentStatus, faculty_name=:facultyName, ticket_id=:ticketID, checkout_to=:checkoutTo, lastcheck_out=:checkoutTime, checkout_by=:checkoutBy WHERE barcode=$barcodeTxt");
  $update->bindParam(':currentStatus', $currentStatusTxt);
  $update->bindParam(':facultyName', $facultyNameTxt);
  $update->bindParam(':ticketID', $ticketIdTxt);
  $update->bindParam(':checkoutTo', $checkoutTo);
  $update->bindParam(':checkoutTime', $checkoutTime);
  $update->bindParam(':checkoutBy', $checkoutBy);

  if ($update->execute())
{
  $_SESSION['status'] = "Checkedout Successfully";
  $_SESSION['status_code'] = 'success';
  
}
else
{
  $_SESSION['status'] = "Failed to checkout item";
  $_SESSION['status_code'] = 'error';
}
}

if (isset($_POST['checkInButtonTxt'])) 
{
  $currentStatusTxt = "CheckedIn";
  $barcodeTxt = $_POST['checkInBarcodeTxt'];
  $facultyNameTxt = "";
  $ticketIdTxt = "";
  $checkinTime = date('Y-m-d H:i:s');
  $checkinBy = ucfirst($_SESSION['username']);

  $update =  $pdo->prepare("UPDATE tbl_items SET current_status=:currentStatus, faculty_name=:facultyName, ticket_id=:ticketID, checkin_by=:checkinBy, lastcheck_in=:checkinTime WHERE barcode=$barcodeTxt");
  $update->bindParam(':currentStatus', $currentStatusTxt);
  $update->bindParam(':facultyName', $facultyNameTxt);
  $update->bindParam(':ticketID', $ticketIdTxt);
  $update->bindParam(':checkinBy', $checkinBy);
  $update->bindParam(':checkinTime', $checkinTime);

  if ($update->execute())
  {
    $_SESSION['status'] = "Checkedin Successfully";
    $_SESSION['status_code'] = 'success';
    
  }
  else
  {
    $_SESSION['status'] = "Failed to checkin item";
    $_SESSION['status_code'] = 'error';
  }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- <div class="col-md-12 mb-1 mt-2">
          <a href="dashboard.php" class="btn btn-secondary btn-block">
            <center>
              <b>View CheckIn/Checkout History</b>
            </center>
          </a>
        </div> -->

  <!-- Main content -->
  <div class="content">
    <div class="container-fluid">
      <div class="row">

        <div class="col-lg-12">

          <div class="card card-outline mt-2">
            <div class="card-header text-center bg-primary">
              <h5 class="m-0">CHECKIN/CHECKOUT ITEMS</h5>
            </div>
            <div class="card-body">

              <div class="row">
                  <div class="col-md-6">
                  <p class="list-group-item-primary text-center"><b>CheckOut Item</b></p>
                <!-- CHECK OUT BARCODE SCANNER -->
                <!-- CHECK OUT BARCODE SCANNER -->
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control" placeholder="Scan Barcode" name="txtbarcode"
                    id="check_out_barcode_id">
                </div>
                </div>

                <!-- CHECK IN BARCODE SCANNER -->
                <!-- CHECK IN BARCODE SCANNER -->
                <div class="col-md-6">
                <p class="list-group-item-primary text-center"><b>CheckIn Item</b></p>
                <div class="input-group mb-1">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  <input type="text" class="form-control" placeholder="Scan Barcode" id="check_in_barcode_id">
                </div>
                </div>

                <form id="form1" action="" method="post" class="col">
                  <!-- Checkout item col -->
                  <div class="col-md-12">

                    <div class="form-group">
                      <ul class="list-group">
                        <li class="list-group-item" name="chkout_txt_item"><b>Item Name:</b> <span></span> 

                        <li class="list-group-item" name="checkout_txt_status"><b>Current Status:</b> <span></span> 

                        <li class="list-group-item" name="checkout_txt_barcode"><b>Barcode:</b> <span></span> 
                        <input hidden class="form-control" name="checkoutBarcodeTxt" type="text" id="checkoutBarcodeDB" required>
                        </li>

                        <li class="list-group-item" name="checkout_txt_checkout_to"><b>LastCheckedOut To:</b> <span></span> 

                        <li class="list-group-item" name="checkout_txt_category"><b>Category:</b> <span></span>  

                        <li class="list-group-item" ><b>Faculty Name:</b> <span></span>  
                        <input class="form-control" name="checkOutFacultyNameTxt" type="text" placeholder="Optional: Faculty receiving this equipment">
                        </li>

                        <li class="list-group-item" ><b>Ticket ID:</b> <input class="form-control" name="checkOutTicketIdTxt" type="text" placeholder="Required: Enter ticket id" required></li>

                        <!-- select -->
                        <li class="list-group-item"><b>Technician</b>
                          <select class="form-control" name="checkOutTechTxt" required>
                            <option value="" disabled selected>Select Technician</option>
                            <?php
                            $select = $pdo->prepare("SELECT * FROM tbl_user ORDER BY userid ASC");
                            $select->execute();
                            while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
                              extract($row);
                              ?>
                              <option>
                                <?php echo $row['username']; ?>
                              </option>
                              <?php
                            }
                            ?>
                          </select>
                        </li>
                        <!-- select ends here -->
                      </ul>
                    </div>

                    <div class="card-footer">
                      <div class="row">
                        <div class="col-md-12"> <!-- Use the entire width of the card footer -->
                          <button type="submit" class="btn btn-warning btn-block" name="checkOutButtonTxt" id="checkOutButton">Check Out</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- checkout item col ends here -->



                <!-- CHECK IN SECTION -->
                <!-- CHECK IN SECTION -->

                <!-- Checkin scan barcode input section ends here-->

                <!-- checkin item col starts here -->
                <form id="form2" action="" method="post" name="checkInForm" class="col">
                  <div class="col-md-12">

                    <div class="form-group">
                      <ul class="list-group">
                        <li class="list-group-item" name="checkin_txt_item"><b>Item Name:</b> <span></span></li>

                        <li class="list-group-item" name="checkin_txt_status"><b>Current Status:</b> <span></span></li>

                        <li class="list-group-item" name="checkin_txt_barcode"><b>Barcode:</b> <span></span></li>
                        <input hidden class="form-control" name="checkInBarcodeTxt" type="text"  id="checkInBarcodeDB">

                        <li class="list-group-item" name="checkin_txt_chekout_to"><b>LastCheckedOut To:</b> <span></span></li>

                        <li class="list-group-item" name="checkin_txt_checkout_by"><b>LastCheckedOut By:</b> <span></span></li>

                        <li class="list-group-item" name="checkin_txt_category"><b>Category:</b> <span></span></li>

                        <li class="list-group-item" name="checkin_txt_facult_name"><b>Faculty Name:</b> <span></span></li>

                        <li class="list-group-item" name="checkInTicketId"><b>Ticket Id:</b> <span></span></li>

                      </ul>
                    </div>

                    <div class="card-footer">
                      <div class="row">
                        <div class="col-md-12"> <!-- Use the entire width of the card footer -->
                          <button type="submit" class="btn btn-success btn-block" name="checkInButtonTxt" id="checkInButton">Check In</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
                <!-- checkin item col ends here -->

              </div>

            </div>
          </div>

        </div>

        

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->
  <div class="col-md-12 mb-2">
    <a href="dashboard.php" class="btn btn-info mx-auto d-block" style="width: 50%;">
        <b>View History</b>
    </a>
</div>
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

  function displayCheckOutInfo(itemarray) {
    $("li[name='chkout_txt_item'] span").text(itemarray['item']);
    $("li[name='checkout_txt_status'] span").text(itemarray['current_status']);
    $("li[name='checkout_txt_barcode'] span").text(itemarray['barcode']);
    $("li[name='checkout_txt_checkout_to'] span").text(itemarray['checkout_to']);
    $("li[name='checkout_txt_category'] span").text(itemarray['category']);
    $('#checkOutItemDB').val(itemarray['item']);
    $('#checkoutStatusDB').val(itemarray['current_status']);
    $('#checkoutBarcodeDB').val(itemarray['barcode']);
    $('#checkoutLastCheckOutToDB').val(itemarray['checkout_to']);
    $('#checkOutCategoryDB').val(itemarray['category']);
  }

  function displayCheckInInfo(itemarray) {
    $("li[name='checkin_txt_item'] span").text(itemarray['item']);
    $("li[name='checkin_txt_status'] span").text(itemarray['current_status']);
    $("li[name='checkin_txt_barcode'] span").text(itemarray['barcode']);
    $("li[name='checkin_txt_chekout_to'] span").text(itemarray['checkout_to']);
    $("li[name='checkin_txt_checkout_by'] span").text(itemarray['checkout_by']);
    $("li[name='checkin_txt_category'] span").text(itemarray['category']);
    $("li[name='checkin_txt_facult_name'] span").text(itemarray['faculty_name']);
    $("li[name='checkInTicketId'] span").text(itemarray['ticket_id']);
    // $('#checkOutItemDB').val(itemarray['item']);
    // $('#checkoutStatusDB').val(itemarray['current_status']);
    $('#checkInBarcodeDB').val(itemarray['barcode']);
    // $('#checkoutLastCheckOutToDB').val(itemarray['checkout_to']);
    // $('#checkOutCategoryDB').val(itemarray['category']);
  }

  var itemarray = [];
  $(function () {
    $('#check_in_barcode_id').on('input', function () {
      var barcode = $('#check_in_barcode_id').val();

      $.ajax({
        url: "getitem.php",
        method: "get",
        dataType: "json",
        data: { id: barcode },
        success: function (data) {
          displayCheckInInfo(data);
        },
      });
    })
  });

  $(function () {
    $('#check_out_barcode_id').on('change', function () {
      var barcode = $('#check_out_barcode_id').val();

      $.ajax({
        url: "getitem.php",
        method: "get",
        dataType: "json",
        data: { id: barcode },
        success: function (data) {
          displayCheckOutInfo(data);
        },
      });
    })
  });

  $(function () {
    // Disable the button initially
    $('#checkInButton').prop('disabled', true);

    // Add an input event listener to the scanner input
    $('#check_in_barcode_id').on('input', function () {
      // Enable the button when the input has a value
      $('#checkInButton').prop('disabled', $(this).val().trim() === '');
    });
  });

  $(function () {
    // Disable the button initially
    $('#checkOutButton').prop('disabled', true);

    // Add an input event listener to the scanner input
    $('#check_out_barcode_id').on('input', function () {
      // Enable the button when the input has a value
      $('#checkOutButton').prop('disabled', $(this).val().trim() === '');
    });
  });
</script>