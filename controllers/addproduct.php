<?php

require_once '../controllers/authcontroller.php';
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';
require_once '../dash/utilities.php';
//Function to sanitize values received from the form. Prevents SQL injection



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
$created_by='SYSTEM';

//print_r($_REQUEST);

if(isset($_SESSION['SESS_MEMBER_ID'])){
    $created_by=$_SESSION['SESS_MEMBER_ID'];
}
if(isset($_POST['addprodsubmit'])){
    $productname=clean($_POST['apname']);
    $productcode=clean($_POST['apcode']);
    $hsnsac=clean($_POST['aphsn']);
    $quantity=clean($_POST['apqty']);
    $alerqty=clean($_POST['apaqty']);
    if(trim($quantity)==''){
        $quantity=0;
    }
    $oprice=clean($_POST['apoprice']);
    if(trim($oprice)==''){
        $oprice=0;
    }
    $sprice=clean($_POST['apsprice']);
    if(trim($sprice)==''){
        $sprice=0;
    }
    $arrivaldate=clean($_POST['apardate']);
    if(trim($arrivaldate)==''){
        $arrivaldate=date('Y-m-d',mktime());
    }
    $expirydate=clean($_POST['apexdate']);
    if(trim($expirydate)==''){
        $expirydate=date('Y-m-d',mktime());
    }
    
    $supplierid=clean($_POST['apsupid']);
    if($supplierid=='None'){
        
        $supplierid=0;
    }
}else{

    $_SESSION['ERRMSG_ADDPRODUCT']="Unauthorized access";
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/products.php");
    }
    exit();
}

 //2. Insert product details
 
    $tempprofit=$sprice-$oprice;
    $newproductquery = "INSERT INTO products (product_code, product_name, hsnsac, o_price, s_price, quantity,profit, supplier_id, arrival_date, expiry_date,created_on,created_by,alert_qty)".
        "values ('$productcode','$productname','$hsnsac','$oprice','$sprice',$quantity,$tempprofit,$supplierid,'$arrivaldate', '$expirydate',now(),'$created_by',$alerqty)";
    
    if ($link->query($newproductquery) === TRUE) {
        $productid = $link->insert_id;
        echo "New record created successfully. Last inserted ID is: " . $productid;
    } else {
        echo "Error: " . $productid . "<br>" . $link->error;
        $errflag=true;
        $errmsg="Error while inserting profile details. $newproductquery ".$link->error;
    }    
    $link->close();
    
    if($errflag){
        $_SESSION['ERRMSG_ADDPRODUCT']=$errmsg;
    }else{
        $_SESSION['SCSMSG_ADDPRODUCT']="New Product with ID: " .$productid." has been added into system";
    }
    
    if(isset($_SERVER['HTTP_REFERER'])){
    header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/products.php");
    }
?>