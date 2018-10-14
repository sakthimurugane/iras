<?php
//Page settings
$_GLOBALS['PRINTPAGE']='true';
$_GLOBALS['CALENDARPAGE']='true';


include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/mysqlcon.php';
include_once 'utilities.php';

//Shop details variable
$haddr1='';
$haddr2='';
$hstate='';
$hpin='';
$hemail='';
$hweb='';
$hphone='';
$hmobile='';
$hgstin='';

$d1='';
$d2='';
if($shopresult=mysqli_query($link,"select * from home")){
    $row = $shopresult->fetch_assoc();
    
    $haddr1=$row['address_1'];
    $haddr2=$row['address_2'];
    $hstate=$row['home_state'];
    $hpin=$row['home_pincode'];
    $hemail=$row['home_email'];
    $hweb=$row['home_address'];
    $hphone=$row['home_landline'];
    $hmobile=$row['home_mobile'];
    $hgstin=$row['home_gstin'];
    
}

$servicelistqry="SELECT * from invoice_details where is_deleted=0 and bill_date between now() and DATE_SUB(now(), INTERVAL 7 DAY)order by invoice_id desc";
if(isset($_POST['searchReport'])){
    $d1=clean($_POST['fromDate']);
    $d2=clean($_POST['toDate']);
    
    $servicelistqry = "select * from invoice_details where is_deleted=0 and bill_date between '$d1' and  '$d2' order by invoice_id desc";
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
        <li class="breadcrumb-item active">Sales Report</li>
      </ol>
       <?php
            if(isset($_SESSION['SALES_SEARCH'])) {
              echo '<div class="alert alert-danger alert-dismissible">',$_SESSION['SALES_SEARCH'],'<a href="#" aria-label="close" class="close" data-dismiss="alert">&times;</a></div><br>';
              unset($_SESSION['SALES_SEARCH']);
          }
          
          //echo $servicelistqry;
          //echo $link->error;
        ?>
       <!-- Suppliers DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-bar-chart"></i> Sales Report

          </div>
                                 
          <?php    
          if($result) {
           ?>

        <div class="card-body">
        
           <div>
                     <div class="table-responsive">
                     <form method="post">
                     <table class="table">
                     <tbody>
                     <tr>
                     <td class="text-left">From: <input class="tcal" type="text" name="fromDate" value="<?php if($d1!=''){echo $d1;}?>"></td>
                     <td class="text-left">To: <input class="tcal" type="text" name="toDate" value="<?php if($d2!=''){echo $d2;}?>"></td>
                     <td class="text-left">
                           <button name="searchReport" class="text-center btn btn-success btn-sm btn-default">
           					<i class="fa fa-search"></i> Search
							</button>
                     </td>
                     <td class="text-right">
                     		<label id="printbutton" name="printbutton" class="text-center btn btn-success btn-sm btn-default">
           					<i class="fa fa-print"></i> Print
							</label>
					</td>
                     </tr>
                     </tbody>
                     </table>
                     </form>
           			</div>
            </div>	
        <div id="printcontent">
        
        		<div style="width: 900px; float: left;">
            	<center>
            	<div style="font:bold 25px 'Aleo';">Sales Report</div>
            	<div style="font:bold 18px"><?php echo $GLOBALS['home_name']; ?></div>
            	<div><small><?php echo $haddr1.$haddr2; ?></small></div>
            	<div><small><?php echo $hstate.'-'.$hpin;?></small></div>
            	<div><small>GSTIN : <?php echo $hgstin; ?></small></div>
				<div><small>
				<?php if($hmobile!=''){
				    echo 'Mobile: '.$hmobile.' ,';
				    }
				    if($hphone!=''){
				        echo 'Phone: '.$hphone;
				    }
				?></small></div>
				<div><small>
					<?php if($hemail!=''){
					    echo 'Mail: '.$hemail;
				    }

				?>
				</small></div>
            	</center>

            	</div>

          	<div>&nbsp;</div>
            	
          <div class="table-responsive">
            <table cellpadding="3" cellspacing="0" border="1" style="font-family: arial; font-size: 12px;text-align:left;width : 100%;" id="resultTable">
              <thead>
                <tr>
                  <th>Bill date</th>
                  <th>Invoice no.</th>
                  <th>Type</th>
                  <th>Bill Amount</th>
                  <th>Profit</th>
                </tr>
              </thead>

              <tbody>
                
                <?php 
                $totalamt=0;
                $totalprofit=0;
                if(mysqli_num_rows($result) > 0) { 
                    while($row = $result->fetch_assoc()){ 
                ?>
                <tr>
                  <td><?php echo getCustomDate($row['bill_date']);?></td>
                  <td><?php echo $row['invoice_id'];?></td> 
                  <td><?php echo $row['payment_type'];?></td>
                  <td><?php echo '&#8377; '.formatmoney($row['billed_amount'],true);?></td>
                  <td><?php echo '&#8377; '.formatmoney($row['bill_profit'],true);?></td>
                </tr>
               <?php 
                
               $totalamt += $row['billed_amount'];
               $totalprofit += $row['bill_profit'];
                    }
                }
                
                ?>
                <tr>
                <td colspan="3" class="text-right">
                <strong>Total:</strong>
                </td>
                                <td><strong>
                                <?php echo '&#8377; '.formatmoney($totalamt,true);?>
                                </strong>
                </td>
                                <td><strong>
                                 <?php echo '&#8377; '.formatmoney($totalprofit,true);?>
                                </strong>
                </td>
                </tr>
                </tbody>
                </table>
                </div>
                
                <div><center><small>This is a computer genereated report</small></center></div>
                
                </div>
                </div>
                <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
                
                <?php 
            }
            else{
                
                ?>
                              <div class="jumbotron">
                                  <h1>Oops!</h1> 
                                  <p>No invoice found.
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