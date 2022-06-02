<?php 
 
    date_default_timezone_set('Africa/Algiers');
    //Here we define out main variables 
    $welcome_string="Bienvenu"; 
    $numeric_date=date("G"); 
    
    //Start conditionals based on military time 
    if($numeric_date>=5&&$numeric_date<12) 
    $welcome_string="Bonjour,"; 
    else if($numeric_date>=12&&$numeric_date<18) 
    $welcome_string="Bonne après-midi,"; 
    else if($numeric_date>=18&&$numeric_date<22) 
    $welcome_string="Bonsoir,";
    else if($numeric_date>=22||$numeric_date<5) 
    $welcome_string="Bonne nuit,"; 
    

         $aid=$_SESSION['id'];
         $ret="select * from admin where id=?";
         $stmt= $mysqli->prepare($ret) ;
         $stmt->bind_param('i',$aid);
         $stmt->execute();
         $res=$stmt->get_result();
                                        
         while($row=$res->fetch_object())
         {
    
    echo "<h3 class='page-title text-truncate text-dark font-weight-medium mb-1'>$welcome_string $row->username! </h3>"; }
 
?>