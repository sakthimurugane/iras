<?php

require_once '../controllers/authcontroller.php';
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';

//Function to sanitize values received from the form. Prevents SQL injection
require_once '../dash/utilities.php';


//Validation error flag
$errflag = false;
$errmsg="";
$supplierid=0;
//Default values
$suppliername="";
$spmobile="";
$supplieremail="";
$spaddress="";
$spitems="";

$modifiedby='SYSTEM';

//print_r($_REQUEST);

if(isset($_SESSION['SESS_MEMBER_ID'])){
    $modifiedby=$_SESSION['SESS_MEMBER_ID'];
}
if(isset($_POST['modcustomer']) && isset($_POST['spid'])){
    $supplierid=clean($_POST['spid']);
    $suppliername=clean($_POST['esname']);
    $spmobile=clean($_POST['esmobile']);
    $supplieremail=clean($_POST['esmail']);
    $spaddress=clean($_POST['esaddr']);
    $spitems=clean($_POST['esitems']);
}else{
    
    
    $_SESSION['ERRMSG_MODCUSTOMER']="Unauthorized access";
    
    
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/customers.php");
    }
    exit();
}

//2. Insert supplier details

$modsupplierquery = "UPDATE customer set customer_name='$suppliername', customer_phone='$spmobile', customer_mail='$supplieremail', customer_address='$spaddress', remarks='$spitems',modified_on=now(), modified_by='$modifiedby' WHERE customer_id=$supplierid";
if ($link->query($modsupplierquery) === TRUE) {
    echo "New record created successfully. Last inserted ID is: " . $supplierid;
} else {
    echo "Error: " . $modsupplierquery . "<br>" . $link->error;
    $errflag=true;
    $errmsg="Error while updating customer details. ".$link->error;
}
$link->close();

if($errflag){
    $_SESSION['ERRMSG_MODCUSTOMER']=$errmsg;
}else{
    $_SESSION['SCSMSG_MODCUSTOMER']="Customer ID: " .$supplierid." updated successfully";
}

if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
}else{
    header("location: ../dash/customers.php");
}
?>