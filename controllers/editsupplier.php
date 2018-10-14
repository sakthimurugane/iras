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
$contact="";
$spitems="";

$modifiedby='SYSTEM';

//print_r($_REQUEST);

if(isset($_SESSION['SESS_MEMBER_ID'])){
    $modifiedby=$_SESSION['SESS_MEMBER_ID'];
}
if(isset($_POST['modsupplier']) && isset($_POST['spid'])){
    $supplierid=clean($_POST['spid']);
    $suppliername=clean($_POST['esname']);
    $spmobile=clean($_POST['esmobile']);
    $supplieremail=clean($_POST['esmail']);
    $spaddress=clean($_POST['esaddr']);
    $contact=clean($_POST['escontact']);
    $spitems=clean($_POST['esitems']);
}else{
    
    
    $_SESSION['ERRMSG_MODSUPPLIER']="Unauthorized access";
    
    
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/suppliers.php");
    }
    exit();
}

//2. Insert supplier details

$modsupplierquery = "UPDATE suppliers set supplier_name='$suppliername', supplier_phone='$spmobile', supplier_mail='$supplieremail', supplier_address='$spaddress', contact_person='$contact', item_desc='$spitems',modified_on=now(), modified_by='$modifiedby' WHERE supplier_id=$supplierid";
if ($link->query($modsupplierquery) === TRUE) {
    echo "New record created successfully. Last inserted ID is: " . $supplierid;
} else {
    echo "Error: " . $modsupplierquery . "<br>" . $link->error;
    $errflag=true;
    $errmsg="Error while updating supplier details. ".$link->error;
}
$link->close();

if($errflag){
    $_SESSION['ERRMSG_MODSUPPLIER']=$errmsg;
}else{
    $_SESSION['SCSMSG_MODSUPPPLIER']="Supplier ID: " .$supplierid." updated successfully";
}

if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
}else{
    header("location: ../dash/suppliers.php");
}
?>