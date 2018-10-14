<?php
//Page settings
include_once 'utilities.php';
$_GLOBALS['PRINTPAGE']='true';

$invoiceid=0;
$ordernum=0;
$customerid=0;
$billedamount=0;
$cashpaid=0;
$cashadvance=0;
$paytype='';
$taxflag=false;
$bill_date='';
$due_date='';
$cname='';
$cmobile='';

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

if(isset($_REQUEST['invoiceid'])){
    $invoiceid=clean($_REQUEST['invoiceid']);    
}

include_once 'header.php';
include_once 'navigator.php';
include_once '../app_config/pdocon.php';
include_once '../app_config/mysqlcon.php';

if($result=mysqli_query($link,"select * from invoice_details where is_deleted=0 and invoice_id=$invoiceid")){
    $row = $result->fetch_assoc();
    $ordernum=$row['ordernum'];
    $customerid=$row['customer_id'];
    $billedamount=$row['billed_amount'];
    $cashpaid=$row['cash_paid'];
    $cashadvance=$row['advance_amount'];
    $paytype=$row['payment_type'];
    $taxflag=($row['is_taxed']==1)?true:false;
    $bill_date=$row['bill_date'];
    $due_date=$row['due_date'];
    $paystatus=$row['payment_status'];
    
}


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



if($result=mysqli_query($link,"select * from customer where customer_id=$customerid")){
    $row = $result->fetch_assoc();
    $cname=$row['customer_name'];
    $cmobile=$row['customer_phone'];
    
}

?>

