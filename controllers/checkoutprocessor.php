<?php

require_once '../controllers/authcontroller.php';
require_once '../app_config/mysqlcon.php';
require_once '../dash/utilities.php';

print_r($_REQUEST);

/**
 * input parameters
 * 
 * Array ( [cnd] => gopal 
 * [pt] => cash 
 * [paidamt] => 700 
 * [allowtax] => 
 * [ordernum] => 09201809225852 
 * [billamount] => 635.58 
 * [taxedamt] => 41.58 
 * [checkoutSubmit] => )
 */

if(!isset($_POST['checkoutSubmit'])){
    
}else{
    $error_flag=false;
    $error_msg='';
    $dbtax=0;
    //Start processing invoicing the bill details
    $created_by='SYSTEM';
    if(isset($_SESSION['SESS_MEMBER_ID'])){
        $created_by=$_SESSION['SESS_MEMBER_ID'];
    }
    $cusname=trim(clean($_POST['cnd']));
    $cashpaid=$_POST['paidamt'];
    $billamount=$_POST['billamount'];
    $taxflag=(isset($_POST['excludetax']))?false:true;
    $ordernum=$_POST['ordernum'];
    $taxamount=$_POST['taxedamt'];
    $paymenttype=$_POST['pt'];
    $profitamt=$_POST['profitamt'];
    /**
     * 1. Process customer Id and name from sales page
     * 2. insert into invoice_details table
     * 3. update sales_order table
     * 4. insert taxed amount in sales_tax table
     **/
    
    if($taxflag){
        $dbtax=1;
        $taxinsqry="insert into SALES_TAX (ordernum,tax_amount,created_on,created_by) values".
        "('$ordernum',$taxamount,now(),'$created_by')";
        if ($link->query($taxinsqry) === TRUE) {
            echo "New record created successfully. Last inserted ID is: " . $link->insert_id;
        } else {
            $error_flag=true;
            echo "Error: " . $taxinsqry . "<br>" . $link->error;
        }  
    }else{
        $billamount -= $taxamount;
    }
    
    if(!$error_flag){
        $updatesalesorderqry="update sales_order set status='BILLED' , modified_on=now(), modified_by='$created_by' where is_deleted=0 and ordernum='$ordernum'";
        if ($link->query($updatesalesorderqry) === FALSE) {
            $error_flag=true;
            echo "Error: " . $updatesalesorderqry . "<br>" . $link->error;
        }  
    }
    
    //Code to reduce product quantity upon every billing
    if(!$error_flag){
        $billedprdqry="select product_id,bill_qty from sales_order where status='BILLED' and is_deleted=0 and ordernum='$ordernum'";
        
        
        $result=mysqli_query($link,$billedprdqry);
            
            if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = $result->fetch_assoc()){
                    
                    $pid=$row['product_id'];
                    $bqty=(int)$row['bill_qty'];
                    
                    if ($link->query("update products set quantity=quantity-$bqty, modified_on=now(), modified_by='$created_by' where product_id=$pid and is_deleted=0") === FALSE) {
                        $error_flag=true;
                        echo "Error: " . $updatesalesorderqry . "<br>" . $link->error;
                    } 
                    
                    
                    }
                
                }
            

        }else{
            $error_flag=true;
            echo "Error: -->" . $billedprdqry . "<br>" . $link->error;
        }
    }
    
    
    if(!$error_flag){
        
        $customerid=0;
        
        $hresult=mysqli_query($link,"select customer_id from customer where is_deleted=0 and customer_phone='$cusname'");
        if($hresult) {
            if(mysqli_num_rows($hresult) > 0) {
                while($taxrow=mysqli_fetch_assoc($hresult)){
                    $customerid=$taxrow['customer_id'];
                }
            }else{
                $customerid=0;
            }
        }else{
            $customerid=0;
        }
        
        if($customerid==0){
            echo "fallback - creating new customer";
            $createnewcust="insert into customer (customer_phone,created_on,created_by) values ('$cusname',now(),'$created_by')";
            if ($link->query($createnewcust) === TRUE) {
                $customerid=$link->insert_id;
            }
        }
        
        $insertinvoice="";
        if($paymenttype=='cash'){
            
            $insertinvoice="insert into INVOICE_DETAILS (ordernum,customer_id,payment_type,payment_status,bill_date,billed_amount,cash_paid,created_on,created_by,is_taxed,bill_profit) values ".
                "('$ordernum',$customerid,'$paymenttype','C',now(),$billamount,$cashpaid,now(),$created_by,$dbtax,$profitamt)";
        
        }elseif($paymenttype=='credit'){
            $insertinvoice="insert into INVOICE_DETAILS (ordernum,customer_id,payment_type,payment_status,bill_date,billed_amount,advance_amount,due_date,created_on,created_by,is_taxed,bill_profit) values ".
                "('$ordernum',$customerid,'$paymenttype','S',now(),$billamount,$cashpaid,DATE_ADD(now(), INTERVAL 10 DAY),now(),$created_by,$dbtax,$profitamt)";
        }
        echo $insertinvoice;
        if($link->query($insertinvoice)===TRUE){
            $invoiceid=$link->insert_id;
            
            header("location: ../dash/preview.php?invoiceid=$invoiceid");
        }else{
            
        }
    }
    
}


?>