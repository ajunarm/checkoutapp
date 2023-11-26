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
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Barcode Sticker Generation</h1>
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

                    <div class="card card-primary card-outline">
                        <!-- <div class="card-header">
                            <h5 class="m-0">Generate Barcode Stickers</h5>
                        </div> -->
                        <div class="card-body">
                            <form class="form-horizontal" method="post" action="barcode/barcode.php" target="_blank">

                            <?php
                                $id = $_GET['id'];
                                $select = $pdo->prepare("SELECT * FROM tbl_items WHERE itemid='$id'");
                                $select->execute();

                                while ($row = $select->fetch(PDO::FETCH_ASSOC))
                                {
                                    echo'
                                    <div class="row">

                                    <div class="col-md-12">
                                        <center>
                                            <p class="list-group-item-info"><b>PRINT BARCODE</b></p>
                                        </center>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="item">Item:</label>
                                            <div class="col-sm-12">
                                                <input autocomplete="OFF" type="text" value="'.$row['item'].'" readonly class="form-control" id="item"
                                                    name="item" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="barcode">Barcode:</label>
                                            <div class="col-sm-12">
                                                <input autocomplete="OFF" type="text" value="'.$row['barcode'].'" readonly class="form-control" id="barcode"
                                                    name="barcode">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-3" for="rate">Asset Tag</label>
                                            <div class="col-sm-12">
                                                <input autocomplete="OFF" type="text" class="form-control"
                                                    id="asset_tag" name="asset_tag" value="'.$row['asset_tag'].'" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label col-sm-5" for="print_qty">Barcode
                                                Quantity</label>
                                            <div class="col-sm-12">
                                                <input autocomplete="OFF" value=1 type="print_qty" class="form-control" id="print_qty" name="print_qty">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-primary">Print Barcode</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                                    ';
                                }
                            ?>

                            </form>
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