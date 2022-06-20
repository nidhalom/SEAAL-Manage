<?php
    require_once("../includes/dbconn.php");
    if(!empty($_POST["emailid"])) {
        $email= $_POST["emailid"];
        if (filter_var($email, FILTER_VALIDATE_EMAIL)===false) {

            echo "erreur : Vous n'avez pas saisi d'email valide.";
        } else {
            $result ="SELECT count(*) FROM userRegistration WHERE email=?";
            $stmt = $mysqli->prepare($result);
            $stmt->bind_param('s',$email);
            $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if($count>0){
    echo "<span style='color:red'> Email exist déja .</span>";
        } else {
            echo "<span style='color:green'> Email valable pour inscrit .</span>";
        }
     }
    }

    if(!empty($_POST["oldpassword"])) {
    $pass=$_POST["oldpassword"];
    $result ="SELECT password FROM admin WHERE password=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('s',$pass);
    $stmt->execute();
    $stmt -> bind_result($result);
    $stmt -> fetch();
    $opass=$result;
    if($opass==$pass) 
    echo "<span style='color:green'> Mot de passe erroné!.</span>";
    else echo "<span style='color:red'> Mot de passe correct </span>";
    }
?>