<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="index.php">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
          <a href="sales.php">Sales</a>
        </li>
        <li class="breadcrumb-item active">Invoice</li>
      </ol>
       
       <!-- Invoice DataTables Card-->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fa fa-file-text"></i> Invoice
          
           <button id="printbutton" name="printbutton" class="text-center btn btn-success btn-sm btn-default">
           <i class="fa fa-print"></i> Print
			</button>
			
			
          </div>
          <div class="card-body">
          
			<div class="printcontent" id="printcontent">
			
            	<div style="margin: 0 auto; padding: 20px; width: 900px; font-weight: normal;">
            	<div style="width: 100%; height: 190px;" >
            	<div style="width: 900px; float: left;">
            	<center>
            	<div style="font:bold 25px 'Aleo';">Sales Receipt</div>
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
            	<div>
            	</div>
            	</div>
            	<div style="float: left; height: 70px;">
            	<table cellpadding="3" cellspacing="0" style="font-family: arial; font-size: 12px;text-align:left;width : 100%;">
            
            		<tr>
            			<td>Order No. :</td>
            			<td><?php echo $invoiceid; ?></td>
            		</tr>
            		<tr>
            			<td>Ref No. :</td>
            			<td><?php echo $ordernum; ?></td>
            		</tr>
            		<tr>
            			<td>Date :</td>
            			<td><?php echo getCustomDate($bill_date); ?></td>
            		</tr>
            	</table>
            	
            	</div>
            	<div style="float: right; height: 70px;">
            	<table cellpadding="3" cellspacing="0" style="font-family: arial; font-size: 12px;text-align:left;width : 100%;">
            
            		<tr>
            			<td>Customer Name: </td>
            			<td>
            			<?php 
            			
            			if(trim($cname)==''){
            			    echo 'NA';
            			}else{
            			      echo $cname;  
            			    }
            			?></td>
            		</tr>
            		<tr>
            			<td>Mobile :</td>
            			<td><?php
            			
            			if(trim($cmobile)==''){
            			    echo 'NA';
            			}else{
            			    echo $cmobile;
            			}
                        ?>
                        </td>
            		</tr>
            	</table>
            	
            	</div>
            	<div class="clearfix"></div>
            	</div>
            	<div style="width: 100%; margin-top:-70px;">
            	<table border="1" cellpadding="4" cellspacing="0" style="font-family: arial; font-size: 12px;	text-align:left;" width="100%">
            		<thead>
            			<tr>
            				<th>ID</th>
            				<th width="90"> Product Code </th>
            				<th> Product Name </th>
            				<th> Qty </th>
            				<th> Price </th>
            				<th> Amount </th>
            			</tr>
            		</thead>
            		<tbody>
            			
            				<?php
            					$result = $db->prepare("SELECT * FROM sales_order WHERE is_deleted=0 and ordernum=:userid order by sale_id asc");
            					$result->bindParam(':userid', $ordernum);
            					$result->execute();
            					for($i=0; $row = $result->fetch(); $i++){
            				?>
            				<tr class="record">
            				<td><?php echo ($i+1);?></td>
            				<td><?php echo $row['item_code']; ?></td>
            				<td><?php echo $row['item_name']; ?></td>
            				<td><?php echo $row['bill_qty']; ?></td>
            				<td>
            				<?php
            				$ppp=$row['bill_price'];
            				echo '&#8377; '.formatMoney($ppp, true);
            				?>
            				</td>
            				<td>
            				<?php
            				$dfdf=$row['bill_amount'];
            				echo '&#8377; '.formatMoney($dfdf, true);
            				?>
            				</td>
            				</tr>
            				<?php
            					}
            				?>
            				
            				<?php 
            				if($taxflag){
            				    $result = $db->prepare("SELECT * FROM sales_tax WHERE is_deleted=0 and ordernum=:userid");
            				    $result->bindParam(':userid', $ordernum);
            				    $result->execute();
            				    for($i=0; $row = $result->fetch(); $i++){
            				    
            				?>
            				<tr>
            					<td colspan="5" style=" text-align:right;"><strong style="font-size: 12px;">GST: &nbsp;</strong></td>
            					<td colspan="2"><strong style="font-size: 12px;">
            					<?php

            					echo '&#8377; '.formatMoney($row['tax_amount'], true);

            					?>
            					</strong></td>
            				</tr>
            				
            				
            				<?php 
            				        }
                                }?>
            			
            				<tr>
            					<td colspan="5" style=" text-align:right;"><strong style="font-size: 12px;">Total: &nbsp;</strong></td>
            					<td colspan="2"><strong style="font-size: 12px;">
            					<?php

            					echo '&#8377; '.formatMoney($billedamount, true);

            					?>
            					</strong></td>
            				</tr>

                                <?php 
            				    if($paytype=='cash'){
            				?>
            				<tr>
            					<td colspan="5"style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">Cash Tendered:&nbsp;</strong></td>
            					<td colspan="2"><strong style="font-size: 12px; color: #222222;">
            					<?php echo '&#8377; '.formatMoney($cashpaid,true);?> 
            					</strong></td>
            				</tr>

            				<tr>
            					<td colspan="5" style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">
            					<font style="font-size:20px;">
        						Change:&nbsp;
            					</strong></td>
            					<td colspan="2"><strong style="font-size: 15px; color: #222222;">
            					<?php
            					
            					$change=$cashpaid-$billedamount;
            					if($change >=0) {
            					    echo '&#8377; '.formatMoney($change,true);
            					}
            		
            					?>
            					</strong></td>
            				</tr>
            			    <?php
            				    }elseif ($paytype=='credit'){
            				        ?>
            				    <tr>
            					<td colspan="5"style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">Payment Type:&nbsp;</strong></td>
            					<td colspan="2"><strong style="font-size: 12px; color: #222222;">
            					Credit
            					</strong></td>
            				</tr>

            				<tr>
            					<td colspan="5" style=" text-align:right;"><strong style="font-size: 12px; color: #222222;">
            					<font style="font-size:20px;">
            					<?php 
            					if ($paystatus=='S'){
            					    echo "Due Date:";
            					}
            					
            					?>
        						&nbsp;
            					</strong></td>
            					<td colspan="2"><strong style="font-size: 15px; color: #222222;">
            					
            					<?php 
            					if ($paystatus=='S'){
            					    echo getCustomDate($due_date);
            					}elseif($paystatus=='C'){
            					    echo 'Cash Paid';
            					}
            					
            					?>
            
            					</strong></td>
            				</tr>    
            				        
            				        <?php
            				    }
            				?>
            		</tbody>
            	</table>
            	
            	</div>
            	</div>
			     <div><center><small>This is a computer genereated invoice</small></center></div>
			</div>
			<!-- /. print page content -->
          
          
          
          </div>


      </div>
      </div>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->


<?php 
include_once 'footer.php';

?>