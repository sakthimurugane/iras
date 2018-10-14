<?php
//Page settings
$_GLOBALS['ISTABLEPAGE']='true';

include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';

//Function to sanitize values received from the form. Prevents SQL injection
require_once 'utilities.php';

/**
 * 
 * @var string $servicelistqry
 */
$error_flag=false;
$error_msg='';
if(isset($_POST['delInvoice']) && !trim($_POST['invoiceid'])==''){
    $invid=$_POST['invoiceid'];
    $created_by='SYSTEM';
    if(isset($_SESSION['SESS_MEMBER_ID'])){
        $created_by=$_SESSION['SESS_MEMBER_ID'];
    }
    //Get order num details:
    $ordernum=0;
    $searchorderqry="select ordernum from invoice_details where invoice_id=$invid and is_deleted=0";
    if($result=mysqli_query($link,$searchorderqry)){
        $row = $result->fetch_assoc();
        $ordernum=$row['ordernum'];
        
    }else{
        $error_flag=true;
        $error_msg='Error while getting Ordernum from Invoice';
    }
    if(!$error_flag){
        $delinvoiceqry="update invoice_details set is_deleted=1, modified_on=now(),modified_by='$created_by' where invoice_id=$invid and is_deleted=0";
        if ($link->query($delinvoiceqry) === FALSE) {
            $error_flag=true;
            $error_msg="Error: " . $delinvoiceqry . "<br>" . $link->error;
        }  
    }
    
    if(!$error_flag){
        $delinvoiceqry="update sales_order set status='CANCELLED', is_deleted=1, modified_on=now(),modified_by='$created_by' where ordernum='$ordernum' and is_deleted=0";
        if ($link->query($delinvoiceqry) === FALSE) {
            $error_flag=true;
            $error_msg="Error: " . $delinvoiceqry . "<br>" . $link->error;
        }  
    }
    
    //Code to reduce product quantity upon every billing
    if(!$error_flag){
        $billedprdqry="select product_id,bill_qty from sales_order where status='CANCELLED' and is_deleted=1 and ordernum='$ordernum'";
        
        
        $result=mysqli_query($link,$billedprdqry);
        
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                while($row = $result->fetch_assoc()){
                    
                    $pid=$row['product_id'];
                    $bqty=(int)$row['bill_qty'];
                    
                    if ($link->query("update products set quantity=quantity+$bqty, modified_on=now(), modified_by='$created_by' where product_id=$pid and is_deleted=0") === FALSE) {
                        $error_flag=true;
                        $erro_msg="Error: " . $updatesalesorderqry . "<br>" . $link->error;
                    }
                    
                    
                }
                
            }
            
            
        }else{
            $error_flag=true;
            $error_msg="Error: -->" . $billedprdqry . "<br>" . $link->error;
        }
    }
    
    if(!$error_flag){
        $delinvoiceqry="update sales_tax set  is_deleted=1, modified_on=now(),modified_by='$created_by' where ordernum='$ordernum' and is_deleted=0";
        if ($link->query($delinvoiceqry) === FALSE) {
            $error_flag=true;
            $erro_msg= "Error: " . $delinvoiceqry . "<br>" . $link->error;
        }
    }
    
}

$servicelistqry="SELECT * from invoice_details where is_deleted=0 order by created_on desc";

if(isset($_REQUEST['filter']) && !trim($_REQUEST['filter']=='')){
    if($_REQUEST['filter']=='pending'){
        $servicelistqry="SELECT * from invoice_details where is_deleted=0 and payment_type='credit' order by created_on desc";
    }elseif($_REQUEST['filter']=='0'){
        $servicelistqry="SELECT * from invoice_details where is_deleted=0 and bill_date='".getTodayDate()."' order by created_on desc";
    }
}

$result=mysqli_query($link,$servicelistqry);

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Invoice inventory</li>
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
          
       <!-- customer DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-file-text"></i> Invoice management
          </div>
          
    
          <?php    
          if($result) {
           ?>

        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>Invoice ID</th>
                  <th>Amount</th>
                  <th>Profit</th>
                  <th>Type</th>
                  <th>Option</th>
                </tr>
              </thead>

              <tbody>
                
                <?php 
                if(mysqli_num_rows($result) > 0) { 
            while($row = $result->fetch_assoc()){
                
                
           ?>
                <tr>
                  <td><?php echo getCustomDate($row['bill_date']);?></td>
                  <td><?php 
  
                  echo $row['invoice_id'];
                  
                  if($row['is_taxed']==1){
                      ?>
                     <i class="fa fa-flag-checkered text-success" title="Tax included"></i>
                     <?php 
                  }
                  
                  ?></td>
                  <td><?php echo '&#8377; '.formatMoney($row['billed_amount'],true);?></td>
                  <td><?php echo '&#8377; '.formatMoney($row['bill_profit'],true);?></td>
                  <td>
                  
                  <div class="text-success"><i class="fa 
                  <?php 
                  
                  if($row['payment_type']=='cash'){
                      echo "fa-money";
                  }elseif($row['payment_type']=='credit'){
                      echo "fa-credit-card-alt";
                  }
                  else{
                      echo "fa-money";
                  }
                  
                  
                  ?>"></i>
                  </div>
                  </td>
                   <td class="text-center">
                   <div class=" text-center">

                   			<a href="payments.php?invoiceid=<?php echo $row['invoice_id'];?>"> <button class="btn btn-warning btn-sm btn-default btn-mini" title="View"><i class="fa fa-eye fa-1x"></i></button></a>
                            <a href="preview.php?invoiceid=<?php echo $row['invoice_id'];?>"> <button class="btn btn-success btn-sm btn-default btn-mini" title="View"><i class="fa fa-file-text-o fa-1x"></i></button></a>
                            <a data-toggle="modal" data-target="#deleteoption<?php echo $row['invoice_id'];?>"> <button class="btn btn-danger btn-sm btn-default btn-mini" title="Delete"><i class="fa fa-trash fa-1x"></i></button></a>
                    </div>
                        <!-- Modal to delete supplier-->
                        <div class="modal fade" id="deleteoption<?php echo $row['invoice_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel<?php echo $row['invoice_id'];?>" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog" style="width:30%;height:30%;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title text-success" id="myModalLabel<?php echo $row['invoice_id'];?>"><i class="fa fa-trash"></i> <span class="text-right"> Delete Invoice</span></h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    
                                    </div>
                                    <div class="modal-body">
                                    	Are you sure want to delete this Invoice ? <br/>
                                    	Invoice ID: <?php echo $row['invoice_id']; ?> &nbsp;<br/>
                                    	Date: <?php echo $row['bill_date']; ?>
                                    </div>
                                    <div class="modal-footer">
                                    <form method="post">
                                    	<input type="hidden" name="invoiceid" value="<?php echo $row['invoice_id']; ?>">
                                        <button name="delInvoice" class="btn btn-success"><i class="fa fa-trash"></i> Delete</button>
                                        <a class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-close"></i> Cancel</a>
                                     </form>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal --> 

                        
                  </td>
                </tr>
               <?php 
                
                }
                }
                ?>
                
                </tbody>
                </table>
                </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                
                <?php 
            }
            else{
                
                ?>
                              <div class="jumbotron">
                                  <h1>Oops!</h1> 
                                  <p>No Profiles found. Click on <label class="btn btn-success"><i class="fa fa-plus">Add Customers</i></label> button to create add new profile</p> 
                                </div>
                              <?php
                }
                ?>	

      </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->


<?php 
include_once 'footer.php';

?>