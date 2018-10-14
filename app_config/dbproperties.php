<?php
require_once 'mysqlcon.php';

//Create query

$home_detailsqry="SELECT * FROM home";
$hresult=mysqli_query($link,$home_detailsqry);

//Check whether the query was successful or not
if($hresult) {
    if(mysqli_num_rows($hresult) > 0) {
        $homerow = mysqli_fetch_assoc($hresult);
        $GLOBALS['home_name']=$homerow['home_name'];
        $GLOBALS['home_tax']=($homerow['is_tax']==1)?true:false;
    }
}
?>
