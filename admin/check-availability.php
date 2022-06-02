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
    echo "<span style='color:red'> L'e-mail existe déjà .</span>";
        } else {
            echo "<span style='color:green'> E-mail disponible pour l'inscription .</span>";
        }
     }
    }

    if(!empty($_POST["oldpassword"])) {
    $pass=$_POST["oldpassword"];
    $result ="SELECT password FROM userregistration WHERE password=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('s',$pass);
    $stmt->execute();
    $stmt -> bind_result($result);
    $stmt -> fetch();
    $opass=$result;
    if($opass==$pass) 
    echo "<span style='color:green'> Mot de passe correct.</span>";
    else echo "<span style='color:red'> Le mot de passe ne correspond pas!</span>";
    }


    if(!empty($_POST["roomno"])) {
    $roomno=$_POST["roomno"];
    $result ="SELECT count(*) FROM registration WHERE roomno=?";
    $stmt = $mysqli->prepare($result);
    $stmt->bind_param('i',$roomno);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
    if($count>0)
    echo "<span style='color:red'>$count. Places déjà complets.</span>";
    else
        echo "<span style='color:red'>Tous les Places sont disponibles</span>";
    }
?>