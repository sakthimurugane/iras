<?php
require_once '../controllers/authcontroller.php';
require_once '../app_config/config.php';
require_once '../app_config/mysqlcon.php';

//Function to sanitize values received from the form. Prevents SQL injection
require_once '../dash/utilities.php';

//Validation error flag
$errflag = false;
$errmsg="";
//Default values


//print_r($_REQUEST);
$profileid='';
$modified_by='SYSTEM';
if(isset($_REQUEST['prid'])){
    $profileid=clean($_REQUEST['prid']);
    if(isset($_SESSION['SESS_MEMBER_ID'])){
        $modified_by=$_SESSION['SESS_MEMBER_ID'];
    }
}
else{
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: ../dash/products.php");
    }
    exit();
}



 //2. delete document details
 
$delcredqry = "UPDATE products set IS_DELETED=1, modified_on=now(), modified_by='$modified_by' where product_id=".$profileid;
    
if ($link->query($delcredqry) === FALSE) {
   
    echo "Error: " . $delcredqry . "<br>" . $link->error;
        $errflag=true;
        $errmsg="Error while deleting product. ".$link->error;
    }
    
    

    echo $errmsg;
    
    $link->close();
    
        if($errflag){
            $_SESSION['ERRMSG_DELPRODUCT']=$errmsg;
        }else{
            $_SESSION['SCSMSG_DELPRODUCT']="Product has been removed from the inventory";
        }
    
        if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
        }else{
            header("location: ../dash/products.php");
        }
?>