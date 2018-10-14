<?php
include_once '../controllers/authcontroller.php';
include_once '../app_config/mysqlcon.php';
require_once 'utilities.php';

$responseobject = array(
    "status"=>1,
    "prodid"=>null,
    "price"=>0
);




if(isset($_REQUEST['prodid']) && trim($_REQUEST['prodid']!='')){
    $prodquery="select s_price from products where is_deleted=0 and product_id=".clean($_REQUEST['prodid']);
        
    $result=mysqli_query($link,$prodquery);
    if($result) {
        if(mysqli_num_rows($result) == 1) {
            while($row = $result->fetch_assoc()){
                $responseobject['prodid']=$_REQUEST['prodid'];
                $responseobject['price']=$row['s_price'];
            }
        }
    }
}
header('Content-Type: application/json');
echo json_encode($responseobject);
?>