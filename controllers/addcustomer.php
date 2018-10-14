<?php

require_once '../controllers/authcontroller.php';
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';
require_once '../dash/utilities.php';
//Function to sanitize values received from the form. Prevents SQL injection



//Validation error flag
$errflag = false;
$errmsg="";

$supplierid=1;
//Default values
$suppliername="";
$spmobile="";
$supplieremail="";
$spaddress="";
$spitems="";

$created_by='SYSTEM';

//print_r($_REQUEST);

if(isset($_SESSION['SESS_MEMBER_ID'])){
    $created_by=$_SESSION['SESS_MEMBER_ID'];
}
if(isset($_POST['addcustsubmit'])){
    $suppliername=clean($_POST['spname']);
    $spmobile=clean($_POST['spmobile']);
    $supplieremail=clean($_POST['spemail']);
    $spaddress=clean($_POST['spaddress']);
    $spitems=clean($_POST['note']); 
}else{
    
    
    $_SESSION['ERRMSG_ADDCUSTOMER']="Unauthorized access";
    
    
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/customers.php");
    }
    exit();
}

 //2. Insert supplier details
 
    $newsupplierquery = "INSERT INTO customer (customer_name, customer_phone, customer_mail, customer_address, remarks,created_on, created_by)".
        "values ('$suppliername','$spmobile','$supplieremail','$spaddress','$spitems',now(),'$created_by')";
    
    if ($link->query($newsupplierquery) === TRUE) {
        $supplierid = $link->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $supplierid;
    } else {
        echo "Error: " . $newsupplierquery . "<br>" . $link->error;
        $errflag=true;
        $errmsg="Error while inserting customer details. ".$link->error;
    }    
    $link->close();
    
    if($errflag){
        $_SESSION['ERRMSG_ADDCUSTOMER']=$errmsg;
    }else{
        $_SESSION['SCSMSG_ADDCUSTOMER']="New customer with ID: " .$supplierid." has been added into system";
    }
    
    if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/customers.php");
    }
?>