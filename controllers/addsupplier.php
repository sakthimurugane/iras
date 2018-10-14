<?php

require_once '../controllers/authcontroller.php';
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';

//Function to sanitize values received from the form. Prevents SQL injection
require_once '../dash/utilities.php';


//Validation error flag
$errflag = false;
$errmsg="";

$supplierid=1;
//Default values
$suppliername="";
$spmobile="";
$supplieremail="";
$spaddress="";
$contact="";
$spitems="";

$created_by='SYSTEM';

//print_r($_REQUEST);

if(isset($_SESSION['SESS_MEMBER_ID'])){
    $created_by=$_SESSION['SESS_MEMBER_ID'];
}
if(isset($_POST['addsuplsubmit'])){
    $suppliername=clean($_POST['spname']);
    $spmobile=clean($_POST['spmobile']);
    $supplieremail=clean($_POST['spemail']);
    $spaddress=clean($_POST['spaddress']);
    $contact=clean($_POST['spcontact']);
    $spitems=clean($_POST['note']); 
}else{
    
    
    $_SESSION['ERRMSG_ADDSUPPLIER']="Unauthorized access";
    
    
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/suppliers.php");
    }
    exit();
}

 //2. Insert supplier details
 
    $newsupplierquery = "INSERT INTO suppliers (supplier_name, supplier_phone, supplier_mail, supplier_address, contact_person, item_desc,created_on, created_by)".
        "values ('$suppliername','$spmobile','$supplieremail','$spaddress','$contact','$spitems',now(),'$created_by')";
    
    if ($link->query($newsupplierquery) === TRUE) {
        $supplierid = $link->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $supplierid;
    } else {
        echo "Error: " . $newsupplierquery . "<br>" . $link->error;
        $errflag=true;
        $errmsg="Error while inserting profile details. ".$link->error;
    }    
    $link->close();
    
    if($errflag){
        $_SESSION['ERRMSG_ADDSUPPLIER']=$errmsg;
    }else{
        $_SESSION['SCSMSG_ADDSUPPPLIER']="New Supplier with ID: " .$supplierid." has been added into system";
    }
    
    if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/suppliers.php");
    }
?>