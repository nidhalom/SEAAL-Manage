<?php
    session_start();
    include('../includes/dbconn.php');
    date_default_timezone_set('America/Chicago');
    include('../includes/check-login.php');
    check_login();
    $aid=$_SESSION['id'];
    if(isset($_POST['update']))
    {

    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $contactno=$_POST['contact'];
    $udate = date('d-m-Y h:i:s', time());
    $query="UPDATE  userRegistration set firstName=?,middleName=?,lastName=?,contactNo=?,updationDate=? where id=?";
    $stmt = $mysqli->prepare($query);
    $rc=$stmt->bind_param('sssisi',$fname,$mname,$lname,$contactno,$udate,$aid);
    $stmt->execute();
    echo"<script>alert('Le Profil a été mis à jour avec succès');</script>";
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
    <title>Mon Profile</title>
    <!-- Custom CSS -->
    <link href="../assets/extra-libs/c3/c3.min.css" rel="stylesheet">
    <link href="../assets/libs/chartist/dist/chartist.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../dist/css/style.min.css" rel="stylesheet">

    <!-- <script type="text/javascript">
    function valid(){
        if(document.registration.password.value!= document.registration.cpassword.value){
            alert("Password and Re-Type Password Field do not match !!");
            document.registration.cpassword.focus();
        return false;
            } return true;
     }
    </script> -->

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
            <?php include '../includes/client-navigation.php'?>
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
                <?php include '../includes/client-sidebar.php'?>
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
            <!-- By Hibo -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                <div class="col-7 align-self-center">
                    <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Mon Profile</h4>
                </div>


                <div class="row">

                    <?php	
                    $aid=$_SESSION['id'];
                        $ret="select * from userregistration where id=?";
                            $stmt= $mysqli->prepare($ret) ;
                        $stmt->bind_param('i',$aid);
                        $stmt->execute() ;//ok
                        $res=$stmt->get_result();
                        //$cnt=1;
                        while($row=$res->fetch_object())
                        {
                            ?>

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Dernière mise à jour le</h4>
                                <div class="form-group">
                                    <input type="text" value="<?php echo $row->updationDate; ?>" class="form-control"
                                        required readonly>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- By Hibo -->

                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Numéro d'immatriculation</h4>
                                <div class="form-group">
                                    <input type="text" class="form-control" value="<?php echo $row->regNo;?>" required
                                        readonly>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>


                <form name="registration" onSubmit="return valid();" method="POST">

                    <div class="row">

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Nom</h4>
                                    <div class="form-group">
                                        <input type="text" name="fname" id="fname" class="form-control"
                                            value="<?php echo $row->firstName;?>" required="required">
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Prénom</h4>
                                    <div class="form-group">
                                        <input type="text" name="lname" id="lname" class="form-control"
                                            value="<?php echo $row->lastName;?>" required="required">
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Email Address</h4>
                                    <div class="form-group">
                                        <input type="email" name="email" id="email" class="form-control"
                                            value="<?php echo $row->email;?>" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- By Hibo -->

                        <div class="col-sm-12 col-md-6 col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Numéro de téléphone</h4>
                                    <div class="form-group">
                                        <input type="text" name="contact" id="contact" maxlength="10"
                                            class="form-control" value="<?php echo "0" . $row->contactNo;?>"
                                            required="required">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php } ?>

                    </div>

                    <div class="form-actions">
                        <div class="text-center">
                            <button type="submit" name="update" class="btn btn-success">Changer</button>
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
    <!-- By Hibo -->
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

</html>