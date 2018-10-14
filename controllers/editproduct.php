<?php

require_once '../controllers/authcontroller.php';
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';

//Function to sanitize values received from the form. Prevents SQL injection
require_once '../dash/utilities.php';


//Validation error flag
$errflag = false;
$errmsg="";
$productid=0;
//Default values
$productname="";
$hsnsac="";
$productcode="";
$quantity="";
$oprice="";
$sprice="";
$arrivaldate=date('Y-m-d',mktime());
$expirydate=date('Y-m-d',mktime());
$supplierid="";
$modifiedby='SYSTEM';

//print_r($_REQUEST);

if(isset($_SESSION['SESS_MEMBER_ID'])){
    $modifiedby=$_SESSION['SESS_MEMBER_ID'];
}
if(isset($_POST['modproductsubmit']) && isset($_POST['spid'])){
    $productid=clean($_POST['spid']);
    $productname=clean($_POST['epname']);
    $productcode=clean($_POST['epcode']);
    $hsnsac=clean($_POST['ephsn']);
    $quantity=clean($_POST['epqty']);
    $alerqty=clean($_POST['epaqty']);
    if(trim($quantity)==''){
        $quantity=0;
    }
    $oprice=clean($_POST['epoprice']);
    if(trim($oprice)==''){
        $oprice=0;
    }
    $sprice=clean($_POST['epsprice']);
    if(trim($sprice)==''){
        $sprice=0;
    }
    $arrivaldate=clean($_POST['epardate']);
    if(trim($arrivaldate)==''){
        $arrivaldate=date('Y-m-d',mktime());
    }
    $expirydate=clean($_POST['epexdate']);
    if(trim($expirydate)==''){
        $expirydate=date('Y-m-d',mktime());
    }
    $supplierid=clean($_POST['epsupid']);
    if($supplierid=='None'){
        
        $supplierid=0;
    }
}else{
    
    
    $_SESSION['ERRMSG_MODPRODUCT']="Unauthorized access";
    
    
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/products.php");
    }
    exit();
}

//2. Insert product details
$tempprofit=$sprice-$oprice;
$modproductquery = "UPDATE products set alert_qty=$alerqty, product_code='$productcode', product_name='$productname', hsnsac='$hsnsac', quantity=$quantity, profit=$tempprofit, o_price='$oprice' , s_price='$sprice', supplier_id=$supplierid, arrival_date='$arrivaldate', expiry_date='$expirydate', modified_on=now(), modified_by='$modifiedby' WHERE product_id=$productid and is_deleted=0";
if ($link->query($modproductquery) === TRUE) {
    echo "New record created successfully. Last inserted ID is: " . $productid;
} else {
    echo "Error: " . $modproductquery . "<br>" . $link->error;
    $errflag=true;
    $errmsg="Error while updating product details. $modproductquery ".$link->error;
}
$link->close();

if($errflag){
    $_SESSION['ERRMSG_MODPRODUCT']=$errmsg;
}else{
    $_SESSION['SCSMSG_MODPRODUCT']="Product ID: " .$productid." updated successfully";
}

if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
}else{
    header("location: ../dash/customers.php");
}
?>