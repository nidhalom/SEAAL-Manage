<?php
session_start();
include('../includes/dbconn.php');
include('../includes/check-login.php');
check_login();
if (isset($_POST['submit'])) {
    $roomno = $_POST['room'];
    $seater = $_POST['seater'];
    $feespm = $_POST['fpm'];
    $foodstatus = $_POST['foodstatus'];
    $stayfrom = $_POST['stayf'];
    $duration = $_POST['duration'];
    $regno = $_POST['regno'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $contactno = $_POST['contact'];
    $emailid = $_POST['email'];
    $gurname = $_POST['gname'];
    $gurrelation = $_POST['grelation'];
    $gurcntno = $_POST['gcontact'];
    $caddress = $_POST['address'];
    $ccity = $_POST['city'];
    $cpincode = $_POST['pincode'];
    $paddress = $_POST['paddress'];
    $pcity = $_POST['pcity'];
    $ppincode = $_POST['ppincode'];
    $query = "INSERT into  registration(roomno,seater,feespm,foodstatus,stayfrom,duration,regno,firstName,lastName,contactno,emailid,guardianName,guardianRelation,guardianContactno,corresAddress,corresCIty,corresPincode,pmntAddress,pmntCity,pmntPincode) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $rc = $stmt->bind_param('iiiisisssisssississi', $roomno, $seater, $feespm, $foodstatus, $stayfrom, $duration, $regno, $fname, $lname, $contactno, $emailid, $gurname, $gurrelation, $gurcntno, $caddress, $ccity, $cpincode, $paddress, $pcity, $ppincode);
    $stmt->execute();
    echo "<script>alert('Votre demande a été enregistrée!');</script>";
}
?>

<!DOCTYPE html>
<html dir="ltr" lang="en">
<!-- By Hibo -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="K.n & Dj.k">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>Réservation</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">

    <script>
    function getSeater(val) {
        $.ajax({
            type: "POST",
            url: "get-seater.php",
            data: 'roomid=' + val,
            success: function(data) {
                //alert(data);
                $('#seater').val(data);
            }
        });

        $.ajax({
            type: "POST",
            url: "get-seater.php",
            data: 'rid=' + val,
            success: function(data) {
                //alert(data);
                $('#fpm').val(data);
            }
        });
    }
    </script>

    <!-- By Hibo -->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-theme="light" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar" data-navbarbg="skin6">
            <?php include '../includes/client-navigation.php' ?>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar" data-sidebarbg="skin6">
                <?php include '../includes/client-sidebar.php' ?>
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <form method="POST">

                    <?php
                    $uid = $_SESSION['login'];
                    $stmt = $mysqli->prepare("SELECT emailid FROM registration WHERE emailid=? ");
                    $stmt->bind_param('s', $uid);
                    $stmt->execute();
                    $stmt->bind_result($email);
                    $rs = $stmt->fetch();
                    $stmt->close();

                    if ($rs) { ?>
                    <div class="alert alert-primary alert-dismissible bg-danger text-white border-0 fade show"
                        role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong>Info: </strong> vous avez reserver une salle!
                    </div>
                    <?php } else {
                        echo "";
                    }
                    ?>


                    <div class="col-7 align-self-center">
                        <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Réservation</h4>
                    </div>


                    <div class="row">


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Numéro du Salle</h4>
                                    <div class="form-group mb-4">
                                        <select class="custom-select mr-sm-2" name="room" id="room"
                                            onChange="getSeater(this.value);" onBlur="checkAvailability()" required
                                            id="inlineFormCustomSelect">
                                            <option selected>Sélectionner...</option>
                                            <?php $query = "SELECT * FROM rooms";
                                            $stmt2 = $mysqli->prepare($query);
                                            $stmt2->execute();
                                            $res = $stmt2->get_result();
                                            while ($row = $res->fetch_object()) {
                                            ?>
                                            <option value="<?php echo $row->room_no; ?>"> <?php echo $row->room_no; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <span id="room-availability-status" style="font-size:12px;"></span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- By Hibo -->


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Date de début</h4>
                                    <div class="form-group">
                                        <input type="date" name="stayf" id="stayf" value="<?php echo date("Y-m-d"); ?>"
                                            class="form-control" required>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Durée totale</h4>
                                    <div class="form-group mb-4">
                                        <input type="number" min="1" name="duration" id="duration" placeholder="Jours"
                                            class="form-control" required>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Places</h4>
                                    <div class="form-group">
                                        <input type="text" id="seater" name="seater" placeholder="Entrez Seater No."
                                            required class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Food Status</h4>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio1" value="1" name="foodstatus"
                                            class="custom-control-input">
                                        <label class="custom-control-label" for="customRadio1">Oui</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customRadio2" value="0" name="foodstatus"
                                            class="custom-control-input" checked>
                                        <label class="custom-control-label" for="customRadio2">Non</label>
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Frais par jour</h4>
                                    <div class="form-group">
                                        <input type="text" name="fpm" id="fpm" placeholder="Votre frais par jour"
                                            readonly class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>

                    <h4 class="card-title mt-5">Informations personnelles du Client</h4>

                    <div class="row">

                        <?php
                        $aid = $_SESSION['id'];
                        $ret = "SELECT * from userregistration where id=?";
                        $stmt = $mysqli->prepare($ret);
                        $stmt->bind_param('i', $aid);
                        $stmt->execute();
                        $res = $stmt->get_result();

                        while ($row = $res->fetch_object()) {
                        ?>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Numéro d'immatriculation</h4>
                                    <div class="form-group">
                                        <input type="text" name="regno" id="regno" value="<?php echo $row->regNo; ?>"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Nom</h4>
                                    <div class="form-group">
                                        <input type="text" name="fname" id="fname"
                                            value="<?php echo $row->firstName; ?>" class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Prénom</h4>
                                    <div class="form-group">
                                        <input type="text" name="lname" id="lname" value="<?php echo $row->lastName; ?>"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Email</h4>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" value="<?php echo $row->email; ?>"
                                            class="form-control" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Numéro de téléphone</h4>
                                    <div class="form-group">
                                        <input type="number" min="0" name="contact" id="contact"
                                            value="<?php echo "0" ?><?php echo $row->contactNo; ?>" class="form-control"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>


                    </div>

                    <h4 class="card-title mt-5">Information sur la Société</h4>

                    <div class="row">

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Raison Social</h4>
                                    <div class="form-group">
                                        <input type="text" name="gname" id="gname" class="form-control"
                                            placeholder="Entrez le Nom de la société" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Relation</h4>
                                    <div class="form-group">
                                        <input type="text" name="grelation" id="grelation" required class="form-control"
                                            placeholder="Relation du client avec la société">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Contact</h4>
                                    <div class="form-group">
                                        <input type="text" name="gcontact" id="gcontact" required class="form-control"
                                            placeholder="Entrez le numéro de contact de la société">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <h4 class="card-title mt-5">Informations sur l'adresse actuelle</h4>

                    <div class="row">

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Address</h4>
                                    <div class="form-group">
                                        <input type="text" name="address" id="address" class="form-control"
                                            placeholder="Entrez L'Address" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Ville</h4>
                                    <div class="form-group">
                                        <input type="text" name="city" id="city" class="form-control"
                                            placeholder="Entrez le Nom de la ville" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Postal Code</h4>
                                    <div class="form-group">
                                        <input type="text" name="pincode" id="pincode" class="form-control"
                                            placeholder="Entrez Postal Code" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <h4 class="card-title mt-5">Informations sur l'adresse permanente</h4>


                    <div class="row">

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-subtitle">
                                        <code>Ignorez cette case à cocher si vous avez une adresse permanente différente</code>
                                    </h6>
                                    <fieldset class="checkbox">
                                        <label>
                                            <input type="checkbox" value="1" name="adcheck"> Mon adresse permanente est
                                            la même que ci-dessus !
                                        </label>
                                    </fieldset>

                                </div>
                            </div>
                        </div>


                    </div>


                    <h5 class="card-title mt-5">Veuillez remplir le formulaire "SEULEMENT SI" vous avez une adresse
                        permanente différente !</h5>


                    <div class="row">


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Address</h4>
                                    <div class="form-group">
                                        <input type="text" name="paddress" id="paddress" class="form-control"
                                            placeholder="Entrez Address" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Ville</h4>
                                    <div class="form-group">
                                        <input type="text" name="pcity" id="pcity" class="form-control"
                                            placeholder="Entrez le nom de la ville" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Postal Code</h4>
                                    <div class="form-group">
                                        <input type="text" name="ppincode" id="ppincode" class="form-control"
                                            placeholder="Entrez le Postal Code" required>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>


                    <div class="form-actions">
                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success">Soumettre</button>
                            <button type="reset" class="btn btn-dark">Réinitialiser</button>
                        </div>
                    </div>


                </form>

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <?php include '../includes/footer.php' ?>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="../assets/libs/popper.js/dist/umd/popper.min.js"></script>
    <script src="../assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- apps -->
    <!-- apps -->
    <script src="../dist/js/app-style-switcher.js"></script>
    <script src="../dist/js/feather.min.js"></script>
    <script src="../assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
    <script src="../dist/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../dist/js/custom.min.js"></script>
    <!--This page JavaScript -->
    <script src="../assets/extra-libs/c3/d3.min.js"></script>
    <script src="../assets/extra-libs/c3/c3.min.js"></script>
    <script src="../assets/libs/chartist/dist/chartist.min.js"></script>
    <script src="../assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
    <script src="../dist/js/pages/dashboards/dashboard1.min.js"></script>


</body>

<!-- Custom Ft. Script Lines -->
<script type="text/javascript">
$(document).ready(function() {
    $('input[type="checkbox"]').click(function() {
        if ($(this).prop("checked") == true) {
            $('#paddress').val($('#address').val());
            $('#pcity').val($('#city').val());
            $('#ppincode').val($('#pincode').val());
        }

    });
});
</script>

<script>
function checkAvailability() {
    $("#loaderIcon").show();
    jQuery.ajax({
        url: "check-availability.php",
        data: 'roomno=' + $("#room").val(),
        type: "POST",
        success: function(data) {
            $("#room-availability-status").html(data);
            $("#loaderIcon").hide();
        },
        error: function() {}
    });
}
</script>


<script type="text/javascript">
$(document).ready(function() {
    $('#duration').keyup(function() {
        var fetch_dbid = $(this).val();
        $.ajax({
            type: 'POST',
            url: "ins-amt.php?action=userid",
            data: {
                userinfo: fetch_dbid
            },
            success: function(data) {
                $('.result').val(data);
            }
        });


    })
});
</script>

</html>