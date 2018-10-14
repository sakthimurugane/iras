<?php
//Page settings

if(!isset($_GET['invoiceid'])){
    
    if(isset($_SERVER['HTTP_REFERER'])){
        header("location:" . $_SERVER['HTTP_REFERER']);
    }else{
        header("location: index.php");
    }
    exit();
    
} else{

    $error_flag=false;
    $error_msg='';
include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once 'utilities.php';

$created_by='SYSTEM';
if(isset($_SESSION['SESS_MEMBER_ID'])){
    $created_by=$_SESSION['SESS_MEMBER_ID'];
}

$invoiceid = clean($_REQUEST['invoiceid']);

if(isset($_POST['UpdateDueAmount'])){
    $newamount = $_POST['newAdvance'];
    
    if($newamount <=0){
        $error_flag=true;
        $error_msg="Invalid amount";
    }else{
        
        $advance=0;
        $bamount=0;
        $getdetails="select * from invoice_details where invoice_id=$invoiceid and is_deleted=0";
        if($result=mysqli_query($link,$getdetails)){
            $row = $result->fetch_assoc();
            $advance=$row['advance_amount'];
            $bamount=$row['billed_amount'];
        }else{
            $error_flag=true;
            $error_msg='Error while getting Ordernum from Invoice';
        }
        $advance = $advance + $newamount;
        if(!$error_flag){
            $delinvoiceqry="";
            
            if($advance >= $bamount){
                //Bill done
                $delinvoiceqry="update invoice_details set modified_on=now(),modified_by='$created_by',payment_status='C', due_date=null, advance_amount=$advance where invoice_id=$invoiceid and is_deleted=0";
                
            }else{
                //Still in Pending status
                $delinvoiceqry="update invoice_details set modified_on=now(),modified_by='$created_by',due_date=DATE_ADD(now(), INTERVAL 5 DAY),advance_amount=$advance where invoice_id=$invoiceid and is_deleted=0";
                
            }
            if ($link->query($delinvoiceqry) === FALSE) {
                $error_flag=true;
                $error_msg="Error: while updating amount" . $link->error;
            } else{
                $error_msg = "Updated successfully";
            }
            
        }
        
        

    }
}


$ordernum=0;
$invdate='';
$invduedate='';
$invadvance=0;
$invbalance=0;
$invbamount=0;
$invtype='';
$paystatus='';
$cashpaid=0;
$cashchange=0;
$cashbalance=0;
$taxflag=false;
$searchorderqry="select * from invoice_details where invoice_id=$invoiceid and is_deleted=0";
if($result=mysqli_query($link,$searchorderqry)){
    $row = $result->fetch_assoc();
    $ordernum=$row['ordernum'];
    $invdate=$row['bill_date'];
    $invadvance=$row['advance_amount'];
    $invtype=$row['payment_type'];
    $invduedate=$row['due_date'];
    $invbamount=$row['billed_amount'];
    $paystatus=$row['payment_status'];
    $cashpaid=$row['cash_paid'];
    $taxflag=($row['is_taxed']==1)?true:false;
}else{
    $error_flag=true;
    $error_msg='Error while getting Ordernum from Invoice';
}

$cashbalance = $invbamount - $cashpaid;
$cashchange = $cashpaid - $invbamount;
$invbalance = $invbamount - $invadvance;

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Payment Details</li>
      </ol>

       <?php
       if($error_flag) {
           echo '<div class="alert alert-danger alert-dismissible">',$error_msg,'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
       }else{
           if(!trim($error_msg)==''){
               echo '<div class="alert alert-success alert-dismissible">',$error_msg,'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
               
           }
       }
          ?>

       <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header bg-warning">
          <i class="fa fa-money"></i> Update Due Amount
          </div>


        <div class="card-body">
        <?php if($paystatus=='S'){ ?>
        	<form method="post">
        	<label class=" text-center btn" >Amount &#8377;</label>
			<input  type="number" name="newAdvance" placeholder="0.00" min="1" required>
			<button class=" text-center btn btn-success btn-sm btn-default" type="submit" name="UpdateDueAmount"><i class="fa fa-floppy"> Update</i></button>
        	<input  type="hidden" name="invoiceid" value="<?php echo $invoiceid; ?>">
        	
        	</form>
        	
        <?php }else{
            
            ?>
            
            <label class=" text-center btn btn-success" >Cash Paid. No Due amount for clearence</label>
            
            <?php 
            
        }
        
        
        ?>
        </div>

      </div>
      
             <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header bg-warning">
          <i class="fa fa-credit-card"></i> Last Payment Details
          </div>


        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Invoice ID</th>
                  <th>Payment Type</th>
                  <th>Bill Amount</th>
                  <th>
                  
                  <?php 
                  if($invtype=='credit'){
                      echo "Cash Advance";
                  }elseif($invtype=='cash'){
                      
                      echo "Cash Paid";
                  }
                      
                  ?>
                  
                  </th>
                  <th>
                  <?php 
                  if($invtype=='credit'){
                      echo "Due Date";
                  }elseif($invtype=='cash'){
                      
                      echo "Change";
                  }
                      
                  ?>                  
                  
                  </th>
                  <th>Balance Amount</th>
                  </tr>
              </thead>

              <tbody>
                  
                  <tr>
                  <td><?php echo getCustomDate($invdate); ?></td>
                  <td><?php echo $invoiceid; ?></td>
                  <td><?php echo $invtype; ?></td>
                  <td><?php echo '&#8377; '.formatMoney($invbamount,true);  ?> </td>
                  <td><?php 
                  
                    if($invtype=='credit'){
                        echo '&#8377; '.formatMoney($invadvance,true);
                    }elseif($invtype=='cash'){
                        
                        echo '&#8377; '.formatMoney($cashpaid,true);
                    }
                    
                    
                    ?>
                    </td>
                  <td><?php 
                  
                   
                  
                  if($invtype=='credit'){
                      echo $invduedate;
                  }elseif($invtype=='cash'){
                      
                      echo '&#8377; '.formatMoney($cashchange,true);
                  }
                  
                  
                  ?></td>
                  <td>
                  <?php 
                  
                  
                  if($invtype=='credit'){
                      echo '&#8377; '.formatMoney($invbalance,true);
                  }elseif($invtype=='cash'){
                      if($cashbalance <= 0){
                          echo '&#8377; '.formatMoney(0,true);
                      }else{
                      echo '&#8377; '.formatMoney($cashbalance,true);
                      }
                  }
                  
                  
                  ?>
                  </td>
                  </tr>
               
                
                </tbody>
                </table>
                </div>
                </div>

      </div>
      
             <!-- products DataTables Card-->
      <div class="card mb-3">
        <div class="card-header bg-warning">
          <i class="fa fa-list-alt"></i> Purchased Items
          </div>


        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>HSN/SAC</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Amount</th>
                </tr>
              </thead>

              <tbody>
                <?php 
                $purchaselist="SELECT * from sales_order where is_deleted=0  and ordernum='$ordernum' order by sale_id asc";
                $totalpurchase=0;
                $taxamount=0;
                $result=mysqli_query($link,$purchaselist);
                if($result) {
                    if(mysqli_num_rows($result) > 0) {
                        while($row = $result->fetch_assoc()){
                            $totalpurchase += $row['bill_amount'];
                            ?>
                            
                                <tr>
                                  <td><?php echo $row['item_name']; ?></td>
                                  <td><?php echo $row['item_hsn']; ?></td>
                                  <td><?php echo $row['bill_qty']; ?></td>
                                  <td><?php echo '&#8377; '.formatMoney($row['bill_price'],true); ?></td>
                                  <td><?php echo '&#8377; '.formatMoney($row['bill_amount'],true); ?></td>
                                </tr>
                            
                            <?php 
                            
                        }
                    }
                }
                
                if($taxflag){
                    
                    $purchaselist="SELECT * from sales_tax where is_deleted=0  and ordernum='$ordernum'";
                    $result=mysqli_query($link,$purchaselist);
                    if($result) {
                        if(mysqli_num_rows($result) > 0) {
                            while($row = $result->fetch_assoc()){
                                $taxamount += $row['tax_amount'];
                            
                        }
                    }
                }
                
                ?>
                            
                                <tr>
                                  <td colspan="4"><div class="text-right"><strong>GST: </strong></div></td>
                                  <td><div class="text-left"><strong><?php echo '&#8377; '.formatMoney($taxamount,true); ?></strong></div></td>
                                </tr>
                            <?php 
                            
                            
                            $totalpurchase += $taxamount;
                    
                }
                ?>
                			<tr>
                                  <td colspan="4"><div class="text-right"><strong>Total: </strong></div></td>
                                  <td><div class="text-left"><strong><?php echo '&#8377; '.formatMoney($totalpurchase,true); ?></strong></div></td>
                                </tr>
                
                </tbody>
                </table>
                </div>
                </div>

      </div>
      
      
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->


<?php 

}
include_once 'footer.php';

?>